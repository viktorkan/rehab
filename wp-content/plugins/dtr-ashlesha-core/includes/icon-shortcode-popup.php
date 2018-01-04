<?php
// look up for the path
require_once('dtr_config.php');
// check for rights
if ( !is_user_logged_in() || !current_user_can('edit_posts') ) 
	wp_die(__( 'You are not allowed to be here', 'ashlesha_core' ));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Icons</title>
<script type="text/javascript" src="<?php echo get_option( 'siteurl' ) ?>/wp-content/plugins/dtr-ashlesha-core/assets/js/jquery-1.12.4.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo get_option( 'siteurl' ) ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<link rel="stylesheet" href="<?php echo get_option( 'siteurl' ) ?>/wp-content/plugins/dtr-ashlesha-core/assets/css/tinymce.css" />
<link rel="stylesheet" href="<?php echo get_option( 'siteurl' ) ?>/wp-content/plugins/dtr-ashlesha-core/assets/css/iconfont.css" />
<script type="text/javascript">
var DTRDialog = {
    local_ed: 'ed',
    init: function (ed, url) {
        DTRDialog.local_ed = ed;
        tinyMCEPopup.resizeToInnerSize();
    },
    insert: function insertIcon(ed) {
		
        // set up variables to contain input values
		var icon_name	= jQuery('#dialogwindow input#field-icon_name').val();
		var color 		= jQuery('#dialogwindow input#field-color').val();
        var size 		= jQuery('#dialogwindow input#field-size').val();

        var output = '';

        // setup the output of shortcode
        output = ' [dtr_icon ';
        output += 'icon_name="' + icon_name + '" ';
		output += 'color="' + color + '" ';
        output += 'size="' + size + '" ';
		output += ']';

        tinyMCEPopup.execCommand('mceReplaceContent', false, output);

        // Return
        tinyMCEPopup.close();
    }
};
tinyMCEPopup.onInit.add(DTRDialog.init, DTRDialog);
</script>
</head>
<body>
<div id="dialogwindow">
    <form action="/" method="get" accept-charset="utf-8">
        <p class="clearfix">
            <label for="field-icon_name">Icon Name</label>
            <input type="text" name="field-icon_name" value="" id="field-icon_name" />

        </p>
		<span class="clearfix"></span>
        <p class="clearfix">
            <label for="field-color">Icon color</label>
            <input type="text" name="field-color" value="black" id="field-color" />
        </p>
        <div class="sc-note clearfix">* Can be given as black, yellow or #d9b444</div>
        <p class="clearfix">
            <label for="field-size">Icon size</label>
            <input type="text" name="field-size" value="" id="field-size" />
        </p>
        <div class="sc-note clearfix">* Can be in 'px' or 'em'</div>
		
    </form>
    <div class="clearfix"></div>
    <a class="mybtn" href="javascript:DTRDialog.insert(DTRDialog.local_ed)">Insert Icon</a> </div>
	<div class="clearfix"></div>
	 <div class="bold-note clearfix" style="margin-left: 10px;">Icon List For Reference</div>
	<ul class="dtr-icon-list">
			<?php
				require_once ( ASHLESHA_DIR . '/includes/icon-font-array.php');
				 foreach( $custom_icons as $key => $value) 
					echo "<li><code><i class='$value'></i><span class='get-icon-name'>$value</span></code></li>";
			?> <span class="clearfix"></span>
</ul>

</body>
</html>