<?php

$settings_code = 'S_GENERAL';
    $results = get_settings_data($settings_code);

    if(isset($results)){
	    $data = json_decode($results->settings_data, true);
	} else {
		$data = array('enable_LSP' => '', 'LSP_position' => 'bottom');
	}
	    
    ?>
<form id="global-settings-form">
	<table>
		<tbody>
			<tr>
				<th>Eable / Disable Functionality:</th>
				<td>
					<input type="text" name="setting_type" value="S_GENERAL" hidden>
					<input type="checkbox" name="enable_LSP" <?php echo $data['enable_LSP'] == 1 ? 'checked' : ''; ?> value="1">
				</td>
			</tr>
			<tr>
				<th>Show on:</th>
				<td>
					<div>
						<label>Page Top</label>
						<input type="radio" name="LSP_position" <?php echo $data['LSP_position'] == 'top' ? 'checked' : ''; ?> value="top">
					</div>
					<div>
						<label>Page Bottom</label>
						<input type="radio" name="LSP_position" <?php echo $data['LSP_position'] == 'bottom' ? 'checked' : ''; ?> value="bottom">
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<br>
	<input class="button button-primary" type="submit" value="Submit" />
</form>