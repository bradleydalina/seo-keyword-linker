<?php
/**
 * Restrict Direct Access
 */
defined( 'ABSPATH' ) or die( 'The wrong way access...' );

if(!class_exists('WP_List_Table')){
    require_once( SEOKL_RELPATH . 'libraries/class-wp-list-table.php' );
}
if ( !class_exists( 'SEOKLTable' ) ) {
    /**
    * Table Main Class
    */
    class SEOKLTable extends WP_List_Table {
        /**
         * Constructor, we override the parent to pass our own arguments
         * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
         */
         var $example_data = array(
            array(
                'ID'        => 1,
                'keyword'     => 'contact us',
                'target_url'    => '/contact-us/',
                // 'window_tab'  => '_self',
                // 'rel'  => 'noreferrer',
                'time' => '2019-11-16 12:00:00'
            ),
            array(
                'ID'        => 2,
                'keyword'     => 'learn more',
                'target_url'    => '/about-us/',
                // 'window_tab'  => '_self',
                // 'rel'  => 'noreferrer',
                'time' => '2019-11-16 02:00:00'
            ),
            array(
                'ID'        => 3,
                'keyword'     => 'online form',
                'target_url'    => '/contact-us/',
                // 'window_tab'  => '_self',
                // 'rel'  => 'noreferrer',
                'time' => '2019-11-16 01:00:00'
            ),
            array(
                'ID'        => 4,
                'keyword'     => 'reviews',
                'target_url'    => '/about-us/reviews/',
                // 'window_tab'  => '_self',
                // 'rel'  => 'noreferrer',
                'time' => '2019-11-16 02:00:00'
            ),
            array(
                'ID'        => 5,
                'keyword'     => 'testimonials',
                'target_url'    => '/about-us/reviews/',
                // 'window_tab'  => '_self',
                // 'rel'  => 'noreferrer',
                'time' => '2019-11-16 02:00:00'
            ),
            array(
                'ID'        => 6,
                'keyword'     => 'get a quote',
                'target_url'    => '/contact-us/',
                // 'window_tab'  => '_self',
                // 'rel'  => 'noreferrer',
                'time' => '2019-11-16 02:00:00'
            ),
            array(
                'ID'        => 7,
                'keyword'     => 'free estimate',
                'target_url'    => '/contact-us/',
                // 'window_tab'  => '_self',
                // 'rel'  => 'noreferrer',
                'time' => '2019-11-16 02:00:00'
            ),
            array(
                'ID'        => 8,
                'keyword'     => 'schedule a free estimate',
                'target_url'    => '/contact-us/',
                // 'window_tab'  => '_self',
                // 'rel'  => 'noreferrer',
                'time' => '2019-11-16 02:00:00'
            ),
        );
        public function __construct() {
            global $status, $page;
            parent::__construct( array(
                'singular'=> 'singular_SEOKL', //Singular label
                'plural' => 'plural_SEOKL', //plural label, also this well be one of the table css class
                'ajax'   => true //Support Ajax for this table
               ) );
         }
        public static function generate_table() {
            /**
            * Create Database
            *
            * @since		1.0
            */
            global $wpdb;
            global $SEOKL_table_name;
            global $SEOKL_db_version;
            $SEOKL_db_version = '1.0';
            $SEOKL_table_name = $wpdb->prefix . 'SEOKL';
        	$charset_collate = $wpdb->get_charset_collate();

        	$sql = "CREATE TABLE $SEOKL_table_name (
        		id mediumint(9) NOT NULL AUTO_INCREMENT,                    # 1
                keyword mediumtext NOT NULL,                                # keyword
        		target_url mediumtext DEFAULT '' NOT NULL,                         # https://
                window_tab varchar(15) DEFAULT '_self' NOT NULL,                  # _self, _blank, _top, _parent
                occurence varchar(15) DEFAULT 'all' NOT NULL,                  # first, middle, last, all occurence
                rel varchar(30) DEFAULT 'noreferrer' NOT NULL,
                download boolean DEFAULT false NOT NULL,
        		date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        		PRIMARY KEY  (id)
        	) $charset_collate;";

        	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        	dbDelta( $sql );
        	add_option( 'SEOKLDB_version', $SEOKL_db_version );
        }
        public static function erase_table(){
            /**
            * Delete Database Entries
            *
            * @since		1.0
            */
            if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();
            global $wpdb;
            global $SEOKL_table_name;
            $wpdb->query( "DROP TABLE IF EXISTS $SEOKL_table_name" );
            delete_option("SEOKLDB_version");
        }

        /** * Prepare the items for the table to process
        * * @return Void
        */
        public function prepare_items() {
            global $wpdb; //This is used only if making any database queries

            $this->_column_headers = $this->get_column_info();
            /**
             * First, lets decide how many records per page to show
             */
            $columns = $this->get_columns();
            $hidden = $this->get_hidden_columns();
            $sortable = $this->get_sortable_columns();
            $this->_column_headers = array(
                $columns,
                $hidden,
                $sortable
            );

            /** Process bulk action */
            $this->process_bulk_action();
            $per_page = $this->get_items_per_page('records_per_page', 5);
            $current_page = $this->get_pagenum();
            $data = $this->example_data;
            //$total_items = self::record_count();
            $total_items = count($data);
            function usort_reorder($a,$b){
                $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'keyword'; //If no sort, default to title
                $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
                $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
                return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
            }
            usort($data, 'usort_reorder');


            //$data = self::get_records($per_page, $current_page);

            $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
            $this->set_pagination_args( array(
               'total_items' => $total_items,                  //WE have to calculate the total number of items
               'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
               'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
           ) );
            $this->items = $data;

        }
        /**
        *Retrieve records data from the database
        *
        * @param int $per_page
        * @param int $page_number
        *
        * @return mixed
        */
        public static function get_records($per_page = 5, $page_number = 1) {
            global $wpdb;
            global $SEOKL_table_name;
            $sql = "select * from $SEOKL_table_name";
            if (isset($_REQUEST['s'])) {
                $sql.= ' where keyword LIKE "%' . $_REQUEST['s'] . '%" or target_url LIKE "%' . $_REQUEST['s'] . '%"';
            }
            if (!empty($_REQUEST['orderby'])) {
                $sql.= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
                $sql.= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
            }
            $sql.= " LIMIT $per_page";
            $sql.= ' OFFSET ' . ($page_number - 1) * $per_page;
            $result = $wpdb->get_results($sql, 'ARRAY_A');
            return $result;
        }
        /**
         * Define the columns that are going to be used in the table
         * @return array $columns, the array of columns to use with the table
         */
        public function get_columns() {
           return $columns= array(
              'cb' => '<input type="checkbox" />',
              // 'id'=>__('ID'),
              'keyword'=>__('Keyword'),
              'target_url'=>__('Target Url'),
              'time' => __('Time')
           );
        }
        public function get_hidden_columns() {
            // Setup Hidden columns and return them
             return $columns= array('id'=>__('ID'),);
        }
        /**
         * Decide which columns to activate the sorting functionality on
         * @return array $sortable, the array of columns that can be sorted by the user
         */
        public function get_sortable_columns() {
           return $sortable_columns = array(
               // 'id'=>__('ID', true), //true means it's already sorted
               'keyword'=>__('Keyword', true),
               'target_url'=>__('Target Url', true),
               'time' => array('time',false)
           );
        }
        /**
        * Render the bulk edit checkbox
        * * @param array $item
        * * @return string
        */
        public function column_cb($item) {
            return sprintf('<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['ID']);
        }
        // public function column_cb($item){
        //     return sprintf(
        //         '<input type="checkbox" name="%1$s[]" value="%2$s" />',
        //         /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
        //         /*$2%s*/ $item['ID']                //The value of the checkbox should be the record's id
        //     );
        // }

        /**
        * Render the bulk edit checkbox
        * * @param array $item
        * * @return string
        */
        public function column_first_column_name($item) {
            return sprintf('<a href="%s" class="btn btn-primary"/>'.$item['keyword'].'</a>', $item['target_url']);
        }
        /**
        * Returns an associative array containing the bulk action
        * * @return array */
        public function get_bulk_actions() {
            $actions = ['bulk-delete' => 'Delete'];
            $actions = array(
                'bulk-delete'    => 'Delete'
            );
            return $actions;
        }
        public function process_bulk_action() {
            //Detect when a bulk action is being triggered...
            if( 'bulk-delete'===$this->current_action() ) {
                wp_die('Items deleted (or they would be if we had items to delete)!');
            }

        }
        // public function process_bulk_action() {
        //     // Detect when a bulk action is being triggered...
        //     if ('delete' === $this->current_action()) {
        //         // In our file that handles the request, verify the nonce.
        //         $nonce = esc_attr($_REQUEST['_wpnonce']);
        //         if (!wp_verify_nonce($nonce, 'bx_delete_records')) {
        //             die('Go get a life script kiddies');
        //         }
        //         else {
        //             self::delete_records(absint($_GET['record']));
        //             $redirect = admin_url('admin.php?page=codingbin_records');
        //             wp_redirect($redirect);
        //             exit;
        //         }
        //     }
        //     // If the delete bulk action is triggered
        //     if ((isset($_POST['action']) && $_POST['action'] == 'bulk-delete') || (isset($_POST['action2']) && $_POST['action2'] == 'bulk-delete')) {
        //             $delete_ids = esc_sql($_POST['bulk-delete']);
        //             // loop over the array of record IDs and delete them
        //             foreach($delete_ids as $id) {
        //                 self::delete_records($id);
        //             }
        //             $redirect = admin_url('admin.php?page=codingbin_records');
        //             wp_redirect($redirect);
        //             exit;
        //         }
        // }

        /**
        *Text displayed when no record data is available
        */
        public function no_items() {
            _e('No record found in the database.', 'bx');
        }
        /**
        * Returns the count of records in the database.
        * * @return null|string
        */
        // public static function record_count() {
        //     global $wpdb;
        //     $sql = "SELECT COUNT(*) FROM wp_seokl";
        //     return $wpdb->get_var($sql);
        // }
        /**
        * Delete a record record.
        * * @param int $id customer ID
        */
        public static function delete_records($id) {
            global $wpdb;
            $wpdb->delete("wp_seokl", ['id' => $id], ['%d']);
        }
        /**
         * Display the rows of records in the table
         * @return string, echo the markup of the rows
         */
        // public function display_rows() {
        //    //Get the records registered in the prepare_items method
        //    $records = $this->items;
        //
        //    //Get the columns registered in the get_columns and get_sortable_columns methods
        //    list( $columns, $hidden ) = $this->get_column_info();
        //
        //    //Loop for each record
        //    if(!empty($records)){foreach($records as $rec){
        //
        //       //Open the line
        //         echo '< tr id="record_'.$rec->link_id.'">';
        //       foreach ( $columns as $column_name => $column_display_name ) {
        //
        //          //Style attributes for each col
        //          $class = "class='$column_name column-$column_name'";
        //          $style = "";
        //          if ( in_array( $column_name, $hidden ) ) $style = ' style="display:none;"';
        //          $attributes = $class . $style;
        //
        //          //edit link
        //          $editlink  = '/wp-admin/link.php?action=edit&link_id='.(int)$rec->link_id;
        //
        //          //Display the cell
        //          switch ( $column_name ) {
        //             case "id":  echo '< td '.$attributes.'>'.stripslashes($rec->id).'< /td>';   break;
        //             case "keyword": echo '< td '.$attributes.'>'.stripslashes($rec->keyword).'< /td>'; break;
        //             case "target_url": echo '< td '.$attributes.'>'.stripslashes($rec->target_url).'< /td>'; break;
        //          }
        //       }
        //       //Close the line
        //       echo'< /tr>';
        //    }}
        // }
        public function column_default($item, $column_name){
            switch($column_name){
                case 'keyword':
                case 'target_url':
                case 'time':
                    return $item[$column_name];
                default:
                    return print_r($item,true); //Show the whole array for troubleshooting purposes
            }
        }
        public function column_keyword($item){
            //Build row actions
            $actions = array(
                'edit'      => sprintf('<a href="?page=%s&action=%s&id=%s">Edit</a>',$_REQUEST['page'],'edit',$item['ID']),
                'delete'    => sprintf('<a href="?page=%s&action=%s&id=%s">Delete</a>',$_REQUEST['page'],'delete',$item['ID']),
            );
            //Return the title contents
            return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
                /*$1%s*/ $item['keyword'],
                /*$2%s*/ $item['ID'],
                /*$3%s*/ $this->row_actions($actions)
            );
        }
        public function display_table(){
            //Create an instance of our package class...
            $SEOKLTable = new SEOKLTable();
            //Fetch, prepare, sort, and filter our data...
            $SEOKLTable->prepare_items();
            ?>
            <div class="wrap">

                <div id="icon-users" class="icon32"><br/></div>
                <h2><a rel="noreferrer" target="_blank" href="<?php echo SEOKL_URI;?>"><span class="red">SEO</span>  Keyword Linker</a> <small>Version ( <?php print_r(SEOKL_VERSION);?> ) </small></h2>
                <p><?php print_r(SEOKL_DESCRIPTION);?></p>
                <hr />
                <?php
                    $_REQUEST['action'] = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : 'list';
                    switch($_REQUEST['action']){
                        case "add":
                            require_once(SEOKL_RELPATH."admin/inc/add.php");
                        break;
                        case "edit":
                            require_once(SEOKL_RELPATH."admin/inc/edit.php");
                        break;
                        case "delete":
                            require_once(SEOKL_RELPATH."admin/inc/delete.php");
                        break;
                        default:
                            require_once(SEOKL_RELPATH."admin/inc/list.php");
                        break;
                    }

                ?>
            </div>
            <?php
        }
    }
}
