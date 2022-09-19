<?php

namespace model;

use function current_time;

class PatientHistory
{

//region class properties
    private int $ID;
    private int $clientID;
    private int $dossierID;
    private int $questionID;
    private int $questionageID;
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
            $query->select('*', $wpdb->prefix . 'patient_history');
            $query->from($wpdb->prefix . 'patient_history');
            $query->where('patient_history_id', $wpdb->prefix . 'patient_history', '=', $ID);
            $result = $query->execute();
            if ($result) {
                $this->clientID = $result[0]->client_id;
                $this->dossierID = $result[0]->dossier_id;
                $this->questionID = $result[0]->question_id;
                $this->questionageID = $result[0]->questionage_id;
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
     * @return Question
     */
    public function getQuestionID(): Question
    {
        return new Question($this->questionID);
    }

    /**
     * @return Questionage
     */
    public function getQuestionageID(): Questionage
    {
        return new Questionage($this->questionageID);
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

        $data['questionage_id'] = $questionageID;
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