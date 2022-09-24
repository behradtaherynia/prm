<?php

namespace model;


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
     * @return Treatment
     */
    public function getTreatment(): Treatment
    {
//       return self::Get('treatment', 'model\Treatment',
//            array(
//                'key'     => 'SessionID',
//                'value'   => $this->getID(),
//                'compare' => '=',
//                'type'    => 'NUMERIC',
//            ));
        $result = get_post($this->getPostMeta('TreatmentID', 'int'));
        return new Treatment($result->ID);
    }

    public function getCurrentSession()
    {

    }

    public function getNextSession()
    {

    }

    public function getPerceptions()
    {

    }

//endregion

//region short functions
    public function insertAttachment()
    {

    }

    public function insertPerception()
    {

    }

    public function addSession()
    {

    }
//endregion
}