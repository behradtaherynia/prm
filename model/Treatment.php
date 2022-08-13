<?php

class Treatment extends WPCustomPostType
{

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
        return self::Get('session', 'Session',
            array(
                'key' => 'TreatmentID',
                'value' => $this->getID(),
                'compare' => '=',
                'type' => 'NUMERIC',
            )
        );
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
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT ID, post_content FROM $wpdb->posts WHERE post_type = %s and post_status = 'publish'", $custom_post_type ), ARRAY_A );
        // Return null if we found no results
        return !$results ? null : $results;
    }

    public function getNextSession()
    {

    }


}