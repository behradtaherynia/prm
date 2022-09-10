<?php
function clientInfo($ID)
{
    $currentClientObject = new Client($ID);

    echo titleField($currentClientObject->getTitle());
    echo ClientAddressField($currentClientObject->getAddress());
    echo clientEmployees($currentClientObject->getEmployees());
    echo postActivation($currentClientObject->getActivation());
//        echo dateField($currentClientObject->getDate());
    echo phoneField($currentClientObject->getPrivatePhoneNumber());
}