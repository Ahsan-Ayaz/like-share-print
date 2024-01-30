// Like Share Print JS start

jQuery('.lsp-nav-tab-wrapper a.nav-tab').click(function(e){
    e.preventDefault();
    var nav = '#'+jQuery(this).attr('nav-data');
    // console.log(nav);
    jQuery('.lsp-nav-tab-wrapper a.nav-tab').removeClass('nav-tab-active');
    jQuery(this).addClass('nav-tab-active');
    jQuery('.LSP_tab_content').removeClass('active');
    jQuery(nav).addClass('active');
});

function save_settings(formData){
    var jsonData = {};
    jQuery.each(formData, function () {
        if (jsonData[this.name]) {
            if (!jsonData[this.name].push) {
                jsonData[this.name] = [jsonData[this.name]];
            }
            jsonData[this.name].push(this.value || '');
        } 
        else {
            jsonData[this.name] = this.value || '';
        }
    });
    jsonData.action = 'save_data';
    // var ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: jsonData,
        success: function (response) {
            var success_notice = '<div class="notice notice-success is-dismissible"><p>'+response+'</p></div>';
            
            // jQuery('#slider-add-modal').removeClass('show');
            jQuery('.lsp-message-con').append(success_notice);
            // jQuery('#loader-container').hide();
            // location.reload();
            setTimeout(function() {
                jQuery('.lsp-message-con .notice.is-dismissible').fadeOut('slow'); // or .hide() for instant hiding
            }, 2000);
        }
    });
}

jQuery(document).on("submit","#like-settins-form",function(e) {
    e.preventDefault();
    // console.log('Form Submit');
    var formData = jQuery('#like-settins-form').serializeArray();
    save_settings(formData);
});

jQuery(document).on("submit","#share-settins-form",function(e) {
    e.preventDefault();
    // console.log('Form Submit');
    var formData = jQuery('#share-settins-form').serializeArray();
    save_settings(formData);
});

jQuery(document).on("submit","#print-settins-form",function(e) {
    e.preventDefault();
    // console.log('Form Submit');
    var formData = jQuery('#print-settins-form').serializeArray();
    save_settings(formData);
});

jQuery(document).on("submit","#global-settings-form",function(e) {
    e.preventDefault();
    // console.log('Form Submit');
    var formData = jQuery('#global-settings-form').serializeArray();
    save_settings(formData);
});

jQuery(document).ready(function() {
    
});



// Like Share Print JS end