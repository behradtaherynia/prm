<?php
get_header();
$a = new WPCustomPostType(1);
var_ex($a->getContent());
get_footer();