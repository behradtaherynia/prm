<?php

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
        return Treatment::GetTreatmentsByDossierID($this->getClient(),$this->getID()) ;
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

    public function getPreceptions()
    {

    }

    public function getFollowUps()
    {

    }

    public function getPatient()
    {
        
    }

}