<?php
    /**
     * Plugin Name:       Like Share Print
     * Plugin URI:        https://google.com/
     * Description:       Add Like Share and Print button on posts and pages.
     * Version:           1.0
     * Requires at least: 5.2
     * Requires PHP:      7.2
     * Author:            Ahsan Ayaz
     * License:           GPL v2 or later
    */

function LSP_uninstalled() {
    drop_LSP_db_table("lsp_settings");
    $deleted = delete_plugins(array($plugin_folder . '/' . $plugin_file));
            
            if ($deleted) {
                echo 'The plugin has been deleted successfully.';
            } 
            else {
                echo 'Failed to delete the plugin.';
            }
}

register_uninstall_hook(__FILE__, 'LSP_uninstalled');

    function LSP_activate() {  
        initialize_tags_table("lsp_settings");
    }
    register_activation_hook(__FILE__,'LSP_activate');

    include( plugin_dir_path( __FILE__ ) . '/functions.php');

function initialize_tags_table ($table) {
        
        global $wpdb;
        $table_name = $wpdb->prefix . $table; 
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            setting_code varchar(255) NOT NULL,
            settings_data varchar(255),
            PRIMARY KEY  (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    function drop_LSP_db_table($table){
        
        global $wpdb;
        $table_name = $wpdb->prefix . $table; 
        $sql = "DROP TABLE IF EXISTS $table_name;";
        $wpdb->query($sql);
    }

?>