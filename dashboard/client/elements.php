<?php

use model\SmartDate;
use model\User;

function clientEmployees(array $clientEmployees): string
{
    $totalUsers = User::GetAllUsers();
//    $currentPostObject = new model\Client($postID);
//    $appendedEmployees = $currentPostObject->getEmployees();
    $appendedEmployees = $clientEmployees;

    $html = '<p><label for="client_select2_emps">کارمندان:</label><br /><select id="client_select2_emps" name="client_select2_emps[]" multiple="multiple" style="width:99%;max-width:25em;">';
    foreach ($totalUsers as $totalUser) {


        $appendedUser = (in_array($totalUser->getID(), $appendedEmployees)) ? ' selected="selected"' : '';
        $html .= '<option value="' . $totalUser->getID() . '"' . $appendedUser . '>' . $totalUser->getDisplayName() . '</option>';

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
