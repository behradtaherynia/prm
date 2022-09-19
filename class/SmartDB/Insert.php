<?php

namespace SmartDB;

class Insert
{
    private string $table;

    /**
     * @param string $intoTable
     */
    public function __construct(string $intoTable)
    {
        $this->table = $intoTable;
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