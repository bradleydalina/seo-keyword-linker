<?php
/**
 * Restrict Direct Access
 */
defined( 'ABSPATH' ) or die( 'The wrong way access...' );
?>
<!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
<form id="keyword-filter" method="get">
    <!-- For plugins, we also need to ensure that the form posts back to our current page -->
    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
    <!-- Now we can render the completed list table -->
    <?php $SEOKLTable->display() ?>
</form>
