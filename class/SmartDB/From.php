<?php

namespace SmartDB;

class From
{
    private string $query;

    public function __construct(string $query)
    {
        $this->query = $query;

    }

    //region after this step
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
        $operation = new Operation($this->query);
        return $operation->execute($output);
    }

    public function where(string $field): Where
    {
        $query = $this->query . ' WHERE ' . $field;
        return new Where($query);
    }
    //endregion

}