<?php
spl_autoload_register(function ($classname) {
    var_ex($classname);

    $class = str_replace('\\', DIRECTORY_SEPARATOR, str_replace('_', '-', strtolower($classname)));
    $classes = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . $class . '.php';
    var_ex($classes);
    if (file_exists($classes)) {
        include_once $classes ;
//        include_once get_template_directory() . '/model/' . $classes . '.php';
    }
});