<?php

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
        return self::Get('automaton', 'Automaton', [
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
        $clientID=$this->getPostMeta('ClientID','int');
        return new Client($clientID);
    }

    /**
     * @return array
     */
    public function getTreatments(): array
    {
        return self::Get('treatment','Treatment',$meta_query = array(
            'relation' => 'AND',
            array(
                'key'     => 'ServiceID',
                'value'   => $this->getID(),
                'compare' => '=',
                'type'    => 'NUMERIC',
            )
        ));
    }

    /**
     * @return array
     */
    public function getCompleteTreatments(): array
    {
        return self::Get('treatment','Treatment',$meta_query = array(
            'relation' => 'AND',
            array(
                'key'     => 'ServiceID',
                'value'   => $this->getID(),
                'compare' => '=',
                'type'    => 'NUMERIC',
            ),
            array(
                'key'     => 'Treatment_Status',
                'value'   => 'Complete',
                'compare' => '=',
                'type'    => 'CHAR',
            )
        ));
    }

    /**
     * @return array
     */
    public function getIncompleteTreatments(): array
    {
        return self::Get('treatment','Treatment',$meta_query = array(
            'relation' => 'AND',
            array(
                'key'     => 'ServiceID',
                'value'   => $this->getID(),
                'compare' => '=',
                'type'    => 'NUMERIC',
            ),
            array(
                'key'     => 'Treatment_Status',
                'value'   => 'Incomplete',
                'compare' => '=',
                'type'    => 'CHAR',
            )
        ));
    }

    public function getFollowUps()
    {

    }
    public function getSuccessFollowUps(){

    }
    public function getFailedFollowUps(){

    }
    public function getOngoingFollowUps()
    {

    }
    public function getSessionRestTime()
    {

    }
}