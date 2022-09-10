<?php
if (Solution::IsThisSolution()) {
    WPAction::Save('solutionMetas');
    function solutionMetas($postID)
    {
        $currentClient = new Solution($postID);

        if (isset($_POST['titlename']))
            $currentClient->updateTitle($_POST['titlename']);
        if (isset($_POST['activationpost']))
            $currentClient->updateActivation($_POST['activationpost']);
    }
}