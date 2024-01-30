<?php

$post_types = get_post_types(array('exclude_from_search' => false));
    $settings_code = 'S_LIKE';
    $results = get_settings_data($settings_code);
    if(isset($results)){
    	$data = json_decode($results->settings_data, true);
    	}  else {
    	$data = array('enable_like' => 0, 'likes_list' => array());
	}

?>

<form id="like-settins-form">
	<h4>Enable / Disable Like</h4>
	<input type="text" name="setting_type" value="S_LIKE" hidden>
	<div>
	<?php  $checkedAttribute = $data['enable_like'] == 1 ? 'checked' : ''; ?>
	<input type="checkbox" name="enable_like" <?php echo $checkedAttribute; ?> value="1">
	<label>Check this to Enable Like</label>
	</div>
	<h4>Show Like on</h4>
	<div class="lsp-con lsp-grid">
	<?php

	foreach ($post_types as $post_type) {
		$isChecked = in_array($post_type, $data['likes_list']);
	?>
	    <div>
	        <input type="checkbox" name="like_post[]" value="<?php echo esc_attr($post_type); ?>" <?php echo $isChecked ? 'checked' : ''; ?> value="1">
	        <label><?php echo esc_html($post_type); ?></label>
	    </div>
	<?php
	}
	?>
	</div>
	<br>
	<input class="button button-primary" type="submit" value="Submit" />
</form>