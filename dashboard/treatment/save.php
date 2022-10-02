<?php

use model\Treatment;
use model\WPAction;

if (Treatment::IsThisTreatment()){
    WPAction::Save('treatmentSaveCallBack');
    function treatmentSaveCallBack($postID)
    {
        $currentPost = new Treatment($postID);
        if (isset($_POST['treatment_services_select']) &&isset($_POST['treatment_dossiers_select'])) {
            $currentPost->updateService($_POST['treatment_services_select']);
            $currentPost->updateDossier($_POST['treatment_dossiers_select']);
            $currentPost->updateTitle(get_the_title($_POST['treatment_services_select']) .' - '. get_the_title($_POST['treatment_dossiers_select']));
        }
    }
}