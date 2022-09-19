<?php


namespace model;
class WPTaxonomy
{
    private int $ID;
    private string $name = '';
    private string $slug = '';


    /**
     * model\WPTaxonomy constructor.
     * @param int $ID
     */
    public function __construct(int $ID = 0)
    {

    }
}