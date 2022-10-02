<?php
function activationField(string $activationStatus): string
{
    $value = $activationStatus;
    $html = '<div class="misc-pub-section"><span class="dashicons dashicons-plugins-checked"></span>        <label class="statuslabel" for="wdm_new_field">وضعیت را انتخاب کنید:</label>
        <br/>
        <p>';
    $html .= ' <input type="radio" name="activationpost" value="1"' . checked($value, '1', false) . '>فعال';
    $html .= '    <input type="radio" name="activationpost" value="2"' . checked($value, '2', false) . '>غیرفعال<br></p></div>';
    return $html;

}

function titleField(string $clientTitle, $attName = 'titlename', $statusResult = false): string
{
    $includeTypes = ['service', 'treatment'];
    $currentType = get_post_type();
//    $statusResult = false;
    if (in_array($currentType, $includeTypes)) {
        $statusResult = true;
    }

    return $html = '<p><input type="text" name="' . $attName . '" id="" Value="' . $clientTitle . '"' . ($statusResult == true ? 'readonly' : '') . '></p>';

}

function createRadio($name, $options, $default = ''): string
{
    $name = htmlentities($name);

    $html = '';
    foreach ($options as $label => $value) {
        $value = htmlentities($value);
        $html .= '<input type="radio" ';
        if ($value == $default) {
            $html .= ' checked="checked" ';
        };
        $html .= ' name="' . $name . '" value="' . $value . '" />' . $label . '<br />' . "\n";
    };
    return $html;
}
