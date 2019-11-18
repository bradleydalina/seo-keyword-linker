<?php
/**
 * Restrict Direct Access
 */
defined( 'ABSPATH' ) or die( 'The wrong way access...' );
/**
* Plugin Constants
*/
define('SEOKL','seo-keyword-linker');
/**
* Define Constant Directory Paths
*/
define("SEOKL_RELPATH", trailingslashit(realpath(plugin_dir_path(__DIR__))) );
define("SEOKL_ABSPATH", trailingslashit(plugin_dir_url(__DIR__)));

/**
* Plugin Info
*/
define("SEOKL_PLUGNAME", get_plugin_data( realpath(SEOKL_RELPATH)."/".SEOKL.".php" )['Name']);
define("SEOKL_URI", get_plugin_data( realpath(SEOKL_RELPATH)."/".SEOKL.".php" )['PluginURI']);
define('SEOKL_VERSION', get_plugin_data( realpath(SEOKL_RELPATH)."/".SEOKL.".php" )['Version']);
define('SEOKL_DESCRIPTION', get_plugin_data( realpath(SEOKL_RELPATH)."/".SEOKL.".php" )['Description']);
