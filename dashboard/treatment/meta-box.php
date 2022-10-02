<?php

use model\Treatment;
use model\WPAction;
use model\WPInstrument;

if (strpos($_SERVER['REQUEST_URI'], "post-new") == true && $_GET['post_type'] == 'treatment' || WPInstrument::IsEditCustomPostType() && Treatment::IsThisTreatment()) {
    WPAction::MetaBox(['treatment'], 'treatmentInfo', 'اطلاعات درمان', 'treatmentInfoBox', 'advanced', 'default');
    WPAction::EnqueueStyle('select2css', '/select2.css', [], '1.1');
    WPAction::EnqueueScript('select2', '/select2.js', array('jquery'), '1.1', true);
    WPAction::EnqueueScript('select2exe', '/select2execute.js', array('jquery', 'select2'), '1.1', true);
    function treatmentInfoBox($postObject)
    {
        $serviceLabel = '<p><label for="select2_service_client">انتخاب خدمات: </label>';
        $dossierLabel = '<p><label for="select2_service_client">انتخاب پرونده: </label>';
        $currentTreatment = new Treatment($postObject->ID);

        echo titleField($currentTreatment->getTitle());
        echo $serviceLabel . myClientServiceField($currentTreatment);
        echo $dossierLabel . myClientDossierField($currentTreatment);
    }
}