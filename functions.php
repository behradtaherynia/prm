<?php
define('TEMPLATE_DIR', get_template_directory());//     /home3/tadbirneg/public_html/wp-content/themes/tadbirnegar
define('TEMPLATE_URL', get_template_directory_uri());//   https://tadbirnegar.net/wp-content/themes/tadbirnegar
define('HOME_URL', home_url());//   https://tadbirnegar.net

const TEMPLATE_ASSETS_URL = TEMPLATE_URL . '/assets';//   /wp-content/themes/tadbirnegar
const TEMPLATE_STYLESHEETS_URL = TEMPLATE_ASSETS_URL . '/css';//   /wp-content/themes/tadbirnegar
const TEMPLATE_SCRIPTS_URL = TEMPLATE_ASSETS_URL . '/js';//   /wp-content/themes/tadbirnegar


require_once get_template_directory() . '/autoload.php';

$Directory = new RecursiveDirectoryIterator(get_template_directory() . '/dashboard/');
$Iterator = new RecursiveIteratorIterator($Directory);
$Regex = new RegexIterator($Iterator, '/^.+\.php$/i', RegexIterator::GET_MATCH);

foreach ($Regex as $yourfiles) {
    include_once $yourfiles[0];
}

function var_ex($data)
{
    echo '<pre style="direction: ltr">' . var_export($data, true) . '</pre>';
}
add_theme_support( 'post-thumbnails' );