<?php
if (Client::IsThisClient()) {
    WPAction::Save('clientMetas');
    function clientMetas($post_id)
    {
        $currentClient = new Client($post_id);


        if (isset($_POST['client_select2_emps'])){
            $currentClient->updatePostMeta('Client_Employees', $_POST['client_select2_emps']);
            foreach ($_POST['client_select2_emps'] as $client_select_emp) {
                $employee = new User($client_select_emp);
                $result = $employee->updateClient($post_id);
            }

        }
        else
            delete_post_meta($post_id, 'Client_Employees');

        if (isset($_POST['activationpost']))
            $currentClient->updateActivation($_POST['activationpost']);
        else
            delete_post_meta($post_id, 'Activation_Status');

        if (isset($_POST['titlename']))
            $currentClient->updateTitle($_POST['titlename']);

        if (isset($_POST['clientaddress']))
            $currentClient->updateAddress($_POST['clientaddress']);

        if (isset($_POST['clientdate']))
            $currentClient->updateDate($_POST['clientdate']);

        if (isset($_POST['phoneNumber']))
            $currentClient->updatePrivatePhoneNumber($_POST['phoneNumber']);
        // Update the meta field in the database.
        return $post_id;

    }
}