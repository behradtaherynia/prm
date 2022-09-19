<?php

use model\Client;
use model\WPAction;
use model\WPInstrument;

if (strpos($_SERVER['REQUEST_URI'], "post-new") == true && $_GET['post_type'] == 'service' || Client::IsThisClient() && WPInstrument::IsEditCustomPostType()) {
    WPAction::EnqueueStyle('select2css', '/select2.css', [], '1.1');
    WPAction::EnqueueStyle('select2class', '/select2class.css', ['select2css'], '1.1');
//    model\WPAction::EnqueueStyle('jalalidatepickercss', '/jalalidatepicker.css', [], '1.0');
    WPAction::EnqueueScript('select2', '/select2.js', array('jquery'), '1.1', true);
    WPAction::EnqueueScript('select2exe', '/select2execute.js', array('jquery', 'select2'), '1.1', true);
//    model\WPAction::EnqueueScript('jalalidatepicker', '/jalalidatepicker.js', array('jquery'), '1.0', true);
//    model\WPAction::EnqueueScript('jalalidatepickerexecute', '/jalalidatepickerexecute.js', array('jquery', 'jalalidatepicker'), '1.0', true);
    WPAction::MetaBox(array('client'), 'client_employees', 'مشخصات کارفرما', 'prmEmployeeList', 'side', 'default');
//    model\WPAction::MetaBox(array('client'), 'client_address', 'آدرس کارفرما', 'clientAddress', 'advanced', 'default');
//    model\WPAction::MetaBox(array('client'), 'client_name', 'نام کارفرما', 'clientName', 'advanced', 'high');
//    model\WPAction::MetaBox(array('client'), 'client_birthdate', 'تاریخ تولد کارفرما', 'clientBirthdate', 'advanced', 'default');
//    model\WPAction::MISC('postActivationCheck');


    //adds employees and assigned ones to current client
    function prmEmployeeList($postObject)
    {
        clientInfo($postObject->ID);
    }

}
