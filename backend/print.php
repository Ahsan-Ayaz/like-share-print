<?php

$post_types = get_post_types(array('exclude_from_search' => false));

$settings_code = 'S_PRINT';
    $results = get_settings_data($settings_code);
    if(isset($results)){
    	$data = json_decode($results->settings_data, true);
    } else  {
		$data = array('enable_print' => '', 'print_list' => array());
	}
    ?>

<form id="print-settins-form">
	<h4>Enable / Disable Print</h4>
	<input type="text" name="setting_type" value="S_PRINT" hidden>
	<div>
		<?php  $checkedAttribute = $data['enable_print'] == 1 ? 'checked' : ''; ?>
	<input type="checkbox" name="enable_print" <?php echo $checkedAttribute; ?> value="1">
	<label>Check this to Enable Print</label>
	</div>
	<h4>Show Like on</h4>
	<div class="lsp-con lsp-grid">
	<?php

	foreach ($post_types as $post_type) {
		$isChecked = in_array($post_type, $data['print_list']);
	?>
	    <div>
	        <input type="checkbox" name="print_post[]" value="<?php echo esc_attr($post_type); ?>" <?php echo $isChecked ? 'checked' : ''; ?> value="1">
	        <label><?php echo esc_html($post_type); ?></label>
	    </div>
	<?php
	}
	?>
	</div>
	<br>
	<input class="button button-primary" type="submit" value="Submit" />
</form>
