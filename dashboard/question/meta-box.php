<?php

use model\Question;
use model\WPAction;

if (Question::IsThisQuestion()) {
    WPAction::EnqueueScript('ReaperField', '/Repeater.js', [], '2.0', false);

    WPAction::MetaBox(['question'], 'questionInfo', 'جزئیات سوال سلامتی بیمار', 'questionInfoBoxGenerator', 'advanced', 'default');

//    function questionInfoBoxGenerator($postObject)
//    {
//
//    }
    function questionInfoBoxGenerator($postObject)
    {
        $currentPost = new Question($postObject->ID);
        echo createRadio('QuestionDisplayType', ['چک باکس' => '1', 'رادیو' => '2'], '2');
        echo RepeaterTextField();
        echo activationField($currentPost->getActivation());
    }



}