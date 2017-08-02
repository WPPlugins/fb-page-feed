<?php

/*
Plugin Name: FB Page Feed
Plugin URI: https://wordpress.org/support/profile/bruterdregz
Description: The FB Page Feed is a great addition to your website to display Facebook Feeds on your website. It allows visitors to your page access your Facebook news feed, photos, videos, posts and more, all without ever leaving your website. The FB Page Feed is available on the Wordpress platform and works with all versions.
Version: 1.0
Author: Bruter Dregz
Author URI: https://wordpress.org/support/profile/bruterdregz
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

*/
class FacebookPageFeeds{

    

    public $options;

    

    public function __construct() {

        $this->options = get_option('fbpf_page_plugin_feed_options');

        $this->fbpf_page_feed_register_settings_and_fields();

    }

    

    public static function add_fbpf_page_feed_tools_options_page(){

        add_options_page('FB Page Feed', 'FB Page Feed ', 'administrator', __FILE__, array('FacebookPageFeeds','fbpf_page_feed_tools_options'));

    }

    

    public static function fbpf_page_feed_tools_options(){

?>

<div class="wrap">
    <h2>FB Page Feed Settings</h2>

    <form method="post" action="options.php" enctype="multipart/form-data">

        <?php settings_fields('fbpf_page_plugin_feed_options'); ?>

        <?php do_settings_sections(__FILE__); ?>

        <p class="submit">

            <input name="submit" type="submit" class="button-primary" value="Save Changes"/>

        </p>

    </form>

</div>

<?php

    }

    public function fbpf_page_feed_register_settings_and_fields(){

        register_setting('fbpf_page_plugin_feed_options', 'fbpf_page_plugin_feed_options',array($this,'fbpf_page_validate_settings'));

        add_settings_section('fbpf_page_main_section', 'Settings', array($this,'fbpf_page_main_section'), __FILE__);

        //Start Creating Fields and Options

        //pageURL

        add_settings_field('pageURL', 'FB Page URL', array($this,'pageURL_settings'), __FILE__,'fbpf_page_main_section');

        //marginTop

        add_settings_field('marginTop', 'Margin Top', array($this,'marginTop_settings'), __FILE__,'fbpf_page_main_section');

        //alignment option

		 add_settings_field('alignment', 'Alignment Position', array($this,'position_settings'),__FILE__,'fbpf_page_main_section');
		 
		 //height

        add_settings_field('height', 'Height', array($this,'height_settings'), __FILE__,'fbpf_page_main_section');

        //width

        add_settings_field('width', 'Width', array($this,'width_settings'), __FILE__,'fbpf_page_main_section');

        
         //show_faces options

        add_settings_field('show_faces', 'Show Faces', array($this,'show_faces_settings'),__FILE__,'fbpf_page_main_section');

        //posts_settings

        add_settings_field('posts', 'Display Posts', array($this,'posts_settings'),__FILE__,'fbpf_page_main_section');

        //hide_cover_settings options

        add_settings_field('hide_cover', 'Hide cover', array($this,'hide_cover_settings'),__FILE__,'fbpf_page_main_section');

     

		

        //jQuery options

        

    }

    public function fbpf_page_validate_settings($plugin_options){

        return($plugin_options);

    }

    public function fbpf_page_main_section(){

        //optional

    }

   

    //pageURL_settings

    public function pageURL_settings() {

        if(empty($this->options['pageURL'])) $this->options['pageURL'] = "https://www.facebook.com/facebook";

        echo "<input name='fbpf_page_plugin_feed_options[pageURL]' type='text' value='{$this->options['pageURL']}' />";

    }

     //marginTop_settings

    public function marginTop_settings() {

        if(empty($this->options['marginTop'])) $this->options['marginTop'] = "100";

        echo "<input name='fbpf_page_plugin_feed_options[marginTop]' type='text' value='{$this->options['marginTop']}' />";

    }

    	//alignment_settings

    public function position_settings(){

        if(empty($this->options['alignment'])) $this->options['alignment'] = "left";

        $items = array('left','right');

        echo "<select name='fbpf_page_plugin_feed_options[alignment]'>";

        foreach($items as $item){

            $selected = ($this->options['alignment'] === $item) ? 'selected = "selected"' : '';

            echo "<option value='$item' $selected>$item</option>";

        }

        echo "</select>";

    }

  

    //width_settings

    public function width_settings() {

        if(empty($this->options['width'])) $this->options['width'] = "292";

        echo "<input name='fbpf_page_plugin_feed_options[width]' type='text' value='{$this->options['width']}' />";

    }

    //height_settings

    public function height_settings() {

        if(empty($this->options['height'])) $this->options['height'] = "400";

        echo "<input name='fbpf_page_plugin_feed_options[height]' type='text' value='{$this->options['height']}' />";

    }

    //show_faces_settings

    public function show_faces_settings(){

        if(empty($this->options['show_faces'])) $this->options['show_faces'] = "true";

        $items = array('true','false');

        echo "<select name='fbpf_page_plugin_feed_options[show_faces]'>";

        foreach($items as $item){

            $selected = ($this->options['show_faces'] === $item) ? 'selected = "selected"' : '';

            echo "<option value='$item' $selected>$item</option>";

        }

        echo "</select>";

    }

    //posts_settings

    public function posts_settings(){

        if(empty($this->options['posts_settings'])) $this->options['posts'] = "true";

        $items = array('true','false');

        echo "<select name='fbpf_page_plugin_feed_options[posts]'>";

        foreach($items as $item){

            $selected = ($this->options['posts'] === $item) ? 'selected = "selected"' : '';

            echo "<option value='$item' $selected>$item</option>";

        }

        echo "</select>";

    }

   

    //hide_cover_settings

    public function hide_cover_settings(){

        if(empty($this->options['hide_cover'])) $this->options['hide_cover'] = "false";

        $items = array('false','true');

        echo "<select name='fbpf_page_plugin_feed_options[hide_cover]'>";

        foreach($items as $item){

            $selected = ($this->options['hide_cover'] === $item) ? 'selected = "selected"' : '';

            echo "<option value='$item' $selected>$item</option>";

        }

        echo "</select>";

    }

    

   



    

    // put jQuery settings before here

}

add_action('admin_menu', 'fbpf_page_feed_trigger_options_function');



function fbpf_page_feed_trigger_options_function(){

    FacebookPageFeeds::add_fbpf_page_feed_tools_options_page();

}



add_action('admin_init','fbpf_page_feed_trigger_create_object');

function fbpf_page_feed_trigger_create_object(){

    new FacebookPageFeeds();

}

add_action('wp_footer','fbpf_page_feed_add_content_in_footer');

function fbpf_page_feed_add_content_in_footer(){

    

    $option_value = get_option('fbpf_page_plugin_feed_options');

    extract($option_value);



$facebook_page_output = '';

$facebook_page_output .= 

'<div class="fb-page" data-href="'.$pageURL.'" 

data-width="'.$width.'" data-height="'.$height.'" 

data-hide-cover="'.$hide_cover.'" 

data-show-facepile="'.$show_faces.'" 

data-show-posts="'.$posts.'">

</div>';

$imgURL = plugins_url( 'assets/facebook-icon.png' , __FILE__ );


?>

<div id="fb-root"></div>

<script>(function(d, s, id) {

  var js, fjs = d.getElementsByTagName(s)[0];

  if (d.getElementById(id)) return;

  js = d.createElement(s); js.id = id;

  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=262562957268319";

  fjs.parentNode.insertBefore(js, fjs);

}(document, 'script', 'facebook-jssdk'));</script>





<?php if($alignment=='left'){?>

<div id="real_facebook_display">

	<div id="fsbbox1" style="left: -<?php echo trim($width+10);?>px; top: <?php echo $marginTop;?>px; z-index: 10000; height:<?php echo trim($height+15);?>px;">

		<div id="fsbbox2" style="text-align: left;width:<?php echo trim($width);?>px;height:<?php echo trim($height);?>;">

			<a class="open" id="fblink" href="#"></a><img style="top: 0px;right:-49px;" src="<?php echo $imgURL;?>" alt="">

			<?php echo $facebook_page_output; ?>

		</div>

	</div>

</div>

<script type="text/javascript">
jQuery(document).ready(function(){
jQuery("#fsbbox1").hover(function(){ 
jQuery('#fsbbox1').css('z-index',101009);
jQuery(this).stop(true,false).animate({left:  0}, 500); },
function(){ 
	jQuery('#fsbbox1').css('z-index',10000);
	jQuery("#fsbbox1").stop(true,false).animate({left: -<?php echo trim($width+10); ?>}, 500); });

});
</script>
<?php } else { ?>
<div id="real_facebook_display">

	<div id="fsbbox1" style="right: -<?php echo trim($width+10);?>px; top: <?php echo $marginTop;?>px; z-index: 10000; height:<?php echo trim($height+15);?>px;">

		<div id="fsbbox2" style="text-align: left;width:<?php echo trim($width);?>px;height:<?php echo trim($height);?>;">

			<a class="open" id="fblink" href="#"></a><img style="top: 0px;left:-49px;" src="<?php echo $imgURL;?>" alt="">

			<?php echo $facebook_page_output; ?>

		</div>

	</div>

</div>

<script type="text/javascript">
jQuery(document).ready(function(){
jQuery("#fsbbox1").hover(function(){ 
jQuery('#fsbbox1').css('z-index',101009);
jQuery(this).stop(true,false).animate({right:  0}, 500); },
function(){ 
	jQuery('#fsbbox1').css('z-index',10000);
	jQuery("#fsbbox1").stop(true,false).animate({right: -<?php echo trim($width+10); ?>}, 500); });
}); 



</script>

<?php } ?>

<?php

}

add_action( 'wp_enqueue_scripts', 'register_fbpf_facebook_page_feed_styles' );

 function register_fbpf_facebook_page_feed_styles() {

 	wp_register_style( 'register_fbpf_facebook_page_feed_styles', plugins_url( 'assets/style.css' , __FILE__ ) );

 	wp_enqueue_style( 'register_fbpf_facebook_page_feed_styles' );

        wp_enqueue_script('jquery');

 }

 $fbpf_page_feed_default_values = array(

     

     'marginTop' => 100,

     'pageURL' => 'http://www.facebook.com/facebook',
	 
	 'height' => '400',

     'width' => '292',

     'posts' => 'false',

     'data_hide' => 'light',

     'show_faces' => 'true',

	 'alignment' => 'left'

	

   );

 

 add_option('fbpf_page_plugin_feed_options', $fbpf_page_feed_default_values);