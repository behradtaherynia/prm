<?php

class Patient
{
//region class properties
    private int $ID;
    private int $IDCode;
    private string $name;
    private string $lastName;
    private string $fullName;
    private string $phone;
    private string $address;
//endregion

//region class constructor
    /**
     * @param int $ID
     * @param int $IDCode
     * @param int $name
     * @param int $lastName
     * @param int $fullName
     * @param int $phone
     * @param int $address
     */
    public function __construct(int $ID)
    {
        $this->ID = $ID;
        global $wpdb;
        if ($this->ID > 0) {
            $query = new SmartQuery();
            $query->select('*', $wpdb->prefix . 'patient');
            $query->from($wpdb->prefix . 'patient');
            $query->where('patient_id', $wpdb->prefix . 'patient', '=', $ID);
            $result = $query->execute();
            if ($result) {
                $this->IDCode = $result[0]->id_code;
                $this->name = $result[0]->name;
                $this->lastName = $result[0]->lastname;
                $this->fullName = $result[0]->full_name;
                $this->phone = $result[0]->phone;
                $this->address = $result[0]->address;
            }
        }
    }

    //endregion

//region getter functions
    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->ID;
    }

    /**
     * @return int
     */
    public function getIDCode(): int
    {
        return $this->IDCode;
    }

    /**
     * @return int
     */
    public function getName(): int
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getLastName(): int
    {
        return $this->lastName;
    }

    /**
     * @return int
     */
    public function getFullName(): int
    {
        return $this->fullName;
    }

    /**
     * @return int
     */
    public function getPhone(): int
    {
        return $this->phone;
    }

    /**
     * @return int
     */
    public function getAddress(): int
    {
        return $this->address;
    }
//endregion


//region CRUD functions
    /**
     * @param int $IDCode
     * @param string $name
     * @param string $lastName
     * @param string $phone
     * @param string $address
     * @return false|Patient
     */
    public static function Insert(int $IDCode, string $name, string $lastName, string $phone, string $address)
    {
        global $wpdb;
        $query = new SmartQuery();
        $table = $wpdb->prefix . 'patient';

        $data['id_code'] = $IDCode;
        $format[] = '%d';

        $data['name'] = $name;
        $format[] = '%s';

        $data['last_name'] = $lastName;
        $format[] = '%s';

        $data['full_name'] = $name . ' ' . $lastName;
        $format[] = '%s';

        $data['phone'] = $phone;
        $format[] = '%s';

        $data['address'] = $address;
        $format[] = '%d';

        $data['date'] = current_time('mysql');
        $format[] = '%s';

        $insertedObject = $query->insert($table, $data, $format);
        return !$insertedObject ? false : new Patient($insertedObject->ID);
    }

    /**
     * @param int $IDCode
     * @return array|false
     */
    public function updateIDCode(int $IDCode)
    {
        $data['id_code'] = $IDCode;
        $where['ID'] = $this->getID();
        global $wpdb;
        $query = new SmartQuery();
        return $query->update($wpdb->prefix . 'patient', $data, $where);

    }

    /**
     * @param string $name
     * @return array|false
     */
    public function updateName(string $name)
    {
        $data['name'] = $name;
        $where['ID'] = $this->getID();
        global $wpdb;
        $query = new SmartQuery();
        return $query->update($wpdb->prefix . 'patient', $data, $where);
    }

    /**
     * @param string $lastName
     * @return array|false
     */
    public function updateLastName(string $lastName)
    {
        $data['last_name'] = $lastName;
        $where['ID'] = $this->getID();
        global $wpdb;
        $query = new SmartQuery();
        return $query->update($wpdb->prefix . 'patient', $data, $where);
    }

    /**
     * @return array|false :: Updates fullName using current first and last name
     */
    public function updateFullName()
    {
        $data['full_name'] = $this->getName() . ' ' . $this->getLastName();
        $where['ID'] = $this->getID();
        global $wpdb;
        $query = new SmartQuery();
        return $query->update($wpdb->prefix . 'patient', $data, $where);
    }

    /**
     * @param string $phone
     * @return array|false
     */
    public function updatePhone(string $phone)
    {
        $data['phone'] = $phone;
        $where['ID'] = $this->getID();
        global $wpdb;
        $query = new SmartQuery();
        return $query->update($wpdb->prefix . 'patient', $data, $where);
    }

    /**
     * @param string $address
     * @return array|false
     */
    public function updateAddress(string $address)
    {
        $data['address'] = $address;
        $where['ID'] = $this->getID();
        global $wpdb;
        $query = new SmartQuery();
        return $query->update($wpdb->prefix . 'patient', $data, $where);
    }
//endregion

}