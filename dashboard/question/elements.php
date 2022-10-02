<?php

use model\WPAction;

if (\model\Question::IsThisQuestion()) {


    function RepeaterTextField(): string
    {

        global $post;
        $gpminvoice_group = get_post_meta($post->ID, 'customdata_group', true);
        wp_nonce_field('gpm_repeatable_meta_box_nonce', 'gpm_repeatable_meta_box_nonce');
        ?>
        <table id="repeatable-fieldset-one" width="100%">
            <tbody>
        <?php
        $html = '';
        if ($gpminvoice_group) :
            foreach ($gpminvoice_group as $field) {
                $html .= '<tr> <td width="15%"> <input type="text" placeholder="Title" name="TitleItem[]" value="' . ($field['TitleItem'] != '' ? $field['TitleItem'] : ' ') . '"/><a class="button remove-row" href="#1">Remove</a></td>';
            }
        else :
            // show a blank one
            $html .= '<tr><td><input name=TitleItem[] placeholder=Title title=Title><td><a class="button button-disabled cmb-remove-row-button"href=#>Remove</a></td>';
        endif;
//        $html .= '<tr class="empty-row screen-reader-text"><td><input name=TitleItem[] placeholder=Title><td><a class="button remove-row"href=#>Remove</a></tr><p><a class=button href=# id=add-row>Add another</a>';
        $html .= '<tr class="empty-row screen-reader-text"><td><input type="text" placeholder="Title" name="TitleItem[]"/></td><td><a class="button remove-row" href="#">Remove</a></td></tr></tbody>
        </table>
        <p><a id="add-row" class="button" href="#">Add another</a></p>';
        return $html;

    }
}