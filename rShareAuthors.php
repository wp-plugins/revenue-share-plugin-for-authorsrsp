<?php
/*
Plugin Name: Revenue Share for Authors(RSP)
Plugin URI: http://obscurant1st.biz
Description: The plugin enables revenue sharing for authors on your wordpress site.
Version: 1.0.3
Author: Plato P.
Author URI: http://www.obscurant1st.biz
License: GPL2
*/
?>
<?php
/*  Copyright 2012  Plato P.  (email : plato.puthur@gmail.com)

    This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
<?php // add the admin options page
add_action('admin_menu', 'plugin_admin_add_page');
function plugin_admin_add_page() {
add_options_page('Revenue Share Plugin', 'RSP Menu', 'install_plugins', 'RSP_plugin', 'RSP_options_page');
}
?>
<?php // display the admin options page
function RSP_options_page() {
?>
<link href="<?php echo plugins_url().'/revenue-share-plugin-for-authorsrsp'; ?>/rsp_style.css" rel="stylesheet" type="text/css" media="screen" />
<div class="left_rsp">
<h2>Adsense Revenue Share Plugin</h2>
Set the publication id and the position of the ad here!
<form name="pubIdForm" action="options.php" method="post">
<?php settings_fields('RSP_options-group'); ?>
<?php do_settings_sections('RSP_plugin'); ?>
<div align=center><br />
<input class="rsp_submit_buttom" id="RSP_main" name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" /></div>
</form>

<?php 

$options = get_option('RSP_options');
echo '<br /><h3>Current Admin Settings</h3>';
echo 'Adsense Publisher Id:<b>';
echo $options['RSP_text_string'];
echo '<br />';
echo '</b>Adsense Ads will be displayed at the following spots in your post: <b> ';
echo $options['radio_option1'];
echo '<br />';
?></b>
<br /><br /><b>**Note: </b><i>Admin ads will get 50% of the total impressions made by the guest post.</i><b>**</b><br />
</div>
<div class="right_rsp">
    <div id="aligncenter"><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="7EP5PT8ZQ4BPG">
<table>
<tr><td><input type="hidden" name="on0" value="Buy Me Something If You Like the Plugin">Please Donate to Support the Developer.</td></tr><tr><td><select name="os0">
    <option value="I like the plugin">I like the plugin $10.00 USD</option>
    <option value="I love the plugin">I love the plugin $15.00 USD</option>
    <option value="Simply awesome">Simply awesome $20.00 USD</option>
</select> </td></tr>
</table>
<input type="hidden" name="currency_code" value="USD">
<input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form></div>
</div>
<?php
}?>
<?php // add the admin settings and such
add_action('admin_init', 'RSP_admin_init');
function RSP_admin_init(){
register_setting( 'RSP_options-group', 'RSP_options', 'RSP_options_validate' ); ?>
<?php 
add_settings_section('RSP_main', '', 'RSP_section_text', 'RSP_plugin');
add_settings_field('RSP_text_string', 'RSP Adsense Pub Id', 'RSP_setting_string', 'RSP_plugin', 'RSP_main');
add_settings_field('radio_option1', 'RSP Adsense AD Spot', 'RSP_setting_position', 'RSP_plugin', 'RSP_main');
//add_settings_field('radio_option2', 'RSP Adsense Pub Id', 'RSP_setting_string', 'RSP_plugin', 'RSP_main');
//add_settings_field('RSP_text_string', 'RSP Adsense Pub Id', 'RSP_setting_string', 'RSP_plugin', 'RSP_main');
}?>
<?php // validate our options
function RSP_options_validate($input) {
$options = get_option('RSP_options');
return $input;
}
?>
<?php function RSP_setting_string() {
$options = get_option('RSP_options');
echo "<input id='RSP_main' name='RSP_options[RSP_text_string]' size='25' type='text' value='{$options['RSP_text_string']}' />"; ?><br> 
<?php } ?>
<?php function RSP_setting_position() {
    $options = get_option('RSP_options'); ?>
    <select id='RSP_main' name="RSP_options[radio_option1]">
        <option value='Top' <?php selected( $options['radio_option1'], 'Top' ); ?>>Top Spot</option>
        <option value='Middle' <?php selected( $options['radio_option1'], 'Middle' ); ?>>Middle Spot</option>
        <option value='Bottom' <?php selected( $options['radio_option1'], 'Bottom' ); ?>>Bottom Spot</option>
    </select>

   <br />
<?php } ?>
<?php function RSP_section_text() {
echo '';
} ?>
<?php 
add_action( 'show_user_profile', 'adshare_profile_fields' );  
add_action( 'edit_user_profile', 'adshare_profile_fields' );  
    
    function adshare_profile_fields( $user ) { ?>
        <h3>Revenu Share For Authors:</h3>  
        <table class="form-table">  
            <tr>  
                <th><label for="twitter">Adsense Publisher ID</label></th>  
                <td>  
                    <input type="text" name="RSP_text_string" id="RSP_text_string" value="<?php echo esc_attr( get_the_author_meta( 'RSP_text_string', $user->ID ) ); ?>" class="regular-text" /><br />  
                    <span class="description">Add your Publisher ID</span>  
                </td>  
            </tr>  
        </table>  
    <?php }  
    
    add_action( 'personal_options_update', 'adshare_save_profile_fields' );  
    add_action( 'edit_user_profile_update', 'adshare_save_profile_fields' );  
    function adshare_save_profile_fields( $user_id ) {  
        /*if ( !current_user_can( 'edit_user', $user_id ) ){  
            return false;  
        }*/  
        update_usermeta( $user_id, 'RSP_text_string', $_POST['RSP_text_string'] );  
    }

function adsense_ad($content) {  
    $options = get_option('RSP_options');
    if (!get_option('RSP_options')) {
        return $content;
    }
    $position = '';
    if (array_key_exists('radio_option1', $options)) {
        $position =  $options['radio_option1'];
    }
    /*if (array_key_exists('radio_option2', $options)) {
        $position =  $options['radio_option2'];
    }
    if (array_key_exists('radio_option3', $options)) {
        $position =  $options['radio_option3'];
    }*/
    if(get_the_author_meta( 'RSP_text_string' )){
        $input = array($options['RSP_text_string'], get_the_author_meta( 'RSP_text_string' ));
    } else {
        $input = array($options['RSP_text_string']);
    }
    shuffle($input);

    if ($input[0] == 'pub-0000') {
        return $content;
    }
$ad_content = '<div align=center><script type="text/javascript"><!--  
google_ad_client = "ca-'.$input[0].'";  
google_ad_width = 468;  
google_ad_height = 60;  
//-->
</script>  
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script></div>';
    if($position == 'Top') {
        return $ad_content.'<br />'.$content;
    }
    if($position == 'Bottom') {
        return $content.'<br />'.$ad_content;
    }
    if($position == 'Middle') {
        $count_words = strlen($content)/2;
        $insert_ad = strpos($content, '. ', $count_words);
        $ad_content = '<br />'.$ad_content.'<br />';
        return substr_replace($content, $ad_content, $insert_ad+2, 0);
    }
}

add_filter('the_content', 'adsense_ad');
?>
<?php 
    register_activation_hook( __FILE__, 'RSP_activate' );
    function RSP_activate() {
        update_option('RSP_options[radio_option1]','Top');
        update_option('RSP_options[RSP_text_string]','pub-0000');
    }

    register_deactivation_hook(__FILE__, 'RSP_deactivate' );
    function RSP_deactivate() {
        delete_option( 'RSP_options' );
    }
?>