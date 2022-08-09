<?php

abstract class WPCustomPostType
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
     * @param int $categoryID
     * @return int[]|WP_Post[]
     */
    public function getByCategoryID(string $postType, int $categoryID)
    {
        $defaults_param = array(
            'numberposts'      	=> -1,
            'post_type'        	=> $postType,
            'category' 			=> $categoryID ,
            'suppress_filters'	=> false
        );
        return get_posts($defaults_param);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return get_the_title($this->getID());
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return get_the_content(null, null, $this->getID());
    }

    /**
     * @return string
     */
    public function getExcerpt(): string
    {
        return get_the_excerpt($this->getID());
    }

    /**
     * @return string
     */
    public function getPublishDate(): string
    {
        $postDate = get_the_date('', $this->getID());
        return $postDate == false ? false : $postDate;
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
     * @return false|string
     */
    public function getPostEditLink()
    {
        $editLink = get_edit_post_link($this->getID());
        return $editLink == null ? false : $editLink;
    }

    /**
     * @return string
     */
    protected function getThumbnail(): string
    {
        return get_the_post_thumbnail_url($this->getID());
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
    protected function updateThumbnail($thumbnail_id):bool
    {
       return set_post_thumbnail($this->getID(),$thumbnail_id);
    }

//endregion

}