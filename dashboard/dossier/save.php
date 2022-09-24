<?php

use model\Dossier;
use model\Patient;
use model\User;
use model\WPAction;


if (Dossier::IsThisDossier()) {

    WPAction::Save('patientDossierSave');

//    function patientDossierSave($postID)
//    {
//        if (isset($_POST['patientName']) && isset($_POST['patientLastName']) && isset($_POST['patientphoneNumber']) && isset($_POST['patientIDcode']) && isset($_POST['patientaddress'])) {
//            $patientCheck = Patient::DoesExist($_POST['patientIDcode']);
//            $currentDossier = new Dossier($postID);
//            if ($patientCheck) {
////                $patientCheck->updateName($_POST['patientName']);
////                $patientCheck->updateLastName($_POST['patientLastName']);
////                $patientCheck->updatePhone($_POST['patientphoneNumber']);
////                $patientCheck->updateAddress($_POST['patientaddress']);
////                $patientCheck->updateIDCode($_POST['patientIDcode']);
//                $patientCheck->updateAll($_POST['patientIDcode'], $_POST['patientName'], $_POST['patientLastName'], $_POST['patientphoneNumber'], $_POST['patientaddress']);
//                $currentDossier->updateDossierID($postID);
//                $currentDossier->updatePatient($patientCheck->getID());
//
//            }
//            else{
//                $patientCheck= Patient::Insert($_POST['patientIDcode'], $_POST['patientName'], $_POST['patientLastName'], $_POST['patientphoneNumber'], $_POST['patientaddress']);
////                var_ex($patientCheck);
////                exit();
//                $currentDossier->updateDossierID($postID);
//                $currentDossier->updatePatient($patientCheck->getID());
//            }
//        }
//    }
    function patientDossierSave($postID)
    {
        if (isset($_POST['patientName']) && isset($_POST['patientLastName']) && isset($_POST['patientphoneNumber']) && isset($_POST['patientIDcode']) && isset($_POST['patientaddress'])) {
            $patientCheck = Patient::DoesExist($_POST['patientIDcode']);
//            $currentUser=new User();
//            $dossierCheck=Dossier::DoesExist($patientCheck->getID(),$currentUser->getClient()->getID());
            $currentDossier = new Dossier($postID);
            if ($patientCheck) {
//                $patientCheck->updateName($_POST['patientName']);
//                $patientCheck->updateLastName($_POST['patientLastName']);
//                $patientCheck->updatePhone($_POST['patientphoneNumber']);
//                $patientCheck->updateAddress($_POST['patientaddress']);
//                $patientCheck->updateIDCode($_POST['patientIDcode']);
                $patientCheck->updateAll($_POST['patientIDcode'], $_POST['patientName'], $_POST['patientLastName'], $_POST['patientphoneNumber'], $_POST['patientaddress']);

            }
            else{
                $patientCheck= Patient::Insert($_POST['patientIDcode'], $_POST['patientName'], $_POST['patientLastName'], $_POST['patientphoneNumber'], $_POST['patientaddress']);
//                var_ex($patientCheck);
//                exit();
            }
            $currentDossier->updateDossierID($postID);
            $currentDossier->updatePatient($patientCheck->getID());
        }
    }
}