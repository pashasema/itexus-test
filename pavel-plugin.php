<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Pavel_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Pavel-plugin
 * Description:       Test plugin for itexus.
 * Version:           1.0.0
 * Author:            Pavel Siamenau
 * Author URI:        https://www.linkedin.com/in/pavel-siamenau-403653152/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pavel-plugin
 * Domain Path:       /languages
 * Requires at least: 5.4
 * Requires PHP:      7.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PAVEL_PLUGIN_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pavel-plugin-activator.php
 */
function activate_pavel_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pavel-plugin-activator.php';
	Pavel_Plugin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pavel-plugin-deactivator.php
 */
function deactivate_pavel_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pavel-plugin-deactivator.php';
	Pavel_Plugin_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pavel_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_pavel_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pavel-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pavel_plugin() {

	$plugin = new Pavel_Plugin();
	$plugin->run();

}

//adding plugin page to admin menu
function pavel_plugin_setup_menu(){
  add_menu_page( 'Pavel-plugin Page', 'Pavel-plugin', 'manage_options', 'pavel-plugin', 'pavel_plugin_get_page_url','dashicons-admin-site' );
}


//start page in admin menu
function pavel_plugin_get_page_url(){
  ?>
  <h1>Pavel-plugin</h1>
  <form class="pavel-plugin_form">
    <input type="text" class="pavel-plugin_input" placeholder="Check url">
    <button>Submit</button>
  </form>
  <div class="pavel-plugin_output"></div>
  <?php
}

//adding conditions for displaying the query result
function pavel_plugin_ajax(){

  //get https status code using CURL
  $header_url = $_POST['url'];
  $ch = curl_init($header_url);
  curl_setopt($ch, CURLOPT_HEADER, true);    
  curl_setopt($ch, CURLOPT_NOBODY, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch, CURLOPT_TIMEOUT,10);
  $output = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  //get header information of website page
  //if everything okay - display wepsite in iframe
  if( $httpcode == "200"){
    echo '<iframe width="100%" height="800px" allowfullscreen="allowfullscreen" src="' . $header_url . '"></iframe>';
  }
  //if get 401 code, print this 
  else if($httpcode == "401"){
    echo '<p>You should pay to get access</p>';
  }
  //if get 502 code, print this 
  else if($httpcode == "502"){
    echo '<p>Something went wrong!</p>';
  }
  //if get 301 code, print this 
  else if($httpcode == "301"){
    echo '<p>Сheck request!</p>';
  }
  //if else, print this
  else{
    echo '<p>Erorr!</p>';
  }
  die;
}

add_action('admin_menu', 'pavel_plugin_setup_menu');
add_action('wp_ajax_pavel_plugin_ajax','pavel_plugin_ajax');
add_action('wp_ajax_nopriv_pavel_plugin_ajax','pavel_plugin_ajax');

run_pavel_plugin();
