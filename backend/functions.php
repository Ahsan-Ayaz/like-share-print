<?php
function data_formate($data){

	if($data['setting_type'] == 'S_LIKE'){
		$settings_code = $data['setting_type'];
		$settings = array(
	        'enable_like' => $data['enable_like'],
	        'likes_list' => $data['like_post'],
	    );
	} elseif($data['setting_type'] == 'S_SHARE') {
		$settings_code = $data['setting_type'];
		$settings = array(
	        'enable_share' => $data['enable_share'],
	        'share_list' => $data['share_post'],
	        'social_media' => $data['social_media'],
	    );
	} elseif($data['setting_type'] == 'S_PRINT') {
		$settings_code = $data['setting_type'];
		$settings = array(
	        'enable_print' => $data['enable_print'],
	        'print_list' => $data['print_post'],
	    );
	} else {
		$settings_code = $data['setting_type'];
		$settings = array(
				'enable_LSP' => $data['enable_LSP'],
				'LSP_position' => $data['LSP_position'],
		);
	}

	$settings = json_encode($settings, JSON_PRETTY_PRINT);

    $data_to_insert = array(
    	'setting_code' => $settings_code,
    	'settings_data' => $settings,
    );
    return $data_to_insert;
}

function save_data() {
    if (isset($_POST)) {
        
        $data = $_POST;
        
        $data_to_insert = data_formate($data);

        global $wpdb; 
        $table_name = $wpdb->prefix . 'lsp_settings';

		$setting_code = $data_to_insert['setting_code'];

		if(isset($setting_code)){
			$query_check = $wpdb->prepare("SELECT * FROM $table_name WHERE setting_code = %s", $setting_code);

			$results = $wpdb->get_results($query_check);

			if ($wpdb->num_rows > 0) {

			    $where = array(
		            'setting_code' => $setting_code,
		        );
		        $data_format = array(
		            '%s', 
		        );

		        $result = $wpdb->update($table_name, $data_to_insert, $where, $data_format);

		        if ($result === false) {
		            error_log('Database error: ' . $wpdb->last_error);
		            echo $wpdb->last_error;
		        } else {
		            echo 'Settings Updated successfully';
		        }

			} else {

			    $insert = $wpdb->insert($table_name, $data_to_insert);

		        if ($insert === false) {
		            error_log('Database error: ' . $wpdb->last_error);
		            echo $wpdb->last_error;
		        } else {
		            echo 'Settings saved successfully';
		        }

			}
		}
        
    }

    wp_die();
}

add_action('wp_ajax_save_data', 'save_data');
add_action('wp_ajax_nopriv_save_data', 'save_data');

?>