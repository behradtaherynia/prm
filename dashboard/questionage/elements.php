<?php
function clientStaffs(): string
{
    $orphanUsers = Client::GetOrphanUsers();
    $currentPostObject = new model\Client(77);
    $appendedEmployees = $currentPostObject->getStaff();

//    var_ex($appendedEmployees);
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