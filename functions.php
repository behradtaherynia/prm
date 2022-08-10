<?php

function var_ex($data)
{
    echo '<pre>' . var_export($data, true) . '</pre>';

}

require_once get_template_directory() . '/autoload.php';

//spl_autoload_register('myAutoloader');
//
//function myAutoloader($className)
//{
//    $path = get_template_directory() . '/model/';
////    $path = '/model/';
//
//    include $path.$className.'.php';
//}
//include_once get_template_directory() . '/model/WPClass.php';
//include_once get_template_directory() . '/model/WPCustomPostType.php';
//include_once get_template_directory() . '/model/WPTerm.php';
//
//foreach (glob(get_template_directory() . '/functions/*.php') as $filename) {
//    include_once $filename;
//}
//foreach (glob(get_template_directory() . '/model/*.php') as $filename) {
//    include_once $filename;
//}
//foreach (glob(get_template_directory() . '/dashboard/*') as $filename) {
//    foreach (glob($filename . '/*.php') as $phpFile) {
//        include_once $phpFile;
//    }
//}