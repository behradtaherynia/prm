<?php

use model\Client;
use model\SmartDate;
use model\User;

function clientEmployees(array $clientEmployees): string
{
    $totalUsers = User::GetAllUsers();
    $orphanUsers = User::GetOrphanUsers();
//    $currentPostObject = new model\Client($postID);
//    $appendedEmployees = $currentPostObject->getEmployees();
    $appendedEmployees = $clientEmployees;

    $html = '<p><label for="client_select2_emps">کارمندان:</label><br /><select id="client_select2_emps" name="client_select2_emps[]" multiple="multiple" style="width:99%;max-width:25em;">';
    foreach ($totalUsers as $totalUser) {
        if (in_array($totalUser->getID(), $appendedEmployees)) {
            $html .= '<option value="' . $totalUser->getID() . '"' . ' selected="selected"' . '>' . $totalUser->getDisplayName() . '</option>';
        } elseif (in_array($totalUser->getID(), $orphanUsers)) {
            $html .= '<option value="' . $totalUser->getID() . '"' . '>' . $totalUser->getDisplayName() . '</option>';

        }

//        $appendedUser = (in_array($totalUser->getID(), $appendedEmployees)) ? ' selected="selected"' : '';
//        $html .= '<option value="' . $totalUser->getID() . '"' . $appendedUser . '>' . $totalUser->getDisplayName() . '</option>';

    }
    $html .= '</select></p>';
    return $html;
}

function ClientAddressField($clientAddress): string
{
    return $html = '<p> <textarea name="clientaddress" id="clientaddress">' . $clientAddress . '</textarea></p>';
}

function dateField(SmartDate $date): string
{
    return $html = '<input data-jdp type="text" name="clientdate" id="" Value="' . $date->getDateStringJalali('/') . '">';
}

function phoneField($phone): string
{
    return $html = '<input type="text" name="phoneNumber" id="" Value="' . $phone . '">';
}




function clientStaff(): string
{
//    $totalUsers = User::GetAllUsers();
    $orphanUsers = Client::GetOrphanUsers();
    $currentPostObject = new model\Client(77);
    $appendedEmployees = $currentPostObject->getStaff();

    var_ex($appendedEmployees);
    $html = '<p><label for="client_select2_emps">کارمندان:</label><br /><select id="client_select2_emps" name="client_select2_emps[]" multiple="multiple" style="width:99%;max-width:25em;">';
    foreach ($appendedEmployees as $appendedEmployee) {
        $html .= '<option value="' . $appendedEmployee->getID() . '"' . ' selected="selected"' . '>' . $appendedEmployee->getDisplayName() . '</option>';
    }

    foreach ($orphanUsers as $orphanUser) {
        $html .= '<option value="' . $orphanUser->getID() . '"' . '>' . $orphanUser->getDisplayName() . '</option>';
    }
    $html .= '</select></p>';
    return $html;
}
