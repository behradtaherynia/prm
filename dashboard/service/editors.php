<?php
function serviceInfo($postID)
{
    $clientLabel = '<p><label for="select2_service_client">انتخاب کارفرما:</label>';
    $solutionLabel = '<p><label for="select2_service_solution">انتخاب راهکار:</label>';

    $currentPostObject = new Service($postID);
    echo titleField($currentPostObject->getTitle());
    echo activationField($currentPostObject->getActivation());
    echo $clientLabel . clientToServiceField($currentPostObject->getClient());
    echo $solutionLabel . solutionToServiceField($currentPostObject->getSolution());
}