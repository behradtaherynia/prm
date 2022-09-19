<?php

namespace SmartDB;

class Update
{
    private string $table;

    /**
     * @param string $fromTable
     */
    public function __construct(string $fromTable)
    {
        $this->table = $fromTable;
    }

    //region after this step

    /**
     * @param string $key
     * @param string $value
     * @param string $format
     * @return InsertData
     */
    public function addData(string $key, string $value, string $format): InsertData
    {
        return new InsertData($this->table, $key, $value, $format);
    }

    //endregion

}