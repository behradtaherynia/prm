<?php

class Form extends WPCustomPostType
{
    /**
     * @return array
     */
    public function getActiveS(): array
    {
        return self::Get(
            'form',
            'Form',
            [
                'key' => 'form_Status',
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
            'question',
            'Question',
            [
                'key' => 'Question_Status',
                'value' => false,
                'compare' => '=',
                'type' => 'CHAR'
            ]
        );
    }

    /**
     * @param bool $val
     * @return bool
     */
    protected function updateStatus(bool $val = true): bool
    {
        return $this->updatePostMeta('Field_Status', $val);
    }
}