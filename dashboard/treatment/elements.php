<?php
function myClientServiceField($appended_post): string
{

    $myClient = new User();
    $client = $myClient->getClient();
    $clientServices = $client->getServices();
    $html = '<select id="select2_service_client" name="service_select2_client" style="width:99%;max-width:25em;" ><option></option> ';
    foreach ($clientServices as $clientService) {
        $appendedUser = ($appended_post->getID() == $clientService->getID()) ? ' selected="selected"' : '';
        $html .= '<option value="' . $clientService->getID() . '"' . $appendedUser . '>' . $clientService->getTitle() . '</option>';
    }
    $html .= '</select></p>';
    return $html;
}