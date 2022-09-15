<?php

namespace db;

class DB
{
    private string $query;

    public function __construct()
    {
    }

    //region after this step

    /**
     * args :: اگر وارد نشود به معنی * و در غیر این صورت هر پارامتر به عنوان یکی از ستون‌های دیتابیس خواهد بود
     * sample :: ['ID','title'] or ['ID.table','title.table']
     * @return Select
     */
    public function select(): Select
    {
        if (func_num_args() == 0)
            $query = 'SELECT *';

        else
            $query = 'SELECT ' . implode(',', func_get_args());


        return new Select($query);
    }

    /**
     * @param string $table
     * @param array $data
     * @param array | null $format
     * @return object | false (object | false) single return
     */
    public function insert(string $intoTable)
    {
        return new Insert($intoTable);
    }

    /**
     * @param string $fromTable
     * @return Update
     */
    public function update(string $fromTable): Update
    {
        return new Update($fromTable);
    }

    //endregion
}