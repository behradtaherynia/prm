<?php


namespace model;

class PostHashtag extends WPTerm
{

    /**
     * @return PostHashtag
     */
    public function getParent(): PostHashtag
    {
        return new PostHashtag($this->parentID);
    }

// region Class Public Static Functions::

    /**
     * @param int $postID
     * @return PostHashtag[]
     */
    public static function GetHashtags(int $postID): array
    {
        return parent::GetTerms($postID, 'post_hashtag', 'model\PostHashtag');
    }


//endregion
}