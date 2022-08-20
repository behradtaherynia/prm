<?php

class Questionage extends WPCustomPostType
{
    /**
     * @return array
     */
    public function getActiveS(): array
    {
        return self::Get(
            'question',
            'Question',
            [
                'key' => 'Question_Status',
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


}