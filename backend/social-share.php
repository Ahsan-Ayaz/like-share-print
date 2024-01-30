<?php

$post_types = get_post_types(array('exclude_from_search' => false));

$social_types = array("Facebook", "Instagram", "Youtube", "Linkedin", "Twitter", "Pinterest", "Threads", "Whatsapp", "TikTok");

$settings_code = 'S_SHARE';
    $results = get_settings_data($settings_code);
    if(isset($results)){
    	$data = json_decode($results->settings_data, true);
    	} else {
		$data = array('enable_share' => 0, 'share_list' => array(), 'social_media' => array());
	}
	?>

<form id="share-settins-form">
	<h4>Enable / Disable Social Share</h4>
	<input type="text" name="setting_type" value="S_SHARE" hidden>
	<div>
	<?php  $checkedAttribute = $data['enable_share'] == 1 ? 'checked' : ''; ?>
	<input type="checkbox" name="enable_share" <?php echo $checkedAttribute; ?> value="1">
	<label>Check this to Enable Social Share</label>
	</div>
	<h4>Show Like on</h4>
	<div class="lsp-con lsp-grid">
	<?php

	foreach ($post_types as $post_type) {
		$isChecked = in_array($post_type, $data['share_list']);
	?>
	    <div>
	        <input type="checkbox" name="share_post[]" value="<?php echo esc_attr($post_type); ?>" <?php echo $isChecked ? 'checked' : ''; ?> value="1">
	        <label><?php echo esc_html($post_type); ?></label>
	    </div>
	<?php
	}
	?>
	</div>
	<h4>Select social media on which you want to share</h4>
	<div class="lsp-con lsp-grid">
	<?php foreach($social_types as $social){ 
		$isChecked_social = in_array($social, $data['social_media']);
		?>
		<div>
	        <input type="checkbox" name="social_media[]" value="<?php echo esc_attr($social); ?>" <?php echo $isChecked_social ? 'checked' : ''; ?> value="1">
	        <label><?php echo esc_html($social); ?></label>
	    </div>
	<?php } ?>
	</div>
	<br>
	<input class="button button-primary" type="submit" value="Submit" />
</form>

