<?php

namespace db;
class UpdateData
{

    private string $table;
    private array  $data;
    private array  $whereData;
    private array  $format;
    private array  $whereFormat;

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
    public function addData(string $key, string $value, string $format): UpdateData
    {
        $this->data[$key] = $value;
        $this->format[] = $format;
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @param string $format
     * @return $this
     */
    public function addConditionData(string $key, string $value, string $format): UpdateData
    {
        $this->whereData[$key] = $value;
        $this->whereFormat[] = $format;
        return $this;
    }

    /**
     * @return int|false (int|false) The number of rows inserted, or false on error.
     */
    public function save()
    {
        global $wpdb;
        $wpdb->update(
            $this->table,
            $this->data,
            $this->whereData,
            $this->format,
            $this->whereFormat,
        );
        return $wpdb->insert_id;
    }

    //endregion

}