<?php

use model\WPAction;

WPAction::MetaBox(['session'],'sessionMetaBox','جزئیات جلسه','sessionInfoBox','advanced','default');

function sessionInfoBox()
{

    $array = array('در انتظار پیگیری'=>'One',
        'two'=>'Two',
        'three'=>'Three',
        'four'=>'Four');
    echo createRadio('numbers',$array,'three');
}