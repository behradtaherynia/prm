<?php
require_once get_template_directory() . '/autoload.php';
$a = new Followup(1);
var_ex($a);
//spl_autoload_register('myAutoloader');
//function myAutoloader(){
//    foreach (glob(__DIR__ . '/functions/*.php') as $my_theme_filename) {
//        var_ex($my_theme_filename);
//        // Exclude files whose names contain -sample
////    if (!strpos($my_theme_filename, '-sample') ) {
//        include_once $my_theme_filename;
////    }
//
//    }}
//$Directory = new RecursiveDirectoryIterator(get_template_directory().'/functions/');
//$Iterator = new RecursiveIteratorIterator($Directory);
//$Regex = new RegexIterator($Iterator, '/^.+\.php$/i', RegexIterator::GET_MATCH);
//
//foreach($Regex as $yourfiles) {
//    var_ex($yourfiles);
//    include $yourfiles->getPathname();
//}
//foreach (glob(__DIR__ . '/functions/*.php') as $my_theme_filename) {
//var_ex($my_theme_filename);
//    // Exclude files whose names contain -sample
////    if (!strpos($my_theme_filename, '-sample') ) {
//        include_once $my_theme_filename;
////    }
//
//}
//require_once get_template_directory() . 'functions/*.php';

function var_ex($data)
{
    echo '<pre style="direction: ltr">' . var_export($data, true) . '</pre>';
}
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

//$aaa = array("read", "edit_dashboard", "publish_posts", "edit_posts", "delete_posts", "edit_published_posts", "delete_published_posts", "edit_others_posts", "delete_others_posts", "read_private_posts", "edit_private_posts", "delete_private_posts", "manage_categories", "upload_files", "unfiltered_upload", "publish_pages", "edit_pages", "delete_pages", "edit_published_pages", "delete_published_pages", "edit_others_pages", "delete_others_pages", "read_private_pages", "edit_private_pages", "delete_private_pages", "edit_comment", "moderate_comments", "switch_themes", "edit_theme_options", "edit_themes", "delete_themes", "install_themes", "update_themes", "activate_plugins", "edit_plugins", "install_plugins", "update_plugins", "delete_plugins", "list_users", "create_users", "edit_users", "delete_users", "promote_users", "import", "export", "manage_options", "update_core", "unfiltered_html", "manage_links", "list_roles", "create_roles", "edit_roles", "delete_roles", "edit_role_menus", "edit_posts_role_permissions", "edit_pages_role_permissions", "edit_nav_menu_permissions", "edit_attachments", "delete_attachments", "read_others_attachments", "edit_others_attachments", "delete_others_attachments", "edit_content_shortcodes", "delete_content_shortcodes", "edit_login_redirects", "delete_login_redirects", "edit_users_higher_level", "delete_users_higher_level", "promote_users_higher_level", "promote_users_to_higher_level", "edit_widget_permissions");
//foreach ($aaa as $item) {
//    $UPPER=strtoupper($item);
//    echo $b = "const CAP_DEFAULT_$UPPER = '$item';<br>";
//}

