<?php

use model\Service;
use model\WPAction;

if (Service::IsThisService()) {
    WPAction::Save('serviceSaveCallBack');
    function serviceSaveCallBack($postID)
    {
        $currentPostObject = new Service($postID);
        if (isset($_POST['service_select2_client']) && isset($_POST['service_select2_solution']) && isset($_POST['activationpost'])) {
            $currentPostObject->updateTitle(get_the_title($_POST['service_select2_client']).' - ' .get_the_title($_POST['service_select2_solution']));
            $currentPostObject->updateClient($_POST['service_select2_client']);
            $currentPostObject->updateSolution($_POST['service_select2_solution']);
            $currentPostObject->updateActivation($_POST['activationpost']);
        }
    }
}