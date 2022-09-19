<?php

namespace model;

use SmartDB\DB;
use SmartDB\UpdateData;

class Patient
{
//region class properties
    private int $ID;
    private int $IDCode;
    private string $name;
    private string $lastName;
    private string $phone;
    private string $address;
//endregion

//region class constructor
    /**
     * @param int $ID
     */
    public function __construct(int $ID)
    {
        global $wpdb;
        if ($ID > 0) {

            $this->ID = $ID;
            $db = new DB();
            $result = $db->select()->from($wpdb->prefix . 'patient')->where('patient_id')->equalTo($ID)->execute();
//            $query = new SmartQuery();
//            $query->select('*', $wpdb->prefix . 'patient');
//            $query->from($wpdb->prefix . 'patient');
//            $query->where('patient_id', $wpdb->prefix . 'patient', '=', $ID);
//            $result = $query->execute();
            if ($result) {
                $this->IDCode = $result[0]->id_code;
                $this->name = $result[0]->name;
                $this->lastName = $result[0]->last_name;
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->getName() . $this->getLastName();
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }
//endregion


//region CRUD functions


    /**
     * @param int $IDCode
     * @return array|false
     */
    public function updateIDCode(int $IDCode)
    {
        global $wpdb;

        $query = new UpdateData($wpdb->prefix . 'patient', 'id_code', $IDCode, '%s');
        $result = $query->addConditionData('patient_id', $this->getID(), '%s')->save();
        return $result == true;

    }

    /**
     * @param string $name
     * @return bool
     */
    public function updateName(string $name): bool
    {
        global $wpdb;

        $query = new UpdateData($wpdb->prefix . 'patient', 'name', $name, '%s');
        $result = $query->addConditionData('patient_id', $this->getID(), '%s')->save();
        return $result == true;
    }

    /**
     * @param string $lastName
     * @return bool
     */
    public function updateLastName(string $lastName): bool
    {
        global $wpdb;

        $query = new UpdateData($wpdb->prefix . 'patient', 'last_name', $lastName, '%s');
        $result = $query->addConditionData('patient_id', $this->getID(), '%s')->save();
        return $result == true;
    }

    /**
     * @param string $phone
     * @return array|false
     */
    public function updatePhone(string $phone)
    {
        global $wpdb;

        $query = new UpdateData($wpdb->prefix . 'patient', 'phone', $phone, '%s');
        $result = $query->addConditionData('patient_id', $this->getID(), '%s')->save();
        return $result == true;
    }

    /**
     * @param string $address
     * @return array|false
     */
    public function updateAddress(string $address)
    {
        global $wpdb;

        $query = new UpdateData($wpdb->prefix . 'patient', 'address', $address, '%s');
        $result = $query->addConditionData('patient_id', $this->getID(), '%s')->save();
        return $result == true;
    }

    public function updateAll(string $IDCode, string $name, string $lastName, string $phone, string $address): bool
    {
        global $wpdb;

        $query = new UpdateData($wpdb->prefix . 'patient', 'id_code', $IDCode, '%s');
        $result = $query->addData('name',$name,'%s')->addData('last_name',$lastName,'%s')->addData('phone',$phone,'%s')->addData('address',$address,'%s')->addConditionData('patient_id', $this->getID(), '%s')->save();
        return $result == true;
    }

//endregion

    /**
     * @param int $IDCode
     * @param string $name
     * @param string $lastName
     * @param string $phone
     * @param string $address
     * @return false|Patient
     */
    public static function Insert(string $IDCode, string $name, string $lastName, string $phone, string $address)
    {
        global $wpdb;

        $query = new db();
        $result = $query->insert($wpdb->prefix . 'patient')->addData('id_code', $IDCode, '%s')->addData('name', $name, '%s')->addData('last_name', $lastName, '%s')->addData('phone', $phone, '%s')->addData('address', $address, '%s')->save();
        return $result == true ? new self($result) : false;
//        $query = new SmartQuery();
//        $table = $wpdb->prefix . 'patient';
//
//        $data['id_code'] = $IDCode;
//        $format[] = '%d';
//
//        $data['name'] = $name;
//        $format[] = '%s';
//
//        $data['last_name'] = $lastName;
//        $format[] = '%s';
//
//        $data['full_name'] = $name . ' ' . $lastName;
//        $format[] = '%s';
//
//        $data['phone'] = $phone;
//        $format[] = '%s';
//
//        $data['address'] = $address;
//        $format[] = '%d';
//
//        $data['date'] = current_time('mysql');
//        $format[] = '%s';
//
//        $insertedObject = $query->insert($table, $data, $format);
//        return !$insertedObject ? false : new Patient($insertedObject->ID);
    }

    public static function doesExist($IDCode)
    {
        global $wpdb;

        $query = new \SmartDB\DB();
        $result = $query->select('*')->from($wpdb->prefix . 'patient')->where('id_code')->equalTo($IDCode)->execute();
        if ($result) {
            return new Patient($result[0]->patient_id);
        } else {
            return false;
        }

    }
}