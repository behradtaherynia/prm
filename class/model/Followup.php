<?php

namespace model;

use function current_time;
use function get_post;

class Followup
{
    private int $ID;
    private int $statusID;
    private int $typeID;
    private int $contentTypeID;
    private int $formID;
    private int $sessionID;
    private string $date;

//region public getters functions

    /**
     * @param int $ID
     */
    public function __construct(int $ID)
    {
        global $wpdb;
        $this->ID = $ID;
        if ($this->ID > 0) {
            $query = new SmartQuery();
            $query->select('*', $wpdb->prefix . 'followup');
            $query->from($wpdb->prefix . 'followup');
            $query->where('ID', $wpdb->prefix . 'followup', '=', $ID);
            $result = $query->execute();

            if ($result) {
                $this->statusID = $result[0]->status_id;
                $this->typeID = $result[0]->type_id;
                $this->contentTypeID = $result[0]->content_type_id;
                $this->formID = $result[0]->form_id;
                $this->sessionID = $result[0]->session_id;
                $this->date = $result[0]->date;
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
     * @return int
     */
    public function getStatusID(): int
    {
        return $this->statusID;
    }

    /**
     * @return int
     */
    public function getTypeID(): int
    {
        return $this->typeID;
    }

    /**
     * @return int
     */
    public function getContentTypeID(): int
    {
        return $this->contentTypeID;
    }

    /**
     * @return int
     */
    public function getFormID(): int
    {
        return $this->formID;
    }

    /**
     * @return int
     */
    public function getSessionID(): int
    {
        return $this->sessionID;
    }

    /**
     * @return SmartDate
     */
    public function getDate(): SmartDate
    {
        return new SmartDate($this->date, 'string');
    }

    public function getStatus()
    {

    }

    public function getType()
    {

    }

    public function getContentType()
    {

    }

    /**
     * @return Session|null
     */
    public function getSession(): ?Session
    {
        $result = get_post(intval($this->sessionID));
        if ($result != null && $result->post_type == 'session') {
            return new Session($result->ID);
        } else {
            return null;
        }
    }

    public function getTreatment(): Treatment
    {
        $result = $this->getSession();
        $treatment = $result->getTreatment();
        return new Treatment($treatment->ID);
    }

    public function getDossier(): Dossier
    {
        $treatment = $this->getTreatment();
        $dossierID = $treatment->getDossier();
        return new Dossier($dossierID);
    }

    /**
     * @return Patient
     */
    public function getPatient(): Patient
    {
        $dossier = $this->getDossier();
        return new Patient($dossier->getPatient());

    }


//endregion

//region CRUD functions
    /**
     * @param int $typeID
     * @param int $contentTypeID
     * @param int $statusID
     * @param int|null $formID
     * @param int|null $sessionID
     * @return false|Followup
     */
    public static function Insert(int $typeID, int $contentTypeID, int $statusID, int $formID = null, int $sessionID = null)
    {
        global $wpdb;
        $query = new SmartQuery();
        $table = $wpdb->prefix . 'followup';

        $data['form_id'] = $formID;
        $format[] = '%d';

        $data['session_id'] = $sessionID;
        $format[] = '%d';

        $data['type_id'] = $typeID;
        $format[] = '%d';

        $data['content_type_id'] = $contentTypeID;
        $format[] = '%d';

        $data['status_id'] = $statusID;
        $format[] = '%d';

        $data['date'] = current_time('mysql');
        $format[] = '%s';

        $insertedObject = $query->insert($table, $data, $format);
        return !$insertedObject ? false : new Followup($insertedObject->ID);
    }

    /**
     * @param int $statusID
     * @return array|false
     */
    public function updateStatusID(int $statusID)
    {
        $data['status_id'] = $statusID;
        $where['ID'] = $this->getID();
        global $wpdb;
        $query = new SmartQuery();
        return $query->update($wpdb->prefix . 'followup', $data, $where);

    }

//endregion


}