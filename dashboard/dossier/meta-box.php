<?php

use model\Dossier;
use model\WPAction;
use model\Patient;
use model\WPInstrument;

if (strpos($_SERVER['REQUEST_URI'], "post-new") == true && $_GET['post_type'] == 'dossier' || Dossier::IsThisDossier() && WPInstrument::IsEditCustomPostType()) {

    WPAction::MetaBox(['dossier'], 'patientInfo', 'مشخصات بیمار', 'patientInfoBox', 'advanced', 'default');

    function patientInfoBox($postObject)
    {
        $currentPostObject = new Dossier($postObject->ID);
        if (Dossier::IsThisDossier() && WPInstrument::IsEditCustomPostType()) {
            $dossierPatient = $currentPostObject->getPatient();
//        if ($dossierPatient != null) {
            echo titleField($currentPostObject->getDossierID(), 'dossierID');
            echo titleField($dossierPatient->getName(), 'patientName');
            echo titleField($dossierPatient->getLastName(), 'patientLastName');
            echo titleField($dossierPatient->getPhone(), 'patientphoneNumber');
            echo titleField($dossierPatient->getIDCode(), 'patientIDcode');
            echo titleField($dossierPatient->getAddress(), 'patientaddress');
        } //        }
        elseif(strpos($_SERVER['REQUEST_URI'], "post-new") == true && $_GET['post_type'] == 'dossier') {
//            echo titleField('', 'dossierID', true);
            echo titleField('', 'patientName');
            echo titleField('', 'patientLastName');
            echo titleField('', 'patientphoneNumber');
            echo titleField('', 'patientIDcode');
            echo titleField('', 'patientaddress');

        }
    }
}