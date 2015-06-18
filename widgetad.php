<?php // Creating the widget
require_once(plugin_dir_path( __FILE__ ) . '/rShareAuthors.php');
class rspwidget extends WP_Widget {
    function __construct() {
    parent::__construct(
    'rspwidget',
    __('RSP Ad Widget', 'rspwidget_ad'),
    array( 'description' => __( 'Revenue share Plugin(RSP) Widget', 'rspwidget_ad' ), )
        );
    } // Creating widget front-end |  This is where the action happens
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		} // before and after widget arguments are defined by themes |  This is where you run the code and display the output
        $addimensions = explode ("x", $instance['widgetads']);
        echo adsensewidgetad($addimensions[0], $addimensions[1]);
        echo $args['after_widget'];
        global $post;
        $authorId = $post->post_author;
    }    // Widget Backend
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( '', 'rspwidget_ad' );
        $widgetads = ! empty( $instance['widgetads'] ) ? $instance['widgetads'] : __( '', 'rspwidget_ad' );
// Widget admin form ?>
    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'title' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
      </p><p>
        <label for="<?php echo $this->get_field_id( 'widgetads' ); ?>"><?php _e( 'Ad dimensions:', 'widgetads' ); ?></label>
        <select id="<?php echo $this->get_field_id( 'widgetads' ); ?>" name="<?php echo $this->get_field_name( 'widgetads' ); ?>" type="text">
            <option value="300x250" <?php echo "300x250" == $widgetads ? "selected" : ""; ?>>300x250px</option>
            <option value="336x280" <?php echo "336x280" == $widgetads ? "selected" : ""; ?>>336x280px</option>
            <option value="300x600" <?php echo "300x600" == $widgetads ? "selected" : ""; ?>>300x600px</option>
            <option value="320x100" <?php echo "320x100" == $widgetads ? "selected" : ""; ?>>320x100px</option>
        </select>
    </p>
<?php
    }    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
            $instance = array();            //$instance = $old_instance;
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['widgetads'] = ( ! empty( $new_instance['widgetads'] ) ) ? strip_tags( $new_instance['widgetads'] ) : '';
            return $instance;
    }
} // Class rspwidget ends here | create the ad for the widget
function adsensewidgetad($x, $y) {
            $options = get_option('RSP_options');
            if (!get_option('RSP_options')) {
                return 'Configure RSP settings!';
            }
            $position = '';
            if (array_key_exists('radio_option1', $options)) {
                $position =  $options['radio_option1'];
            }            //get the admin pecentage
            global $post;
            $authorId = $post->post_author;
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
              $input4 = $input3;
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
return $ad_content;
    } // Register and load the widget
function rsp_load_widget() {
	register_widget( 'rspwidget' );
}
add_action( 'widgets_init', 'rsp_load_widget' );
?>
