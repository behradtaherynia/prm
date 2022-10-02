<?php

use model\User;

function myClientServiceField($appended_post): string
{

    $myClient = new User();
    $client = $myClient->getClient();
//    var_ex($appended_post->getService());
    $clientServices = $client->getServices();
//    var_ex($clientServices);
    $html = '<select id="treatment_services_select" name="treatment_services_select" style="width:99%;max-width:25em;" ><option></option> ';
    foreach ($clientServices as $clientService) {
        $appendedUser = ($appended_post->getService()->getID() == $clientService->getID()) ? ' selected="selected"' : '';
        $html .= '<option value="' . $clientService->getID() . '"' . $appendedUser . '>' . $clientService->getTitle() . '</option>';
    }
    $html .= '</select></p>';
    return $html;
}function myClientDossierField($appended_post): string
{

    $myClient = new User();
    $client = $myClient->getClient();
//    var_ex($appended_post->getDossier());
    $clientServices = $client->getDossierS();
    $html = '<select id="treatment_dossiers_select" name="treatment_dossiers_select" style="width:99%;max-width:25em;" ><option></option> ';
    foreach ($clientServices as $clientService) {
        $appendedUser = ($appended_post->getDossier()->getID() == $clientService->getID()) ? ' selected="selected"' : '';
        $html .= '<option value="' . $clientService->getID() . '"' . $appendedUser . '>' . $clientService->getTitle() . '</option>';
    }
    $html .= '</select></p>';
    return $html;
}