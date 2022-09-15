<?php

namespace db;

class Where
{
    private string $query;

    public function __construct(string $query)
    {
        $this->query = $query;
    }

    //region after this step

    /**
     * @param string $value
     * @return Operation
     */
    public function equalTo(string $value): Operation
    {
        $query = sprintf('%s = "%s"', $this->query, $value);
        return new Operation($query);
    }

    public function between(string $first, string $second): Operation
    {
        $query = sprintf('%s BETWEEN "%s" AND "%s"', $this->query, $first, $second);
        return new Operation($query);
    }
    //endregion


}