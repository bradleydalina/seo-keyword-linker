<?php
/**
 * Restrict Direct Access
 */
defined( 'ABSPATH' ) or die( 'The wrong way access...' );
?>
<h3>Delete Keyword Link Data</h3>
<div class="seokl-form">
    There a x linked with this keyword with x affected pages. What necessary actions do you want?<br/><br/>
    <div class="seokl-row">
        <span class="seokl-formgroup seokl-column">
            <label for="deletion-unlinked"><input type="radio" name="deletion-type" id="deletion-unlinked"> Unlinked all the affected keywords before deleting.</label>
            <label for="deletion-linked"><input checked type="radio" name="deletion-type" id="deletion-linked"> Do nothing with the linked keywords and continue to delete this.</label><br/>
            <input type="submit" name="delete" id="delete" class="button button-primary" value="Delete">
            <a class="button" href="?page=<?php echo SEOKL; ?>&action=list">Back</a>
        </span>
    </div>
</div>
