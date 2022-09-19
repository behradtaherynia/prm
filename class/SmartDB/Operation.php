<?php

namespace SmartDB;

class Operation
{
    private string $query;

    public function __construct(string $query)
    {
        $this->query = $query;
    }

    //region after this step

    /**
     * @return string
     */
    public function generateQuery(): string
    {
        return $this->query;
    }

    /**
     * @param string $output
     * @return array
     */
    public function execute(string $output = OBJECT): array
    {
        global $wpdb;
        $query = $this->generateQuery();
        if ($query != null) {
            $result = $wpdb->get_results($query, $output);
            if ($result != null)
                return $result;
        }
        return [];
    }

    /**
     * @param string $field
     * @return Where
     */
    public function and(string $field): Where
    {
        $query = $this->query . ' AND ' . $field;
        return new Where($query);
    }
    //endregion

}