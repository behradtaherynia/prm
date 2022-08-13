<?php
spl_autoload_register(function ($classname) {

    $class = str_replace('\\', DIRECTORY_SEPARATOR, str_replace('_', '-', strtolower($classname)));

    //اسم یا ادرس پوشه مورد نظر را داخل متغیر path قرار دهید
    $path = 'model';

    $classes = dirname(__FILE__) . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $class . '.php';

    if (file_exists($classes)) {
        include_once $classes;
    }
});
spl_autoload_register(function ($classname) {
    var_ex($classname);
    $class = str_replace('\\', DIRECTORY_SEPARATOR, str_replace('_', '-', strtolower($classname)));
    var_ex($class);
    $classes = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR .'Fields'.DIRECTORY_SEPARATOR. $class . '.php';
    var_ex($classes);
    if (file_exists($classes)) {
        require_once($classes);
    }
});

