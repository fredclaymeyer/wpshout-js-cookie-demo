<?php
/*
Plugin Name: WPShout JS Cookie Demo
Description: A demo of JS session cookies in a WordPress environment.
Author: WPShout
Author URI: http://wpshout.com
*/
/*
* Setting and retrieving cookie
*/

add_action( 'wp_enqueue_scripts', 'wpshout_cookie_scripts' );
function wpshout_cookie_scripts() {
	wp_enqueue_script( 'wpshout-js-cookie-demo', plugin_dir_url( __FILE__ ) . 'wpshout-js-cookie-demo.js', array( 'jquery', 'cookie' ) );
	wp_enqueue_script( 'cookie', plugin_dir_url( __FILE__ ) . 'cookie.js', array( 'jquery' ) );

	/* Telling the JS file where ajaxUrl is */
	wp_localize_script( 'wpshout-js-cookie-demo', 'ajaxUrl', array( 
		'url' => admin_url() . 'admin-ajax.php',
	) );
}

add_action( 'wp_ajax_wpshout_get_fave_food_cookie', 'wpshout_get_fave_food_cookie' );
add_action( 'wp_ajax_nopriv_wpshout_get_fave_food_cookie', 'wpshout_get_fave_food_cookie' );
function wpshout_get_fave_food_cookie() {
	$cookie = $_POST['cookie'];
	echo $_COOKIE[ $cookie ];
	die;
}

/*
* Displaying cookie value and form through shortcodes
*/
add_shortcode( 'js_cookie_demo', 'wpjcd_show_cookie_result' );
function wpjcd_show_cookie_result() {
	ob_start();
	echo '<div class="current-favorite"></div>';
	return ob_get_clean();
}
add_shortcode( 'js_cookie_form', 'wpjcd_show_cookie_form' );
function wpjcd_show_cookie_form() {
	ob_start(); ?>
		<div class="favorite-food-form">
			<label for="name">Fave Food:</label><br>
			<input type="text" class="favorite-food-input" placeholder="Cookies"><p><button class="favorite-food-submit">Submit</button></p>
		</div>
	<?php return ob_get_clean();
}