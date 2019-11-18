<?php
/**
 * Restrict Direct Access
 */
defined( 'ABSPATH' ) or die( 'The wrong way access...' );
if ( !class_exists( 'SEOKLCrud' ) ) {
    /**
    * Plugin Main Class
    */
    class SEOKLCrud{
        public function determine(){
            SEOKLPlugin::Authorize();
            if ( ! empty( $_POST ) && isset( $_POST['seokl-addform-action'] ) ) {
                if(! isset( $_POST['seokl-addform-action'] ) || ! wp_verify_nonce( $_POST['seokl-addform-action'], 'seokl-addform-nonce' )){
                    wp_send_json(array(
                      'message' => 'Sorry, your nonce was incorrect. Please try again.',
                      'error'      => false,
                    ));
                }
                else {
                    print_r($_POST);
                    // $data=array(
                    //     "keyword" => sanitize_text_field($_POST["keyword"]),
                    // 	"target_url" => sanitize_text_field($_POST["target_url"]),
                    // 	"post_type" => sanitize_text_field($_POST["post_type"]),
                    // 	"specific_pages" => sanitize_text_field($_POST["specific_pages"]),
                    // 	"window_tab" => sanitize_text_field($_POST["window_tab"]),
                    // 	"rel" => sanitize_text_field($_POST["rel"]),
                    // 	"regex" => false,
                    // 	"download" => false
                    // );
                }
            }
            else{
                $localize = array(
                                    'ajax_url' => admin_url( 'admin-ajax.php' ),
                                    "ajax_nonce"=>wp_create_nonce("wp_rest"),//nonce
                                    "ajax_action"=>"seokl_crud",
                                    "site_url"=>get_site_url(),
                                    "plugin_url"=>SEOKL_ABSPATH,
                                    "plugin_path"=>SEOKL_RELPATH,
                                    "plugin_name"=>SEOKL,
                                );
                wp_send_json($localize);
            }

        }
        public static function insert_data($data){
            global $wpdb;
            $data["date"] = current_time( 'mysql' );
        	$wpdb->insert($table_name, $data );
            wp_send_json(array(
              'message' => 'New keyword was saved in the database!',
              'error'      => false,
            ));
        }
        public static function update_data(){

        }
        public static function delete_data(){

        }
        public static function read_data(){

        }
    }
}
