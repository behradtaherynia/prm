<?php
function clientToServiceField($appended_posts): string
{

    $totalClients = Client::GetActiveS();

    $html = '<select id="select2_service_client" name="service_select2_client" style="width:99%;max-width:25em;" ><option></option> ';
    foreach ($totalClients as $totalClient) {
        $appendedUser = ($appended_posts->getID() == $totalClient->getID()) ? ' selected="selected"' : '';
        $html .= '<option value="' . $totalClient->getID() . '"' . $appendedUser . '>' . $totalClient->getTitle() . '</option>';
    }
    $html .= '</select></p>';
    return $html;
}

function solutionToServiceField($appended_posts): string
{
    $totalClients = Solution::GetActiveS();

    $html = '<select id="select2_service_solution" name="service_select2_solution" style="width:99%;max-width:25em;" ><option></option>';
    foreach ($totalClients as $totalClient) {
        $appendedUser = ($appended_posts->getID() == $totalClient->getID()) ? ' selected="selected"' : '';
        $html .= '<option value="' . $totalClient->getID() . '"' . $appendedUser . '>' . $totalClient->getTitle() . '</option>';
    }
    $html .= '</select></p>';

    return $html;
}