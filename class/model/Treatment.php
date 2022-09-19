<?php

namespace model;

use const ARRAY_A;

class Treatment extends WPCustomPostType
{
    public function getActivation()
    {
        return parent::getActivation();
    }

    /**
     * @return Service
     */
    public function getService(): Service
    {
        $serviceID = $this->getPostMeta('ServiceID', 'int');
        return new Service($serviceID);
    }

    /**
     * @return array
     */
    public function getSessions(): array
    {
        return parent::Get('session', 'model\Session',
            array(
                'key' => 'TreatmentID',
                'value' => $this->getID(),
                'compare' => '=',
                'type' => 'NUMERIC',
            )
        );
    }

    /**
     * @return int
     */
    public function getDossier(): int
    {
        return $this->getPostMeta('DossierID', 'int');
    }

    /**
     * @return Patient
     */
    public function getPatient(): Patient
    {
        $patientID = $this->getPostMeta('PatientID', 'int');
        return new Patient($patientID);
    }


    public function getFollowups()
    {

    }

    public function getDoneFollowups()
    {

    }


    /**
     * @return array|object|stdClass[]|null
     */
    public function getDescriptions()
    {
        global $wpdb;
        $custom_post_type = 'session'; // define your custom post type slug here

        // A sql query to return all post contents
        $results = $wpdb->get_results($wpdb->prepare("SELECT ID, post_content FROM $wpdb->posts WHERE post_type = %s and post_status = 'publish'", $custom_post_type), ARRAY_A);
        // Return null if we found no results
        return !$results ? null : $results;
    }

    public function getNextSession()
    {

    }

    public function updateActivation($value): bool
    {
        return parent::updateActivation($value);
    }

    /**
     * @param $clientID
     * @param $dossierID
     * @return array
     */
    public static function GetTreatmentsByDossierID($clientID, $dossierID): array
    {
        return self::Get('treatment', 'model\Treatment', array(
            'relation' => 'AND',
            array(
                'key' => 'ClientID',
                'value' => $clientID,
                'compare' => '=',
                'type' => 'NUMERIC',
            ),
            array(
                'key' => 'DossierID',
                'value' => $dossierID,
                'compare' => '=',
                'type' => 'NUMERIC',
            )
        ));
    }

    /**
     * @return bool
     */
    public static function IsThisTreatment(): bool
    {
        return WPInstrument::CheckCurrentCustomPostTypeInArray(self::GetServiceCustomPostTypes());

    }

    /**
     * @return string[]
     */
    public static function GetServiceCustomPostTypes(): array
    {
        return ['treatment'];
    }


    /**
     * @return array
     */
    public static function getOngoing(): array
    {
        return parent::Get('treatment', 'model\Treatment', [
            array('key' => 'Activation_Status',
                'value' => '1',
                'compare' => '=')

        ]);
    }

    /**
     * @return array
     */
    public static function getFinished(): array
    {
        return parent::Get('treatment', 'model\Treatment', [
            array('key' => 'Activation_Status',
                'value' => '2',
                'compare' => '=')

        ]);
    }

    /**
     * @return array
     */
    public static function getCanceled(): array
    {
        return parent::Get('treatment', 'model\Treatment', [
            array('key' => 'Activation_Status',
                'value' => '3',
                'compare' => '=')

        ]);
    }

}