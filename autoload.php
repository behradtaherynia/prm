<?php
spl_autoload_register(function ($classname) {

    $class = str_replace('\\', DIRECTORY_SEPARATOR, str_replace('_', '-', strtolower($classname)));

    //اسم یا ادرس پوشه مورد نظر را داخل متغیر path قرار دهید
    $path = 'class';

    $classes = dirname(__FILE__) . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $class . '.php';

    if (file_exists($classes)) {
        include_once $classes;
    }
});
