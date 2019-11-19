<?php
/**
 * Restrict Direct Access
 */
defined( 'ABSPATH' ) or die( 'The wrong way access...' );
if ( !class_exists( 'SEOKLPlugin' ) ) {
    /**
    * Plugin Main Class
    */
    class SEOKLPlugin{
        public function __construct(){
            /**
            * Activation, Deactivation And Uninstall Hooks
            */
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
            // add_action( 'wp_enqueue_scripts', array($this,"PublicScripts") );
            //add_action('wp_loaded', array($this, 'AdminScripts'));
            /**
            * Crud Script
            */
            add_action( 'wp_ajax_seokl_crud', array("SEOKLCrud","determine") );
            add_action( 'wp_ajax_nopriv_seokl_crud', array("SEOKLCrud","determine") );
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
                wp_register_script(SEOKL, SEOKL_ABSPATH.'admin/js/'.SEOKL.'.js', null, 1.0, true);//array('wp-util', 'json2')
                wp_localize_script( SEOKL, 'seokl_crud', array("SEOKLCrud","determine") );
                wp_enqueue_script(SEOKL);
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
