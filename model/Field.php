<?php

class Field extends WPCustomPostType
{
    protected static function __Insert(string $customPostType, string $className, string $title)
    {
        return parent::__Insert($customPostType, $className, $title);
    }

    /**
     * @return array
     */
    public function getActiveS(): array
    {
        return self::Get(
            'field',
            'Field',
            [
                'key' => 'Field_Status',
                'value' => true,
                'compare' => '=',
                'type' => 'CHAR'
            ]
        );
    }

    /**
     * @return array
     */
    public function getInactiveS(): array
    {
        return self::Get(
            'field',
            'Field',
            [
                'key' => 'Field_Status',
                'value' => false,
                'compare' => '=',
                'type' => 'CHAR'
            ]
        );
    }

    public function getNumberAnswered()
    {

    }

    /**
     * @param bool $val
     * @return bool|true
     */
    protected function updateStatus(bool $val = true): bool
    {
       return $this->updatePostMeta('Field_Status', $val);
    }



}