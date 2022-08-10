<?php
//include get_template_directory() . '/autoload.php';
//$aa = new Solution();
//spl_autoload_register( function($classname) {
//
//    $class      = str_replace( '\\', DIRECTORY_SEPARATOR, str_replace( '_', '-', strtolower($classname) ) );
//    $classes    = dirname(__FILE__) .  DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $class . '.php';
//
//    if( file_exists($classes) ) {
//        require_once( $classes );
//    }
//} );
//
//$theme = new Client(1);
//Requests::autoloader('WPCustomPostType');
//Requests::autoloader('Solution');
//Requests::register_autoloader();
function var_ex($data)
{
    echo '<pre>' . var_export($data, true) . '</pre>';

}

//require_once get_template_directory() . '/autoload.php';

//spl_autoload_register('myAutoloader');
//
//function myAutoloader($className)
//{
//    $path = get_template_directory() . '/model/';
////    $path = '/model/';
//
//    include $path.$className.'.php';
//}
include_once get_template_directory() . '/model/WPClass.php';
include_once get_template_directory() . '/model/WPCustomPostType.php';
include_once get_template_directory() . '/model/WPTerm.php';

foreach (glob(get_template_directory() . '/functions/*.php') as $filename) {
    include_once $filename;
}
foreach (glob(get_template_directory() . '/model/*.php') as $filename) {
    include_once $filename;
}
foreach (glob(get_template_directory() . '/dashboard/*') as $filename) {
    foreach (glob($filename . '/*.php') as $phpFile) {
        include_once $phpFile;
    }
}