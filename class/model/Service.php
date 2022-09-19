<?php

namespace model;

class Service extends WPCustomPostType
{

    public function getSessions()
    {

    }

    /**
     * @return array
     */
    public function getAutomatons(): array
    {
        return self::Get('automaton', 'model\Automaton', [
            'key' => 'ServiceID',
            'value' => $this->getID(),
            'compare' => '=',
            'type' => 'NUMERIC'
        ]);
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        $clientID = $this->getPostMeta('ClientID', 'int');
        return new Client($clientID);
    }

    /**
     * @return Solution
     */
    public function getSolution(): Solution
    {
        $solutionID = $this->getPostMeta('SolutionID', 'int');
        return new Solution($solutionID);
    }

    /**
     * @return array
     */
    public function getTreatments(): array
    {
        return self::Get('treatment', 'model\Treatment', array(
            'relation' => 'AND',
            array(
                'key' => 'ServiceID',
                'value' => $this->getID(),
                'compare' => '=',
                'type' => 'NUMERIC',
            )
        ));
    }

    /**
     * @return array
     */
    public function getCompleteTreatments(): array
    {
        return self::Get('treatment', 'model\Treatment', array(
            'relation' => 'AND',
            array(
                'key' => 'ServiceID',
                'value' => $this->getID(),
                'compare' => '=',
                'type' => 'NUMERIC',
            ),
            array(
                'key' => 'Treatment_Status',
                'value' => 'Complete',
                'compare' => '=',
                'type' => 'CHAR',
            )
        ));
    }

    /**
     * @return array
     */
    public function getIncompleteTreatments(): array
    {
        return self::Get('treatment', 'model\Treatment', array(
            'relation' => 'AND',
            array(
                'key' => 'ServiceID',
                'value' => $this->getID(),
                'compare' => '=',
                'type' => 'NUMERIC',
            ),
            array(
                'key' => 'Treatment_Status',
                'value' => 'Incomplete',
                'compare' => '=',
                'type' => 'CHAR',
            )
        ));
    }

    public function getFollowUps()
    {

    }

    public function getSuccessFollowUps()
    {

    }

    public function getFailedFollowUps()
    {

    }

    public function getOngoingFollowUps()
    {

    }

    public function getSessionRestTime()
    {

    }

    public function getActivation()
    {
        return parent::getActivation();
    }

    public function updateActivation($value): bool
    {
        return parent::updateActivation($value);
    }

    public function updateClient($value): bool
    {
        return $this->updatePostMeta('ClientID', $value);
    }

    public function updateSolution($value): bool
    {
        return $this->updatePostMeta('SolutionID', $value);
    }

    /**
     * @return bool
     */
    public static function IsThisService(): bool
    {
        return WPInstrument::CheckCurrentCustomPostTypeInArray(self::GetServiceCustomPostTypes());

    }

    /**
     * @return string[]
     */
    public static function GetServiceCustomPostTypes(): array
    {
        return ['service'];
    }
}