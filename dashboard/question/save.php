<?php

use model\Question;
use model\WPAction;

if (Question::IsThisQuestion()) {
    WPAction::Save('custom_repeatable_meta_box_save');
    function custom_repeatable_meta_box_save($post_id)
    {
        $currentClient = new Question($post_id);

//        if ( ! isset( $_POST['gpm_repeatable_meta_box_nonce'] ) ||
//            ! wp_verify_nonce( $_POST['gpm_repeatable_meta_box_nonce'], 'gpm_repeatable_meta_box_nonce' ) )
//            return;
//
//        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
//            return;
//
//        if (!current_user_can('edit_post', $post_id))
//            return;

        $old = get_post_meta($post_id, 'customdata_group', true);

        $new = array();
        $invoiceItems = $_POST['TitleItem'];
        $prices = $_POST['TitleDescription'];
        $count = count($invoiceItems);
        for ($i = 0; $i < $count; $i++) {
            if ($invoiceItems[$i] != '') :
                $new[$i]['TitleItem'] = stripslashes(strip_tags($invoiceItems[$i]));
                $new[$i]['TitleDescription'] = stripslashes($prices[$i]); // and however you want to sanitize
            endif;
        }
        if (isset($_POST['activationpost'])) {
            $currentClient->updateActivation($_POST['activationpost']);
        }
        if (!empty($new) && $new != $old) {
            update_post_meta($post_id, 'customdata_group', $new);
            update_post_meta($post_id, 'QuestionDisplayType', $_POST['QuestionDisplayType']);
        } elseif (empty($new) && $old)
            delete_post_meta($post_id, 'customdata_group', $old);
    }
}