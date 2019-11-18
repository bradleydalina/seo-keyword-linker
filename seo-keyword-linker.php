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

if ( !class_exists( 'SEOKLPlugin' ) ) {
    /**
    * Plugin Main Class
    */
    class SEOKLPlugin{
        public function __construct(){
            /**
            * Activation, Deactivation And Uninstall Hooks
            */
            require_once SEOKL_RELPATH. 'admin/table.php';
            $this->Activate();
            $this->Uninstall();
        }
        public static function Authorize(){
            /**
            * Check User Capability
            */
            if ( ! is_user_logged_in() ) {
                add_action( 'admin_menu', array($this,'RemoveMenu') );
                wp_die( ( 'You do not have sufficient permissions to access this page.' ) );
            }
            if ( !current_user_can( 'manage_options' ) ) {
                add_action( 'admin_menu', array($this,'RemoveMenu') );
                wp_die( ( 'You do not have sufficient permissions to access this page.' ) );
            }
            if ( ! is_admin() ) {
                add_action( 'admin_menu', array($this,'RemoveMenu') );
                wp_die( ( 'You do not have sufficient permissions to access this page. Please contact your administrator.' ) );
            }
        }
        public function Activate() {
            /**
            * The Plugin Activation Hook
            * Register plugin Menu
            */
            add_action( "admin_menu", array($this,"RegisterMenu") );
            /**
            * Scripts and Css Styles Registration
            */
            add_action( 'admin_enqueue_scripts', array($this,"AdminScripts") );
            // wp_ajax( 'seokl', array("SEOKLTable","insert_data") );
            //wp_ajax_no_priv( 'seokl', array("SEOKLTable","insert_data") );

            // add_action( 'wp_enqueue_scripts', array($this,"PublicScripts") );
            /**
            * Filters: Triggers before the actual saving of content post
            */
            //add_filter( 'content_save_pre', array($this,'LinkBeforeSave'), 100, 1);
            /**
            * Run Interlinker on Output process as fallback if not covered with the InterlinkBeforeSave
            */
            //add_filter('the_content', array($this,'LinkOnRender'), 100);
            /**
            * Create Database
            */
            register_activation_hook( __FILE__, array( 'SEOKLTable' , 'generate_table' ) );
        }
        public function Uninstall() {
            /**
            * The Plugin Uninstall Hook
            * Delete Plugin Options in the Database
            */
            register_uninstall_hook(  __FILE__, array( 'SEOKLTable' , 'erase_table' ) );
        }
        public function RegisterMenu() {
            /**
            * The Plugin Register Menu under Media Files
            * add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function = '' )
            */
            add_submenu_page(
                "tools.php",
                __("SEO Keyword Linker", SEOKL),
                __("SEO Keyword Linker", SEOKL),
                "manage_options",
                SEOKL,
                //array($this,"Dashboard")
                array("SEOKLTable","display_table")
            );
        }
        public function RemoveMenu() {
            /**
            * The Plugin Unregister Menu
            */
            remove_submenu_page( "options-general.php", SEOKL );
        }
        public function Dashboard() {
            self::Authorize();
            require_once SEOKL_RELPATH . 'admin/dashboard.php';
        }
        public function AdminScripts($hook_suffix) {
            /**
            * Plugin Backend Scripts and Styles Inclusion
            */
            global $pagenow;
            /**
            * Donot Load Anywhere if Not in this Page, To Avoid Heavy Loads
            * echo $hook_suffix .'===tools_page_'.SEOKL;
            */
            if ($pagenow === 'tools.php' && ($hook_suffix ===SEOKL || $hook_suffix ==='tools_page_'.SEOKL)) {
                wp_enqueue_style(SEOKL, SEOKL_ABSPATH.'admin/css/'.SEOKL.'.css');
                $localize = array(
                                    'ajax_url' => admin_url( 'admin-ajax.php' ),
                                    "ajax_nonce"=>wp_create_nonce("nonce"),
                                    "site_url"=>get_site_url(),
                                    "plugin_url"=>SEOKL_ABSPATH,
                                    "plugin_path"=>SEOKL_RELPATH,
                                    "plugin_name"=>SEOKL,
                                );
                wp_enqueue_script(SEOKL, SEOKL_ABSPATH.'admin/js/'.SEOKL.'.js', null, 1.0, true);//array('wp-util', 'json2')
                wp_localize_script( SEOKL, 'seokl', $localize );
            }
        }
        // public function LinkBeforeSave($content) {
        //     /**
        //     * This functions Run the filter in every img occurence
        //     */
        //     for($i = 0; $i < count($this->interlink); $i++){
        //         $keyword= "<a href=\"{$this->interlink['url']}\">".esc_attr(ucwords( strtolower( trim($this->interlink['keyword']) ) ))."</a>";
        //         $content = preg_replace("/{$this->interlink['keyword']}/smi", $keyword, $content, -1, $count);
        //     }
        //     return $content;
        // }
        // public function LinkOnRender($content) {
        //     /**
        //     * Onload of the page or post
        //     * No touching in the database
        //     */
        //     // Match All Keywords present in the post
        //     return $content;
        // }
    }
    $SEOKLPlugin  = new SEOKLPlugin();
}
