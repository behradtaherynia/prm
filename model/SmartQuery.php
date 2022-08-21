<?php


class SmartQuery
{
// region Class Properties::


    private array $select = [];
    private string $from = '';
    private array $where = [];
    private string $orderBy = 'ID';
    private string $orderType = 'ASC';
// endregion

// region Class Constructor::

    /**
     * SmartQuery constructor.
     */
    public function __construct()
    {
    }
//endregion


// region Class Public Functions

    /**
     * @param string $table
     * @param array $data
     * @param array | null $format
     * @return object | false (object | false) single return
     */
    public function insert(string $table, array $data, array $format = null)
    {
        global $wpdb;
        /*
         * (int|false) The number of rows inserted, or false on error.
         */
        $insertedStatus = $wpdb->insert(
            $table,
            $data,
            $format,
        );
        $insertedID = $wpdb->insert_id;
        if ($insertedStatus == false) {
            return false;
        } else {
            $query = new SmartQuery();
            $query->select('*', $table);
            $query->from($table);
            $query->where('ID', $table, '=', $insertedID);
            return $query->execute()[0];
        }

    }

    /**
     * @param string $table
     * @param array $data
     * @param array $where
     * @param array|string|null $format
     * @param array|string|null $whereFormat
     * @return array | false (array | false)
     */
    public function update(string $table, array $data, array $where, $format = null, $whereFormat = null)
    {
        global $wpdb;
        /*
         * (int|false) The number of rows inserted, or false on error.
         */
        $updatedCounts = $wpdb->update(
            $table,
            $data,
            $where,
            $format,
            $whereFormat
        );
        if ($updatedCounts != false) {
            $query = new SmartQuery();
            $query->select('*', $table);
            $query->from($table);
            foreach ($where as $key => $value) {
                $query->where($key, $table, '=', $value, count($where) > 1 ? 'AND' : '');
            }
            return $query->execute()[0];
        } else
            return false;

    }

//endregion

// region Class Public Functions:: SELECT

    /**
     * @param string $field
     * @param string $table
     */
    public function select(string $field, string $table)
    {
        if ($field == '*')
            $this->select[] = ' * ';
        else
            $this->select[] = $table . '.' . $field;

    }

    /**
     * @param string $table :: for select from only one table
     */
    public function from(string $table)
    {
        $this->from = $table;
    }

    /**
     * @param string $table2
     * @param string $field1
     * @param string $field2
     */
    public function join(string $table2, string $field1, string $field2)
    {
        $table1 = $this->from;
        $this->from = '(' . $table1 . ' INNER JOIN ' . $table2 . ' ON ' . $table1 . '.' . $field1 . '=' . $table2 . '.' . $field2 . ')';
    }

    /**
     * @param string $field
     * @param string $table
     * @param string $operator :: '=' , '!=' , '>' , '>=' , '<' , '<=' , 'LIKE' , 'LIKE%%' , 'NOT LIKE' , 'BETWEEN' , 'IS NULL' , 'IS'
     * @param string $value
     * @param string $relation
     */
    public function where(string $field, string $table, string $operator, $value = '', string $relation = '')
    {
        $whereItem = $table . '.' . $field . ' ' . $operator;
        if ($operator != 'IS NULL' && $operator != 'IS NOT NULL')
            $whereItem .= " '" . $value . "'";

        if ($relation == '') {
            if (count($this->where) > 0)
                $this->where[] = 'AND ' . $whereItem;
            else
                $this->where[] = $whereItem;
        } else
            $this->where[] = ' ' . $relation . ' ' . $whereItem;
    }

    /**
     * @param string $by
     * @param string $type ASC or DESC
     */
    public function order(string $by = 'ID', string $type = 'ASC')
    {
        $this->orderType = $type;
        $this->orderBy = $by;
    }

// endregion

// region Class Public Functions:: EXECUTE

    /**
     * @return null | string
     */
    public function queryGenerate(): ?string
    {
        if (count($this->select) != 0 && $this->from != '') {
            $query = 'SELECT ' . implode(' , ', $this->select) . ' ';
            $query .= 'FROM ' . $this->from . ' ';
            if (count($this->where) > 0)
                $query .= 'WHERE ' . implode(' ', $this->where) . ' ';
            $query .= 'ORDER BY ' . $this->orderBy . ' ' . $this->orderType . ' ';
            return $query;
        } else
            return null;
    }

    /**
     * @param string $output :: ARRAY_A | ARRAY_N | OBJECT | OBJECT_K
     * @return array :: array returned
     */
    public function execute(string $output = 'OBJECT'): array
    {
        global $wpdb;
        $query = $this->queryGenerate();
        if ($query != null) {
            $result = $wpdb->get_results($query, $output);
            if ($result != null)
                return $result;
        }
        return [];
    }

// endregion


}