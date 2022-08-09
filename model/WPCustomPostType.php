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
            return !$metaValue ? [] : unserialize($metaValue);
        else
            return !$metaValue ? '' : $metaValue;

    }
//endregion

//region update functions::

    /**
     * @param $title
     * @return bool
     */
    public function updateTitle($title): bool
    {
        global $wpdb;
        $data = array('post_title' => $title);
        $where = array('ID' => $this->getID());
        return $wpdb->update($wpdb->posts, $data, $where) > 0;
    }

    /**
     * @param $content
     * @return bool
     */
    public function updateContent($content): bool
    {
        global $wpdb;
        $data = array('post_content' => $content);
        $where = array('ID' => $this->getID());
        return $wpdb->update($wpdb->posts, $data, $where) > 0;
    }

    /**
     * @param $excerpt
     * @return bool
     */
    public function updateExcerpt($excerpt): bool
    {
        global $wpdb;
        $data = array('post_excerpt' => $excerpt);
        $where = array('ID' => $this->getID());
        return $wpdb->update($wpdb->posts, $data, $where) > 0;
    }

    /**
     * @param $publishDate
     * @return bool
     */
    public function updatePublishDate($publishDate): bool
    {
        global $wpdb;
        $data = array('post_date' => $publishDate);
        $where = array('ID' => $this->getID());
        return $wpdb->update($wpdb->posts, $data, $where) > 0;
    }

    /**
     * @param $thumbnail_id
     * @return bool|int
     */
    protected function updateThumbnail($thumbnail_id): bool
    {
        return set_post_thumbnail($this->getID(), $thumbnail_id);
    }

    protected function updateStatus()
    {

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
    protected static function Get(string $customPostType, string $className, array $metaQuery = [], int $count = -1, SmartDate $from = null, SmartDate $to = null, string $orderBy = 'date', string $order = 'DESC'): array
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