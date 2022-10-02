<?php

use model\Client;
use model\User;
use model\WPAction;

if (Client::IsThisClient()) {
    WPAction::Save('clientMetas');
    function clientMetas($post_id)
    {
        $currentClient = new Client($post_id);


        if (isset($_POST['client_select2_emps'])) {
//            $currentClient->updatePostMeta('Client_Employees', $_POST['client_select2_emps']);
            $currentClient->updateStaff( $_POST['client_select2_emps']);
            foreach ($_POST['client_select2_emps'] as $client_select_emp) {
                $employee = new User($client_select_emp);
                $employee->updateClient($post_id);
            }
        }



        if (isset($_POST['activationpost'])) {
            $currentClient->updateActivation($_POST['activationpost']);
        }

        if (isset($_POST['titlename'])) {
            $currentClient->updateTitle($_POST['titlename']);
        }

        if (isset($_POST['clientaddress'])) {
            $currentClient->updateAddress($_POST['clientaddress']);
        }

        if (isset($_POST['clientdate'])) {
            $currentClient->updateDate($_POST['clientdate']);
        }

        if (isset($_POST['phoneNumber'])) {
            $currentClient->updatePrivatePhoneNumber($_POST['phoneNumber']);
        }

        return $post_id;


    }
}