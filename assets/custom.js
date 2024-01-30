jQuery(document).ready(function() {

  jQuery('.print_con a').click(function(e){
    e.preventDefault();
    window.print();
  });
  
});

  jQuery(document).ready(function($) {
    $('.like-button').on('click', function(e) {
        e.preventDefault();
        var postID = $(this).data('post-id');

        $.ajax({
            type: 'post',
            url: ajaxurl, 
            data: {
                action: 'update_like_count',
                post_id: postID,
            },
            success: function(response) {
                var data = $.parseJSON(response);
                if(data.count){
                  $('.like-count-con .count').text(data.count);
                  $('.like_con .like-button').addClass('like_active');
                }
                console.log(data.message);
            }
        });
    });
});