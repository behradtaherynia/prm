<?php
function solutionInfo($solutionID)
{
    $currentPostObject = new Solution($solutionID);
    echo titleField($currentPostObject->getTitle());
    echo activationField($currentPostObject->getActivation());
}