<?php

namespace model;

class Question extends WPCustomPostType
{
    /**
     * @return array
     */
    public function getActiveS(): array
    {
        return self::Get(
            'question',
            'model\Question',
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
            'model\Question',
            [
                'key' => 'Question_Status',
                'value' => false,
                'compare' => '=',
                'type' => 'CHAR'
            ]
        );
    }

    public function getNumberUsed()
    {

    }

    public function getNumberAnswered()
    {

    }

    public function getType()
    {
        return $this->getPostMeta('Question_type');
    }

}