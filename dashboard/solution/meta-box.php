<?php

use model\Solution;
use model\WPAction;
use model\WPInstrument;

if (strpos($_SERVER['REQUEST_URI'], "post-new") == true && $_GET['post_type'] == 'solution' || WPInstrument::IsEditCustomPostType() && Solution::IsThisSolution()) {
    WPAction::MetaBox(['solution'],'solution_info','اطلاعات راهکار','solutionInfobox','advanced','default');

    function solutionInfobox($post)
    {
        solutionInfo($post->ID);
    }
}

