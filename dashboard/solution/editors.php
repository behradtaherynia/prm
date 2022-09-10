<?php
function solutionInfo($solutionID)
{
    $currentPostObject = new Solution($solutionID);
    echo titleField($currentPostObject->getTitle());
    echo postActivation($currentPostObject->getActivation());
}