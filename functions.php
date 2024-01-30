<?php 
function enqueue_custom_admin_css() {
    wp_enqueue_style('LSP-admin-css', plugins_url('assets/admin/custom-admin.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'enqueue_custom_admin_css');

function enqueue_custom_admin_js() {
    wp_enqueue_script('LSP-admin-js', plugins_url('assets/admin/custom-admin.js', __FILE__), array('jquery'), null, true);
    wp_localize_script('custom-script', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('admin_enqueue_scripts', 'enqueue_custom_admin_js');

function LSP_enqueue_script() {   
    wp_enqueue_script('jquery');

    wp_enqueue_script('LSP_script', plugin_dir_url(__FILE__) . 'assets/custom.js', array('jquery'), null, true);
    wp_localize_script('LSP_script', 'ajaxurl', admin_url('admin-ajax.php'));

    wp_enqueue_style('LSP_style', plugin_dir_url(__FILE__) . 'assets/custom.css');
}
add_action('wp_enqueue_scripts', 'LSP_enqueue_script');

function LSP_menu_page() {
    add_menu_page(
        __( 'Custom Menu Title', 'textdomain' ),
        'Like Share Print',
        'manage_options',
        'like-share-print/like-share-print.php',
        '',
        'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><path style="color:rgba(240,246,252,.6)" d="M0 80V229.5c0 17 6.7 33.3 18.7 45.3l176 176c25 25 65.5 25 90.5 0L418.7 317.3c25-25 25-65.5 0-90.5l-176-176c-12-12-28.3-18.7-45.3-18.7H48C21.5 32 0 53.5 0 80zm112 32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>'),
        90
    );
}
add_action( 'admin_menu', 'LSP_menu_page' );

function get_settings_data($setting_code = '') {
    global $wpdb;
    $table_name = $wpdb->prefix . 'lsp_settings';

    if($setting_code == ''){
        $query = "SELECT * FROM ".$table_name;
    } else {
        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE setting_code = %s", $setting_code);
    }

    $results = $wpdb->get_results($query);

    if ($results) {
        return $results[0];
    } else {
        return null;
    }
}

include __DIR__ . '\backend\functions.php';
include __DIR__ . '\frontend\functions.php';
?>