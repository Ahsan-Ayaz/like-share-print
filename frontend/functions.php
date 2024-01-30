<?php 

function add_custom_user_meta($user_id, $meta_key, $meta_value) {
    return update_user_meta($user_id, $meta_key, $meta_value);
}

function get_custom_user_meta($user_id, $meta_key, $single = false) {
    return get_user_meta($user_id, $meta_key, $single);
}

function add_likes($postID){
    $like_count = get_post_meta($postID, 'like_number_field', true);

    if($like_count == ''){
        $new_like_count = 1;
    } else {
        $new_like_count = $like_count + 1;
    }

    update_post_meta($postID, 'like_number_field', sanitize_text_field($new_like_count));

    return $new_like_count;
}

function check_login_user(){
    $user_id = wp_get_current_user()->id;
    if($user_id > 0){
        $the_posts = get_user_meta($user_id, 'like_number_field', false) != '' ? get_user_meta($user_id, 'like_number_field', false) : array();
        $liked_posts = is_array($the_posts) && !empty($the_posts) ?  $the_posts[0] : $the_posts;
        $type = 'login_user';
    } else {
        $liked_posts = isset($_COOKIE['liked_posts']) ? json_decode(stripslashes($_COOKIE['liked_posts']), true) : array();
        $type = 'logout_user';
    }
    $liked_posts = array('liked' => $liked_posts, 'type' => $type );
    return $liked_posts;
}

function check_single_page_type($pType) {
    if ($pType == 'post') {
            $check = is_single() && get_post_type() && !is_product();
    }

    elseif ($pType == 'page') {
        $check = is_page();
    }

    elseif ($pType == 'product') {
        $check = class_exists('WooCommerce') && is_product();
    }

    elseif($pType == 'attachment'){
        $check = is_attachment();
    }
    return $check;
}

function check_social_share_enable($social){
    $post_url = get_permalink();
    $post_title = get_the_title();
    $post_content = wp_trim_words(get_the_content(), 30);
    $featured_image_url = get_the_post_thumbnail_url();
    if($social == 'Facebook'){
        $social_media ='<a href="https://www.facebook.com/sharer/sharer.php?u='.$post_url.'" target="_blank"><img src="'.plugin_dir_url( __FILE__ ).'/images/facebook.png" /></a>';
    } elseif($social == 'Instagram'){
        $social_media ='<a href="instagram://share?url='.$post_url.'" target="_blank"><img src="'.plugin_dir_url( __FILE__ ).'/images/instagram.png" /></a>';
    } elseif($social == 'Youtube'){
        $social_media ='<a href="#" target="_blank"><img src="'.plugin_dir_url( __FILE__ ).'/images/youtube.png" /></a>';
    } elseif($social == 'Linkedin'){
        $social_media ='<a href="https://www.linkedin.com/shareArticle?url='.$post_url.'&title='.$post_title.'&summary='.$post_content.'" target="_blank"><img src="'.plugin_dir_url( __FILE__ ).'/images/linkedin.png" /></a>';
    } elseif($social == 'Twitter'){
        $social_media ='<a href="https://twitter.com/intent/tweet?url='.$post_url.'&text='.$post_title.'" target="_blank"><img src="'.plugin_dir_url( __FILE__ ).'/images/twitter.png" /></a>';
    } elseif($social == 'Pinterest'){
        $social_media ='<a href="https://www.pinterest.com/pin/create/bookmarklet/?url='.$post_url.'&description='.$post_title.'&media='.$featured_image_url.'" target="_blank"><img src="'.plugin_dir_url( __FILE__ ).'/images/pinterest.png" /></a>';
    } elseif($social == 'Threads'){
        $social_media ='<a href="#" target="_blank"><img src="'.plugin_dir_url( __FILE__ ).'/images/threads.png" /></a>';
    } elseif($social == 'Whatsapp'){
        $social_media ='<a href="#" target="_blank"><img src="'.plugin_dir_url( __FILE__ ).'/images/social.png" /></a>';
    } elseif($social == 'TikTok'){
        $social_media ='<a href="#" target="_blank"><img src="'.plugin_dir_url( __FILE__ ).'/images/tik-tok.png" /></a>';
    }
    return $social_media;
}

$settings = get_settings_data('S_GENERAL');

if($settings != null){

$data = json_decode($settings->settings_data, true);

if($data['enable_LSP'] == 1){

function add_like_share_content( $content ) {  

    $post_types = get_post_types(array('exclude_from_search' => false));
    
    $s_like = get_settings_data('S_LIKE');
    $like_data = isset($s_like) ? json_decode($s_like->settings_data, true) : array('enable_like' => '', 'likes_list' => array());

    $s_share = get_settings_data('S_SHARE');
    $share_data = isset($s_share) ? json_decode($s_share->settings_data, true) : array('enable_share' => '', 'share_list' => array(), 'social_media' => array());

    $s_print = get_settings_data('S_PRINT');
    $print_data = isset($s_print) ? json_decode($s_print->settings_data, true) : array('enable_print' => '', 'print_list' => array());

        $post_id = get_the_ID();
       
        $liked_posts = check_login_user();

        if (!in_array($post_id, $liked_posts['liked'])) {
            $class_like = '';
        } else {
            $class_like = 'like_active';
        }
        
        $content .='<div class="like-share-con">';

        if($like_data['enable_like'] == 1){
            foreach($post_types as $post){
                if(in_array($post, $like_data['likes_list'])){
                    if(check_single_page_type($post) == 1){
                        $like_count = get_post_meta($post_id, 'like_number_field', true);
                        $content .= '<div class="like_con lsp-con-f"><a href="#" class="like-button '. $class_like.'" data-tooltip="Like / Unlike" data-post-id="' . esc_attr($post_id) . '">';
                        $content .='<img class="un_img" src="'.plugin_dir_url( __FILE__ ).'/images/like-icon-unfill.png" />';
                        $content .='<img class="li_img" src="'.plugin_dir_url( __FILE__ ).'/images/like_icon-fill.png" />';
                        $content .='</a></div>';
                        $content .='<div class="like-count-con"><span class="count">'.$like_count.'</span></div>';
                    }
                }
            }
        }

        if($share_data['enable_share'] == 1){
            foreach($post_types as $post){
                if(in_array($post, $share_data['share_list'])){
                    if(check_single_page_type($post) == 1){
                        $content .='<div class="share_con lsp-con-f">';
                        $content .='<a href="#" data-tooltip="Share"><img class="share_icon" src="'.plugin_dir_url( __FILE__ ).'/images/share-icon.png" /></a>';
                        $content .='<div class="icons_con">';

                        foreach($share_data['social_media'] as $share){
                            $content .= check_social_share_enable($share);
                        }
                        
                        $content .='</div>';
                        $content .='</div>';
                    }
                }
            }
        }

        if($print_data['enable_print'] == 1){
            foreach($post_types as $post){
                if(in_array($post, $print_data['print_list'])){
                    if(check_single_page_type($post) == 1){
                        $content .='<div class="print_con lsp-con-f"><a href="#" data-tooltip="Print">';
                        $content .='<img class="un_img" src="'.plugin_dir_url( __FILE__ ).'/images/printer.png" />';
                        $content .='</a></div>';
                    }
                }
            }
        }

        $content .='</div>';

    return $content;
    wp_die();
}
add_filter( 'the_content', 'add_like_share_content' );

}
}

function custom_add_custom_fields() {

    $settings_code = 'S_LIKE';
    $results = get_settings_data($settings_code);
    if(isset($results)){
        $data = json_decode($results->settings_data, true);
    }

    if($data['enable_like'] == 1){

        foreach($data['likes_list'] as $list){
            add_meta_box(
                'like_number_field',
                'Like Number Field',
                $list,
                'normal',
                'high'
            );

        }

    }
}
add_action('add_meta_boxes', 'custom_add_custom_fields');
   
function update_like_count() {
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

    if ($post_id > 0) {

        $liked_posts = check_login_user();

        if (!in_array($post_id, $liked_posts['liked']) && $liked_posts['type'] == 'logout_user') {

            $new_like_count = add_likes($post_id);

            $liked_posts['liked'][] = $post_id;

            setcookie('liked_posts', json_encode($liked_posts['liked']), time() + 3600 * 24 * 30, '/');

            echo json_encode(array('status' => 'success', 'message' => 'Post Liked Successfully','count' => $new_like_count));

        } elseif(!in_array($post_id, $liked_posts['liked']) && $liked_posts['type'] == 'login_user'){

            $new_like_count = add_likes($post_id);
            
            $user_id = wp_get_current_user()->id;
            
            $liked_posts['liked'][] = $post_id;

            add_custom_user_meta($user_id, 'like_number_field', $liked_posts['liked']);

            echo json_encode(array('status' => 'success', 'message' => 'Post liked successfully','count' => $new_like_count));
        }else {
            echo json_encode(array('status' => 'error', 'message' => 'Post already liked'));
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Invalid post ID'));
    }

    wp_die();
}
add_action('wp_ajax_update_like_count', 'update_like_count');
add_action('wp_ajax_nopriv_update_like_count', 'update_like_count');

?>