<?php

namespace SmartDB;
class InsertData
{
    private string $table;
    private array  $data;
    private array  $format;

    /**
     * @param string $table
     * @param string $key
     * @param string $value
     * @param string $format
     */
    public function __construct(string $table, string $key, string $value, string $format)
    {
        $this->table = $table;
        $this->data[$key] = $value;
        $this->format[] = $format;
    }

    //region after this step

    /**
     * @param string $key
     * @param string $value
     * @param string $format
     * @return $this
     */
    public function addData(string $key, string $value, string $format): InsertData
    {
        $this->data[$key] = $value;
        $this->format[] = $format;
        return $this;
    }

    /**
     * @return int|false (int|false) The number of rows inserted, or false on error.
     */
    public function save()
    {
        global $wpdb;
        $wpdb->insert(
            $this->table,
            $this->data,
            $this->format,
        );
        return $wpdb->insert_id;
    }

    //endregion

}