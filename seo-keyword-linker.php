<?php
/**
 * Plugin Name:       SEO Keyword Linker
 * Plugin URI:        http://wordpress.org/plugins/seo-keyword-linker/
 * Description:       Keyword or key-phrase interlinking for a better SEO
 * Version:           1.0
 * Requires at least: 5.3
 * Requires PHP:      7.0
 * Author:            Bradley B. Dalina
 * Author URI:        https://www.bradley-dalina.tk/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       seo-keyword-linker
 */

/**
 * Coding Standard Guide
 * Constants & Defined - Uppercase
 * Variables - Lowercase separated with underscore
 * Function - Camel Case
 */

/**
 * Restrict Direct Access
 */
defined( 'ABSPATH' ) or die( 'The wrong way access...' );
/**
* Inlcudes Required Files
*/
if(!function_exists('get_plugin_data')) require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once( ABSPATH . "wp-includes/pluggable.php" );
require_once( trailingslashit(realpath(plugin_dir_path(__FILE__)))."admin/define.php" );

require_once SEOKL_RELPATH. 'admin/crud.php';
require_once SEOKL_RELPATH. 'admin/table.php';
require_once SEOKL_RELPATH. 'admin/core.php';
