<?php

namespace model;

class Form extends WPCustomPostType
{
    /**
     * @return array
     */
    public function getActiveS(): array
    {
        return self::Get(
            'form',
            'model\Form',
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
            'model\Question',
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