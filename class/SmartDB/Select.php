<?php

namespace SmartDB;

class Select
{

    private string $query;

    /**
     * @param string $query
     */
    public function __construct(string $query)
    {
        $this->query = $query;
    }

    //region after this step

    /**
     * @param string $table
     * @return From
     */
    public function from(string $table): From
    {

        $query = $this->query . ' From ' . $table;


        return new From($query);
    }
    //endregion

}