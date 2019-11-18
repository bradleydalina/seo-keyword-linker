<?php
/**
 * Restrict Direct Access
 */
defined( 'ABSPATH' ) or die( 'The wrong way access...' );
?>
<h3>Add New Keyword Link Data</h3>
<?php
function saveForm() {
    if(! isset( $_POST['seokl-addform-action'] ) || ! wp_verify_nonce( $_POST['seokl-addform-action'], 'seokl-addform-nonce' )){
        ?>
        <div class="t-message-box settings_tab">
            <div class="error is-dismissible">
               <p>Sorry, your nonce was incorrect. Please try again.</p>
            </div>
        </div>
        <?php
    }
    else
    {
        // if(class_exists("SEOKLPlugin")){
        //     print_r("SEOKLPlugin");
        //     //SEOKLPlugin::Authorize();
        // }
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
        //print_r($data);
        // global $wpdb;
        // global $table_name;
        // $data["date"] = current_time( 'mysql' );
        // $wpdb->insert($table_name, $data );
        ?>
        <span class="success notice is-dismissible">
            <p>New keyword was saved in the database!</p>
        </span>
        <?php
    }
}
function renderForm(){
?>
<form method="post" class="seokl-form">
<?php wp_nonce_field( 'seokl-addform-nonce', 'seokl-addform-action' ); ?>
<input type="hidden" name="seokl-addform-nonce" value=1 />
<div class="seokl-row">
    <span class="seokl-formgroup seokl-column seokl-columns-2">
        <label for="keyword">Keyword(s) <small> ( Separated by comma )</small></label>
        <input required placeholder="keyword" size="50" name="keyword" id="keyword" type="text" value="" class="seokl-input"/>
    </span>
    <span class="seokl-formgroup seokl-column seokl-columns-2">
        <label for="target_url">Target URL </label>
        <input required placeholder="http://" size="50" name="target_url" id="target_url" type="text" value="" class="seokl-input"/>
    </span>
</div>
<div class="seokl-row">
    <span class="seokl-formgroup seokl-column seokl-columns-2">
        <label for="post_type">Post Type</label>
        <select name="post_type" id="post_type" class="seokl-input">
            <option value="all">All</option>
            <option value="page">Page</option>
            <option value="post">Post</option>
        </select>
    </span>
    <span class="seokl-formgroup seokl-column seokl-columns-2">
        <label for="specific_pages">Select Pages</label>
        <select name="specific_pages" id="specific_pages" class="seokl-input">
            <option value="all">All</option>
            <option value="sample-page">Sample Page</option>
        </select>
    </span>
</div>
<div class="seokl-row">
    <span class="seokl-formgroup seokl-column seokl-columns-2">
        <label for="window_tab">Window Tab</label>
        <select name="window_tab" id="window_tab" class="seokl-input">
            <option value="_self">Same Tab</option>
            <option value="_blank">New Tab</option>
            <option value="_parent">Parent Window Tab</option>
            <option value="_top">First Tab</option>
        </select>
    </span>
    <span class="seokl-formgroup seokl-column seokl-columns-2">
        <label for="rel">Rel</label>
        <select name="rel" id="rel" class="seokl-input">
            <option value="noreferrer">No Referrer</option>
            <option value="nofollow">No Follow</option>
        </select>
    </span>
</div>
<div class="seokl-row">
    <span class="seokl-formgroup seokl-column seokl-columns-2">
        <input type="submit" name="add-keyword" id="add-keyword" class="button button-primary" value="Save">&nbsp;
        <input type="button" name="reset" id="reset" class="button button-default" value="Reset">&nbsp;
        <a class="button" href="?page=<?php echo SEOKL; ?>&action=list">Back</a>
    </span>
    <span class="seokl-formgroup seokl-column seokl-columns-2">
        <label for="regex" class="inline"><input type="checkbox" name="regex" id="regex"> Use Regex</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <label for="download" class="inline"><input type="checkbox" name="download" id="download"> Download Link</label>
    </span>
</div>
</form>
<?php }

    if ( ! empty( $_POST ) && isset( $_POST['seokl-addform-action'] ) ) {
        saveForm();
    }
    renderForm();
