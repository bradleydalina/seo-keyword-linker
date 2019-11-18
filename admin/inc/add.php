<?php
/**
 * Restrict Direct Access
 */
defined( 'ABSPATH' ) or die( 'The wrong way access...' );
?>
<h3>Add New Keyword Link Data</h3>
<div id="seokl-notice">
    <span></span>
</div>
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
        <?php
        // Get post types
        $args       = array(
            'public' => true,
        );
        $post_types = get_post_types( $args, 'objects' );
        ?>
        <select multiple="multiple" name="post_type[]" id="post_type" class="seokl-input">
            <option value="all">All</option>
            <?php foreach ( $post_types as $post_type_obj ):
                $labels = get_post_type_labels( $post_type_obj );
                ?>
                <option value="<?php echo esc_attr( $post_type_obj->name ); ?>"><?php echo esc_html( $labels->name ); ?></option>
            <?php endforeach; ?>
        </select>
    </span>
    <span class="seokl-formgroup seokl-column seokl-columns-2">
        <label for="specific_pages">Select Pages</label>
        <select name="specific_pages" id="specific_pages" class="seokl-input">
            <option value="all">All</option>
            <?php
                $args = array(
                        'post_type' => 'page',
                        'posts_per_page' => -1,
                        'post_status' => 'publish'
                    );
                $query = new WP_Query($args);
                if ($query->have_posts() ) :
                    while ( $query->have_posts() ) : $query->the_post();
                            echo '<option value="' . get_the_ID() . '">' . get_the_title() . '</option>';
                    endwhile;
                    wp_reset_postdata();
                endif;
            ?>
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
