<?php


class PostCategory extends WPTerm
{


    /**
     * @return PostCategory
     */
    public function getParent(): PostCategory
    {
        return new PostCategory($this->parentID);
    }


}