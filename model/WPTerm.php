<?php


abstract class WPTerm
{
    private int $ID;
    private string $name = '';
    private string $slug = '';
    private string $description = '';
    private int $taxonomyID = 0;
    protected int $parentID = 0;

    /**
     * WPTerm constructor.
     * @param int $ID
     */
    public function __construct(int $ID = 0)
    {
        $this->ID = $ID;
        if ($ID > 0) {
            $selectedTerm = get_term($ID);
            if ($selectedTerm != null) {
                $this->name = $selectedTerm->name;
                $this->slug = $selectedTerm->slug;
                $this->taxonomyID = $selectedTerm->term_taxonomy_id;
                $this->description = $selectedTerm->description;
                $this->parentID = $selectedTerm->parent;
            }

        }
    }

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->ID;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getChain(): string
    {
        return str_replace('-', '_', htmlspecialchars(rawurldecode($this->getSlug()), ENT_NOQUOTES, 'UTF-8'));
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return WPTaxonomy | bool
     */
    protected function getTaxonomy()
    {
        if ($this->taxonomyID == 0)
            return false;
        return new WPTaxonomy($this->taxonomyID);
    }

    abstract public function getParent();

    protected static function GetTerms(int $postID, string $taxonomy, string $className): array
    {
        $result = [];
        $array = get_the_terms($postID, $taxonomy);
        if ($array != false) {
            foreach ($array as $tag) {
                $result[] = new $className($tag->term_id);
            }
        }

        return $result;
    }

}