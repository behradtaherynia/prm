<?php
get_header();
//$a = new WPCustomPostType(1);
//var_ex($a->getContent());
$a = new Solution(1);
var_ex($a->getTitle());
get_footer();