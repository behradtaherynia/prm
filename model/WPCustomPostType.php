<?php

abstract class WPCustomPostType extends WPClass
{
    private int $ID;

    public function __construct(int $ID)
    {
        $this->ID = $ID;
    }

//region Class Getter Functions::

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->ID;
    }

    /**
     * @param string $postType
     * @param string $CustomTaxonomy
     * @param array $termID
     * @return WP_Query
     */
    protected function getByCategoryID(string $postType, string $CustomTaxonomy, array $termID): WP_Query
    {
        $args = [
            'post_type' => "$postType",
            'tax_query' => [
                [
                    'taxonomy' => "$CustomTaxonomy",
//                    'field'    => 'slug',
//                    'terms'    => array( 'term1', 'term2' ),
                    'field' => 'term_id',
                    'terms' => $termID,
                    'include_children' => false // Remove if you need posts from term 7 child terms
                ],
            ],
            // Rest of arguments continues here
        ];
        return new WP_Query($args);
    }

    /**
     * @param string $postType
     * @param string $CustomTaxonomy
     * @param array $termSlug
     * @return WP_Query
     */
    protected function getByCategorySlug(string $postType, string $CustomTaxonomy, array $termSlug): WP_Query
    {
        $args = [
            'post_type' => "$postType",
            'tax_query' => [
                [
                    'taxonomy' => "$CustomTaxonomy",
                    'field' => 'slug',
                    'terms' => $termSlug,
//                    'field' => 'term_id',
//                    'terms' => $termSlug,
                    'include_children' => false // Remove if you need posts from term 7 child terms
                ],
            ],
            // Rest of arguments continues here
        ];
        return new WP_Query($args);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return get_the_title($this->getID());
    }

    /**
     * @param bool $editMode
     * @return string
     */
    public function getContent(bool $editMode = true): string
    {
        $result = get_the_content(null, false, $this->getID());
        return $editMode ? $result : apply_filters('the_content', $result);
//        return wp_strip_all_tags();
    }

    /**
     * @return string
     */
    public function getExcerpt(): string
    {
        return get_the_excerpt($this->getID());
    }

    /**
     * @return SmartDate
     */
    public function getDate(): SmartDate
    {
        return new SmartDate(get_post_time('U', false, $this->getID()));
    }

    /**
     * @return false|string|WP_Error
     */
    public function getPermalink()
    {
        $postURL = get_the_permalink($this->getID());
        return ($postURL == false) ? false : $postURL;
    }

    /**
     * @return string
     */
    public function getEditLink(): string
    {
        $editLink = get_edit_post_link($this->getID());
        return $editLink == null ? '' : $editLink;
    }

    /**
     * @return string
     */
    protected function getThumbnail(): string
    {
        return get_the_post_thumbnail_url($this->getID());
    }

    /**
     * @param string $attachmentDBKeyName
     * @return Attachment[]
     */
    protected function getAttachmentsBy(string $attachmentDBKeyName): array
    {
        $attachments = [];
        $attachmentsIDArray = $this->getPostMeta($attachmentDBKeyName, 'array');
        foreach ($attachmentsIDArray as $attachmentID) {
            $attachments[] = new Attachment($attachmentID);
        }
        return $attachments;
    }

    /**
     * @param string $key
     * @param string $metaValueType
     * @return array|int|string
     */
    protected function getPostMeta(string $key, string $metaValueType = 'string')
    {
        $metaValue = get_post_meta($this->getID(), $key, true);

        if ($metaValueType == 'int')
            return !$metaValue ? 0 : $metaValue;
        elseif ($metaValueType == 'bool')
            return $metaValue;
        elseif ($metaValueType == 'array')
            return !$metaValue ? [] : $metaValue;
//            return !$metaValue ? [] : unserialize($metaValue);
        else
            return !$metaValue ? '' : $metaValue;

    }

    protected function getActivation()
    {
       return $this->getPostMeta('Activation_Status');
    }
//endregion

//region update functions::

    /**
     * @param string $title
     * @return bool
     */
    public function updateTitle(string $title): bool
    {
//        Log::Insert(1, $this->getID(), $this->getTitle(), $title);

        global $wpdb;
        $query = new SmartQuery();
        $table = $wpdb->posts;
        $data = [
            'post_title' => $title,
        ];
        $where = [
            'ID' => $this->getID(),
        ];
        $format = [
            '%s',
        ];
        $whereFormat = [
            '%d',
        ];
        $updatedObject = $query->update($table, $data, $where, $format, $whereFormat);

        return $updatedObject != false;

    }

    /**
     * @param string $publishStatus
     * @return bool
     */
    public function updatePublishStatus(string $publishStatus = 'publish'): bool
    {

        global $wpdb;

        $query = new SmartQuery();
        $table = $wpdb->posts;
        $data = [
            'post_status' => $publishStatus,
        ];
        $where = [
            'ID' => $this->getID(),
        ];
        $format = [
            '%s',
        ];
        $whereFormat = [
            '%d',
        ];
        $updatedObject = $query->update($table, $data, $where, $format, $whereFormat);

        return $updatedObject != false;
    }

    /**
     * @param string $content
     * @return bool
     */
    public function updateContent(string $content): bool
    {
        Log::Insert(2, $this->getID(), $this->getContent(), $content);


        global $wpdb;

        $query = new SmartQuery();
        $table = $wpdb->posts;
        $data = [
            'post_content' => $content,
        ];
        $where = [
            'ID' => $this->getID(),
        ];
        $format = [
            '%s',
        ];
        $whereFormat = [
            '%d',
        ];
        $updatedObject = $query->update($table, $data, $where, $format, $whereFormat);

        return $updatedObject != false;
    }

    /**
     * @param string $date :: persian string -> 1392-02-23
     * @return bool
     */
    public function updateDate(string $date): bool
    {
        $publishDate = new SmartDate($date, 'string', 'jalali');

//        Log::Insert(3, $this->getID(), $this->getDate()->getDateStringJalali(), $publishDate->getDateStringJalali());


        global $wpdb;

        $query = new SmartQuery();
        $table = $wpdb->posts;
        $data = [
            'post_date' => $publishDate->getDateStringGregorian() . " 00:00:00",
        ];
        $where = [
            'ID' => $this->getID(),
        ];
        $format = [
            '%s',
        ];
        $whereFormat = [
            '%d',
        ];
        $updatedObject = $query->update($table, $data, $where, $format, $whereFormat);

        return $updatedObject != false;
    }

    /**
     * @param string $key
     * @param $value
     * @return true
     * key not exist            => insert       => must return true
     * key exist but value new  => update value => must return true
     * key exist but value same => return false => we return true
     */
    protected function updatePostMeta(string $key, $value): bool
    {
        update_post_meta($this->getID(), $key, $value);
        return true;
    }

    /**
     * @param int[] $attachments
     * @param string $attachmentDBKeyName
     * @param int $logTypeID
     * @return bool
     */
    protected function updateAttachmentsBy(array $attachments, string $attachmentDBKeyName, int $logTypeID): bool
    {
        // region Log Old Files Holder::
        $oldFiles = $this->getAttachmentsBy($attachmentDBKeyName);
        $oldFilesLinks = [];
        foreach ($oldFiles as $file) {
            $oldFilesLinks[] = $file->getAttachmentURL();
        }
        //endregion

        $result = $this->updatePostMeta($attachmentDBKeyName, serialize($attachments));

        // region New Old Files Holder::
        $newFiles = $this->getAttachmentsBy($attachmentDBKeyName);
        $newFilesLinks = [];
        foreach ($newFiles as $file) {
            $newFilesLinks[] = $file->getAttachmentURL();
        }
        //endregion

        Log::Insert($logTypeID, $this->getID(), implode('<br>', $oldFilesLinks), implode('<br>', $newFilesLinks));

        return $result;
    }

    protected function updateActivation($value): bool
    {
       return $this->updatePostMeta('Activation_Status', $value);
    }

//endregion

//region Static functions::
    /**
     * @param string $customPostType
     * @param string $className
     * @param array $metaQuery
     * @param int $count
     * @param SmartDate|null $from
     * @param SmartDate|null $to
     * @param string $orderBy
     * @param string $order
     * @return array
     */

    protected static function Get(
        string    $customPostType,
        string    $className,
        array     $metaQuery = [],
        int       $count = -1,
        SmartDate $from = null, SmartDate $to = null,
        string    $orderBy = 'date', string $order = 'DESC'
    ): array
    {
        if ($count < 1) $count = -1;
        if ($from == null) {
            $dateQuery['after'] = [];
        } else {
            $dateQuery['after'] = $from->getDateStringGregorian() . ' 00:00:00';
        }
        if ($to != null) {
            $dateQuery['before'] = $to->getDateStringGregorian() . ' 23:59:00';
        } else {
            $dateQuery['before'] = [];

        }
        $args = array(
            'post_type' => array($customPostType),
            'posts_per_page' => $count,
            'post_status' => array('publish', 'future'),
            'orderby' => $orderBy,
            'order' => $order,
            'date_query' => array(
                $dateQuery,
                'inclusive' => true
            ),
            'meta_query' => $metaQuery,
        );
        $list = new WP_Query($args);
        $listArray = $list->get_posts();
        return self::ConvertToObjectList($className, $listArray);

    }

    /**
     * @param string $customPostType
     * @param string $className
     * @return array
     */
    protected static function GetAll(string $customPostType, string $className): array
    {
        return WPCustomPostType::Get($customPostType, $className);

    }

    /**
     * @param string $className
     * @param int $ID
     * @return mixed
     */
    protected static function __Create(string $className, int $ID)
    {
        $_selectedObject = get_post($ID);
        return $_selectedObject == null || $_selectedObject->post_type != strtolower($className) ? false : new $className($ID);
    }

    /**
     * @param string $customPostType
     * @param string $className
     * @param string $title
     * @return Client|false
     */
    protected static function __Insert(string $customPostType, string $className, string $title)
    {
        $ID = wp_insert_post(
            array(
                'post_type' => $customPostType,
                'post_status' => 'publish',
                'post_title' => $title,
            )
        );
        return !is_wp_error($ID) ? new $className($ID) : false;
    }
//endregion

// region Class Protected Functions::

    protected function getSortablePropertiesList(): array
    {
        return [
            'ID' => $this->getID(),
        ];
    }

//endregion
}