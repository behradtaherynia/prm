<?php

class Session extends WPCustomPostType
{
//region getter functions::
    public function getAttachments()
    {

    }

    public function getNumber()
    {

    }

    public function getFollowups()
    {

    }


    /**
     * @return WP_Post|null
     */
    public function getTreatment(): ?WP_Post
    {
//       return self::Get('treatment', 'Treatment',
//            array(
//                'key'     => 'SessionID',
//                'value'   => $this->getID(),
//                'compare' => '=',
//                'type'    => 'NUMERIC',
//            ));
        $result = get_post($this->getPostMeta('TreatmentID', 'int'));
        return $result;
    }

    public function getCurrentSession()
    {

    }

    public function getNextSession()
    {

    }

    public function getPreceptions()
    {

    }

//endregion

//region short functions
    public function insertAttachment()
    {

    }

    public function insertPreception()
    {

    }

    public function addSession()
    {

    }
//endregion
}