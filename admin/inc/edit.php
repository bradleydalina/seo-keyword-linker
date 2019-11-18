<?php
/**
 * Restrict Direct Access
 */
defined( 'ABSPATH' ) or die( 'The wrong way access...' );
?>
<h3>Update Keyword Link Data</h3>
<div class="seokl-form">
    <div class="seokl-row">
        <span class="seokl-formgroup seokl-column seokl-columns-2">
            <label for="keyword">Keyword(s) <small> ( Separated by comma )</small></label>
            <input placeholder="keyword" size="50" name="keyword" id="keyword" type="text" value="" class="seokl-input"/>
        </span>
        <span class="seokl-formgroup seokl-column seokl-columns-2">
            <label for="target_url">Target URL </label>
            <input placeholder="http://" size="50" name="target_url" id="target_url" type="text" value="" class="seokl-input"/>
        </span>
    </div>
    <div class="seokl-row">
        <span class="seokl-formgroup seokl-column seokl-columns-2">
            <label for="post-type">Post Type</label>
            <select name="post-type" id="post-type" class="seokl-input">
            </select>
        </span>
        <span class="seokl-formgroup seokl-column seokl-columns-2">
            <label for="specific-pages">Select Pages</label>
            <select name="specific-pages" id="specific-pages" class="seokl-input">
            </select>
        </span>
    </div>
    <div class="seokl-row">
        <span class="seokl-formgroup seokl-column seokl-columns-2">
            <label for="window-tab">Window Tab</label>
            <select name="window-tab" id="window-tab" class="seokl-input">
            </select>
        </span>
        <span class="seokl-formgroup seokl-column seokl-columns-2">
            <label for="rel">Rel</label>
            <select name="rel" id="rel" class="seokl-input">
            </select>
        </span>
    </div>
    <div class="seokl-row">
        <span class="seokl-formgroup seokl-column seokl-columns-2">
            <input type="submit" name="add" id="add" class="button button-primary" value="Save">
            <input type="button" name="reset" id="reset" class="button button-default" value="Reset">
            <a class="button" href="?page=<?php echo SEOKL; ?>&action=list">Back</a>
        </span>
        <span class="seokl-formgroup seokl-column seokl-columns-2">
            <label for="regex" class="inline"><input type="checkbox" name="regex" id="regex"> Use Regex</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label for="download" class="inline"><input type="checkbox" name="download" id="download"> Download Link</label>
        </span>
    </div>
</div>
