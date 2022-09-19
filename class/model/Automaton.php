<?php

namespace model;

class Automaton extends WPCustomPostType
{
    /**
     * @param $serviceID
     * @return array
     */
    public function getByServiceID($serviceID): array
    {
        return self::Get('automaton', 'model\Automaton', array(
            'key' => 'ServiceID',
            'value' => $serviceID,
            'compare' => '=',
            'type' => 'NUMERIC',
        ));
    }

    /**
     * @return array
     */
    public function getActiveS(): array
    {
        return self::Get(
            'automaton',
            'model\Automaton',
            [
                'key' => 'Automaton_Status',
                'value' => 'active',
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
            'automaton',
            'model\Automaton',
            [
                'key' => 'Automaton_Status',
                'value' => 'inactive',
                'compare' => '=',
                'type' => 'CHAR'
            ]
        );
    }

    /**
     * @param bool $val
     * @return bool|true
     */
    public function updateStatus(bool $val = true): bool
    {
        return $this->updatePostMeta('Automaton_Status', $val);
    }
}