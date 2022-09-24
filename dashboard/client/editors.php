<?php

use model\Client;

function clientInfo($ID)
{
    $currentClientObject = new Client($ID);

    echo titleField($currentClientObject->getTitle());
    echo ClientAddressField($currentClientObject->getAddress());
    $timeStart = microtime(true);

    echo clientEmployees($currentClientObject->getEmployees());
//    echo clientStaff();
    $timeEnd = microtime(true);
    $time = $timeEnd - $timeStart;
    echo 'execute in ' . round($time, 3) . ' seconds';

    echo activationField($currentClientObject->getActivation());
//        echo dateField($currentClientObject->getDate());
    echo phoneField($currentClientObject->getPrivatePhoneNumber());
}