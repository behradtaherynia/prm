<?php

class Field extends WPCustomPostType
{
    protected static function __Insert(string $customPostType, string $className, string $title)
    {
        return parent::__Insert($customPostType, $className, $title);
    }
}