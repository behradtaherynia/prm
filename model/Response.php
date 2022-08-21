<?php

class Response
{

//region class properties
    private int $ID;
    private int $clientID;
    private string $dossierID;
    private string $fieldID;
    private string $formID;
    private string $answer;
    private string $date;
//endregion

//region class constructor
    /**
     * @param int $ID
     */
    public function __construct(int $ID)
    {
        $this->ID = $ID;
        global $wpdb;
        if ($this->ID > 0) {
            $query = new SmartQuery();
            $query->select('*', $wpdb->prefix . 'response');
            $query->from($wpdb->prefix . 'response');
            $query->where('response_id', $wpdb->prefix . 'response', '=', $ID);
            $result = $query->execute();
            if ($result) {
                $this->clientID = $result[0]->client_id;
                $this->dossierID = $result[0]->dossier_id;
                $this->fieldID = $result[0]->field_id;
                $this->formID = $result[0]->form_id;
                $this->answer = $result[0]->answer;
                $this->date = $result[0]->date;
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
     * @return Client
     */
    public function getClientID(): Client
    {
        return new Client($this->clientID);
    }

    /**
     * @return Dossier
     */
    public function getDossierID(): Dossier
    {
        return new Dossier($this->dossierID);
    }

    /**
     * @return Field
     */
    public function getField(): Field
    {
        return new Field($this->fieldID);
    }

    /**
     * @return Form
     */
    public function getForm(): Form
    {
        return new Form($this->formID);
    }

    /**
     * @return string
     */
    public function getAnswer(): string
    {
        return $this->answer;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

//endregion


//region CRUD functions
    public static function Insert(int $clientID, int $dossierID, int $questionID, int $questionageID, string $answer)
    {
        global $wpdb;
        $query = new SmartQuery();
        $table = $wpdb->prefix . 'patient';

        $data['client_id'] = $clientID;
        $format[] = '%d';

        $data['dossier_id'] = $dossierID;
        $format[] = '%d';

        $data['question_id'] = $questionID;
        $format[] = '%d';

        $data['questionage_id'] =$questionageID;
        $format[] = '%d';

        $data['answer'] = $answer;
        $format[] = '%s';

        $data['date'] = current_time('mysql');
        $format[] = '%s';

        $insertedObject = $query->insert($table, $data, $format);
        return !$insertedObject ? false : new PatientHistory($insertedObject->ID);
    }

//endregion


}