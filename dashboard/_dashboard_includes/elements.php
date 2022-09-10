<?php
function postActivation(string $activationStatus): string
{
//    $currentPostObject = new $classname($postID);
//    $value = $currentPostObject->getActivation();
    $value = $activationStatus;
    $html = '<div class="misc-pub-section"><span class="dashicons dashicons-plugins-checked"></span>        <label class="statuslabel" for="wdm_new_field">وضعیت را انتخاب کنید:</label>
        <br/>
        <p>';
    $html .= ' <input type="radio" name="activationpost" value="true"' . checked($value, 'true', false) . '>فعال';
    $html .= '    <input type="radio" name="activationpost" value="false"' . checked($value, 'false', false) . '>غیرفعال<br></p></div>';
    return $html;

}

function titleField(string $clientTitle): string
{
//    $currentPostObject = new $classname($postID);
    return $html = '<input type="text" name="titlename" id="" Value="' . $clientTitle . '">';
}