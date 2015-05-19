<?php
/*
Plugin Name: Revenue Share for Authors(RSP)
Plugin URI: http://www.techtuft.com/forums/
Description: The plugin enables revenue sharing for authors on your wordpress site.
Version: 2.1.0
Author: Plato P.
Author URI: http://www.techtuft.com
License: GPL2
*/
?>
<?php
/*  Copyright 2015  Plato P.  (email : plato.puthur@gmail.com)
    This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.
    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
    You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
<?php require_once(plugin_dir_path( __FILE__ ) . 'widgetad.php'); ?>
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
                                 echo 'Adsense Publisher Id:';
                                 echo $options['RSP_text_string'];
                                 echo '<br />';
                                 echo 'Adsense Ads will be displayed at the following spots in your post: ';
                                 echo $options['radio_option1'];
                                 echo '<br />';
                                 echo 'Adsense Ads percentage of Authors: ';
                                 echo $options['adshare_percentage'];
                                 echo '<br />';
?>
    </div>
<div class="right_rsp">
    <div id="aligncenter">
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="7EP5PT8ZQ4BPG">
            <table>
                <tr><td><input type="hidden" name="on0" value="Buy Me Something If You Like the Plugin">Please Donate to Support the Developer. </td>               </tr><tr><td><select name="os0">
                <option value="I like the plugin">I like the plugin $10.00 USD</option>
                <option value="I love the plugin">I love the plugin $15.00 USD</option>
                <option value="Simply awesome">Simply awesome $20.00 USD</option>
                </select> </td></tr>
            </table>
            <input type="hidden" name="currency_code" value="USD">
            <input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
        </form></div>
        <div align=center>
          <div class="widgethelp">
            <h1> Help!!!</h1>
            <p>All requests for help, new features and bug reports should be posted at <h2><a href="http://techtuft.com/forums">RSP Help - Techtuft</a><h2></p>
          </div>
            <div class="widgethelp">
              <p>**Note:<i>You can choose to display the ads on the sidebar by adding the RSP widget to your sidebar by dragging and dropping from your admin widgets area.</i></p>
            </div>
    </div>
<?php
} ?>
<?php // add the admin settings and such
    add_action('admin_init', 'RSP_admin_init');
    function RSP_admin_init(){
        register_setting( 'RSP_options-group', 'RSP_options', 'RSP_options_validate' ); ?>
<?php
        add_settings_section('RSP_main', '', 'RSP_section_text', 'RSP_plugin');
        add_settings_field('RSP_text_string', 'RSP Adsense Pub Id', 'RSP_setting_string', 'RSP_plugin', 'RSP_main');
        add_settings_field('RSP_adslot', 'RSP Adsense Admin Adslot', 'RSP_setting_adslot', 'RSP_plugin', 'RSP_main');
        add_settings_field('radio_option1', 'RSP Adsense AD Spot', 'RSP_setting_position', 'RSP_plugin', 'RSP_main');
        add_settings_field('adshare_percentage', 'RSP Author Adshare Percent', 'RSP_setting_percent', 'RSP_plugin', 'RSP_main');
        add_settings_field('rsp_user_level', 'Lowest Level of User with Adsense Share', 'RSP_setting_usrlvl', 'RSP_plugin', 'RSP_main');
} ?>
<?php // validate our options
    function RSP_options_validate($input) {
        $options = get_option('RSP_options');
        return $input;
} ?>
<?php function RSP_setting_string() {
        $options = get_option('RSP_options');
        echo "<input id='RSP_main' name='RSP_options[RSP_text_string]' size='25' type='text' value='{$options['RSP_text_string']}' />"; ?><br>
<?php } ?>
<?php function RSP_setting_adslot() {
        $options = get_option('RSP_options');
        echo "<input id='RSP_main' name='RSP_options[RSP_adslot]' size='25' type='text' value='{$options['RSP_adslot']}' />"; ?><br>
<?php } ?>
<?php function RSP_setting_percent() {
  $options = get_option('RSP_options');
  echo "<input id='RSP_main' name='RSP_options[adshare_percentage]' maxlength='2' size='2' type='text' value='{$options['adshare_percentage']}' />"; ?><br>
<?php } ?>
<?php function RSP_setting_position() {
    $options = get_option('RSP_options'); ?>
    <select id='RSP_main' name="RSP_options[radio_option1]">
        <option value='Top' <?php selected( $options['radio_option1'], 'Top' ); ?>>Top Spot</option>
        <option value='Middle' <?php selected( $options['radio_option1'], 'Middle' ); ?>>Middle Spot</option>
        <option value='Bottom' <?php selected( $options['radio_option1'], 'Bottom' ); ?>>Bottom Spot</option>
        <option value='Disabled' <?php selected( $options['radio_option1'], 'Disabled' ); ?>>Disabled</option>
    </select>
   <br />
<?php } ?>
<?php function RSP_setting_usrlvl() {
  $options = get_option('RSP_options'); ?>
  <select id='RSP_main' name="RSP_options[rsp_user_level]">
      <option value='Admin' <?php selected( $options['rsp_user_level'], 'Admin' ); ?>>Admin</option>
      <option value='Editor' <?php selected( $options['rsp_user_level'], 'Editor' ); ?>>Editor</option>
      <option value='Author' <?php selected( $options['rsp_user_level'], 'Author' ); ?>>Author</option>
      <option value='Contributor' <?php selected( $options['rsp_user_level'], 'Contributor' ); ?>>Contributor</option>
  </select>
 <br />
<?php } ?>
<?php function RSP_section_text() {
echo '';
} ?>
<?php
add_action( 'show_user_profile', 'adshare_profile_fields' );
add_action( 'edit_user_profile', 'adshare_profile_fields' );
    function adshare_profile_fields( $user ) {
      $options = get_option('RSP_options');
      $usrlvl =  $options['rsp_user_level'];
      if($usrlvl == "Contributor") {
        if( !current_user_can( 'edit_posts' ) )
        return;
      } else if($usrlvl == "Author") {
        if( !current_user_can('publish_posts'))
        return;
      } else if($usrlvl == "Editor") {
        if( !current_user_can('delete_others_posts'))
        return;
      } else {
        if( !current_user_Can('edit_dashboard'))
        return;
      }
      ?>
        <h3>Revenu Share For Authors:</h3>
        <table class="form-table">
            <tr>
                <th><label for="twitter">Adsense Publisher ID</label></th>
                <td>
                    <input type="text" name="RSP_text_string" id="RSP_text_string" value="<?php echo esc_attr( get_the_author_meta( 'RSP_text_string', $user->ID ) ); ?>" class="regular-text" /><br />
                    <span class="description">Add your Publisher ID</span>
                </td>
                <th><label for="adslotid">Adsense Adlost/Adunit ID</label></th>
                <td>
                    <input type="text" name="RSP_adslot" id="RSP_adslot" value="<?php echo esc_attr( get_the_author_meta( 'RSP_adslot', $user->ID ) ); ?>" class="regular-text" /><br />
                    <span class="description">Add your Adunit ID/Adslot</span>
                </td>
            </tr>
        </table>
<?php }
    add_action( 'personal_options_update', 'adshare_save_profile_fields' );
    add_action( 'edit_user_profile_update', 'adshare_save_profile_fields' );
    function adshare_save_profile_fields( $user_id ) {
      $options = get_option('RSP_options');
      $usrlvl =  $options['rsp_user_level'];
      if($usrlvl == "Contributor") {
        if( !current_user_can( 'edit_posts' ) )
        return;
      } else if($usrlvl == "Author") {
        if( !current_user_can('publish_posts'))
        return;
      } else if($usrlvl == "Editor") {
        if( !current_user_can('delete_others_posts'))
        return;
      } else {
        if( !current_user_Can('edit_dashboard'))
        return;
      }
      update_usermeta( $user_id, 'RSP_text_string', sanitize_text_field($_POST['RSP_text_string']) );
      update_usermeta( $user_id, 'RSP_adslot', sanitize_text_field($_POST['RSP_adslot']) );
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
    global $post;
    $authorId = $post->ID;
    $adpercent = $options['adshare_percentage']; //store both adsense pub ids(author and admin)
    if(get_the_author_meta( 'RSP_text_string', $authorId ) != ""){
      $input1 = $options['RSP_text_string'];
      $input2 = get_the_author_meta( 'RSP_text_string', $authorId );
    } else {
      $input1 = $options['RSP_text_string'];
      $input2 = $input1;
    }//randomize the admin/author accordingly
    if(get_the_author_meta( 'RSP_adslot', $authorId ) != ""){
      $input3 = $options['RSP_adslot'];
      $input4 = get_the_author_meta( 'RSP_adslot', $authorId );
    } else {
      $input3 = $options['RSP_adslot'];
      $input4 = $input1;
    }
    if (rand(1,100) > $adpercent) {
      $flag = $input1;
      $adslot = $input3;
    } else {
      $flag = $input2;
      $adslot = $input4;
    }
    if ($input1 == 'pub-0000') {
        return $content;
    }
    $ad_content = '<div align="center"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- 468x60, created 9/9/10 -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:468px;height:60px"
         data-ad-client="ca-'.$flag.'"
         data-ad-slot="'.$adslot.'"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script></div>';
  if($position == 'Top') {
    return $ad_content.'<br />'.$content;
  } else if($position == 'Bottom') {
    return $content.'<br />'.$ad_content;
  } else if($position == 'Middle') {
    $count_words = strlen($content)/2;
    $insert_ad = strpos($content, '. ', $count_words);
    $ad_content = '<br />'.$ad_content.'<br />';
    return substr_replace($content, $ad_content, $insert_ad+2, 0);
  } else if($position == 'Disabled') {
    return $content;
  }
}
add_filter('the_content', 'adsense_ad');
?>
<?php
    register_activation_hook( __FILE__, 'RSP_activate' );
    function RSP_activate() {
        update_option('RSP_options[radio_option1]','Top');
        update_option('RSP_options[RSP_text_string]','pub-0000');
        update_option('RSP_options[adshare_percentage]','00');
    }
    register_deactivation_hook(__FILE__, 'RSP_deactivate' );
    function RSP_deactivate() {
        delete_option( 'RSP_options' );
    }
?>
<?php
  function rspad300x250_func( $atts ) {
    $atts = shortcode_atts(
    array(
      'width' => '300',
      'height' => '250',
    ), $atts, 'rspad300x250' );
    return adsenseshortcutad($atts['width'],$atts['height']);
  }
  function rspad336x280_func( $atts ) {
    $atts = shortcode_atts(
    array(
      'width' => '336',
      'height' => '280',
    ), $atts, 'rspad336x280' );
    return adsenseshortcutad($atts['width'],$atts['height']);
  }
  function rspad728x90_func( $atts ) {
    $atts = shortcode_atts(
    array(
      'width' => '728',
      'height' => '90',
    ), $atts, 'rspad728x90' );
    return adsenseshortcutad($atts['width'],$atts['height']);
  }
  function rspad300x600_func( $atts ) {
    $atts = shortcode_atts(
    array(
      'width' => '300',
      'height' => '600',
    ), $atts, 'rspad300x600' );
    return adsenseshortcutad($atts['width'],$atts['height']);
  }
  function rspad320x100_func( $atts ) {
    $atts = shortcode_atts(
    array(
      'width' => '320',
      'height' => '100',
    ), $atts, 'rspad320x100' );
    return adsenseshortcutad($atts['width'],$atts['height']);
  }
  function rspad468x60_func( $atts ) {
    $atts = shortcode_atts(
    array(
      'width' => '468',
      'height' => '60',
    ), $atts, 'rspad468x60' );
    return adsenseshortcutad($atts['width'],$atts['height']);
  }
  function rspad300x1050_func( $atts ) {
    $atts = shortcode_atts(
    array(
      'width' => '300',
      'height' => '1050',
    ), $atts, 'rspad300x1050' );
    return adsenseshortcutad($atts['width'],$atts['height']);
  }
  function rspad970x90_func( $atts ) {
    $atts = shortcode_atts(
    array(
      'width' => '970',
      'height' => '90',
    ), $atts, 'rspad970x90' );
    return adsenseshortcutad($atts['width'],$atts['height']);
  }
  add_shortcode( 'rspad300x250', 'rspad300x250_func' );
  add_shortcode( 'rspad300x250', 'rspad300x250_func' );
  add_shortcode( 'rspad336x280', 'rspad336x280_func' );
  add_shortcode( 'rspad728x90', 'rspad728x90_func' );
  add_shortcode( 'rspad300x600', 'rspad300x600_func' );
  add_shortcode( 'rspad320x100', 'rspad320x100_func' );
  add_shortcode( 'rspad468x60', 'rspad468x60_func' );
  add_shortcode( 'rspad300x1050', 'rspad300x1050_func' );
  add_shortcode( 'rspad970x90', 'rspad970x90_func' );
  ?>
<?php //function for shortcode with height and width as parameters
  function adsenseshortcutad($x, $y) {
    $options = get_option('RSP_options');
    if (!get_option('RSP_options')) {
      return 'Configure RSP settings!';
    }         //get the admin pecentage
    global $post;
    $authorId = $post->ID;
    $adpercent = $options['adshare_percentage']; //store both adsense pub ids(author and admin)
    if(get_the_author_meta( 'RSP_text_string', $authorId ) != ""){
      $input1 = $options['RSP_text_string'];
      $input2 = get_the_author_meta( 'RSP_text_string', $authorId );
    } else {
      $input1 = $options['RSP_text_string'];
      $input2 = $input1;
    }            //randomize the admin/author accordingly
    if(get_the_author_meta( 'RSP_adslot', $authorId ) != ""){
      $input3 = $options['RSP_adslot'];
      $input4 = get_the_author_meta( 'RSP_adslot', $authorId );
    } else {
      $input3 = $options['RSP_adslot'];
      $input4 = $input1;
    }
    if (rand(1,100) > $adpercent) {
      $flag = $input1;
      $adslot = $input3;
    } else {
      $flag = $input2;
      $adslot = $input4;
    }
    $ad_content = '<div align="center"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- 468x60, created 9/9/10 -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:'.$x.'px;height:'.$y.'px"
         data-ad-client="ca-'.$flag.'"
         data-ad-slot="'.$adslot.'"></ins>
         <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
         </script></div>';
    return '<br />'.$ad_content.'<br />';
} ?>
