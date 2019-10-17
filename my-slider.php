<?php
/**
 * My Slider
 *
 * @package           My Slider
 * @author            Umuthan Uyan
 * @copyright         2019
 * @license           GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       My Slider
 * Plugin URI:        https://wordpress.org/plugins/my-slider/
 * Description:       Animated Slider for your Wordpress Site
 * Version:           1.1.0
 * Requires at least: 4.0
 * Requires PHP:      5.0
 * Author:            Umuthan Uyan
 * Author URI:        http://umuthan.com
 * Text Domain:       my-slider
 * License:           GPL v3 or later
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */

include('includes/functions.php');
include('includes/post-type.php');
include('includes/shortcode.php');
include('includes/widget.php');

/**
 * Add scripts and css to frontend
 */
add_action('wp_enqueue_scripts', 'my_slider_callback_for_setting_up_script');
function my_slider_callback_for_setting_up_script() {
  wp_register_style( 'my-slider-foundation-css', plugin_dir_url( __FILE__ ).'vendor/css/foundation.min.css' );
  wp_enqueue_style( 'my-slider-foundation-css' );
  wp_register_style( 'my-slider-css', plugin_dir_url( __FILE__ ).'css/style.css' );
  wp_enqueue_style( 'my-slider-css' );
  wp_enqueue_script( 'my-slider-foundation-js', plugin_dir_url( __FILE__ ).'vendor/js/foundation.min.js', '', '', true  );
  wp_enqueue_script( 'my-slider-what-input-js', plugin_dir_url( __FILE__ ).'vendor/js/what-input.js', '', '', true  );
  wp_enqueue_script( 'my-slider-app-js', plugin_dir_url( __FILE__ ).'js/app.js', '', '', true );
}
