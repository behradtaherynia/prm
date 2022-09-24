<?php

namespace model;

class Dossier extends WPCustomPostType
{
    public function getClient()
    {
        return $this->getPostMeta('ClientID', 'int');

    }

    /**
     * @return array
     */
    public function getTreatments(): array
    {
        return Treatment::GetTreatmentsByDossierID($this->getClient(), $this->getID());
    }

    public function getServices()
    {

    }

    public function getSessions()
    {

    }

    public function getAttachments()
    {

    }

    public function getPerceptions()
    {

    }

    public function getFollowUps()
    {

    }

    public function getPatient()
    {
        $patientID = $this->getPostMeta('PatientID', 'int');
        var_ex($patientID);
        return $patientID > 0 ? new Patient($patientID) : false;

    }

    /**
     * @return int
     */
    public function getDossierID(): int
    {
        return $this->getPostMeta('DossierID', 'int');

    }

    /**
     * @param int $value
     * @return bool
     */
    public function updateDossierID(int $value): bool
    {
        return $this->updatePostMeta('DossierID', $value);
    }

    /**
     * @param int $value
     * @return bool
     */
    public function updatePatient(int $value): bool
    {
        return $this->updatePostMeta('PatientID', $value);
    }

    /**
     * @return bool
     */
    public static function IsThisDossier(): bool
    {
        return WPInstrument::CheckCurrentCustomPostTypeInArray(self::GetServiceCustomPostTypes());

    }

    /**
     * @return string[]
     */
    public static function GetServiceCustomPostTypes(): array
    {
        return ['dossier'];
    }

    public static function DoesExist(int $patientID, int $clientID)
    {
        $result= self::Get('dossier', 'model\Dossier', [
            'relation' => 'AND',
            array(
                'key' => 'ClientID',
                'value' => $clientID,
                'compare' => '='
            ),
            array(
                'key' => 'PatientID',
                'value' => $patientID,
                'compare' => '='
            )
        ]);
        return $result==true?$result:false;
    }

}