<?php
function var_ex($data)
{
    echo '<pre>' . var_export($data, true) . '</pre>';

}

foreach (glob(get_template_directory() . '/functions/*.php') as $filename) {
    include_once $filename;
}
foreach (glob(get_template_directory() . '/model/*.php') as $filename) {
    include_once $filename;
}
foreach (glob(get_template_directory() . '/dashboard/*') as $filename) {
    foreach (glob($filename.'/*.php') as $phpFile) {
        include_once $phpFile;
    }
}