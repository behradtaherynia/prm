<?php

use model\Client;

function clientInfo($ID)
{
    $currentClientObject = new Client($ID);

    echo titleField($currentClientObject->getTitle());
    echo ClientAddressField($currentClientObject->getAddress());
    echo clientEmployees($currentClientObject->getEmployees());
    echo activationField($currentClientObject->getActivation());
//        echo dateField($currentClientObject->getDate());
    echo phoneField($currentClientObject->getPrivatePhoneNumber());
}