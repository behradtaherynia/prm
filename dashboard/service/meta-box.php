<?php

use model\Service;
use model\WPAction;
use model\WPInstrument;

if (strpos($_SERVER['REQUEST_URI'], "post-new") == true && $_GET['post_type'] == 'service' || Service::IsThisService() && WPInstrument::IsEditCustomPostType()) {
    WPAction::EnqueueStyle('select2css', '/select2.css', [], '1.1');
    WPAction::EnqueueScript('select2', '/select2.js', array('jquery'), '1.1', true);
    WPAction::EnqueueScript('select2exe', '/select2execute.js', array('jquery', 'select2'), '1.1', true);
    WPAction::MetaBox(array('service'), 'client-solution', 'کارفرما و راهکار', 'serviceInfobox', 'advanced', 'default');

    function serviceInfobox($post)
    {
        serviceInfo($post->ID);
    }
}