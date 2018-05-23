function repost(post, user)
{
    var comm = $('#community-'+post).val();
    console.log(comm);
    jQuery.ajax({
        type: "GET",
        url: '/repost/'+ post + '-'+user+'-'+comm,
        success: function(data)
        {
            $.magnificPopup.close();
        }
    });
}

function repostToCommunity(post)
{
    var comm = $('#community-my-'+post).val();
    console.log(comm);
    jQuery.ajax({
        type: "GET",
        url: '/repost-to-community/'+ post + '-' + comm,
        success: function(data)
        {
            $.magnificPopup.close();
        }
    });
}

function deletePostFromUserWall(postId) {
    jQuery.ajax({
        type: "GET",
        url: '/profile/ajax-deletePost-'+postId,
        success: function(data)
        {  
            $('#post-'+postId).remove();
        }
    });
}

function deletePostFromCommWall(postId, commId) {
    jQuery.ajax({
        type: "GET",
        url: '/profile/ajax-deleteCommunityPost-'+postId+'-'+commId,
        success: function(data)
        {    
            $('#post-'+postId).remove();
        }
    });
}

function deleteSharedPost(postId) {
    jQuery.ajax({
        type: "GET",
        url: '/profile/ajax-deleteSharedPost-'+postId,
        success: function(data)
        {  
            $('#post-'+postId).remove();
        }
    });
}

function like(postId) {
    jQuery.ajax({
        type: "GET",
        url: '/profile/ajax-likePost-'+postId,
        success: function(data)
        {  
            var number = $('#likes1-'+postId).text();
            if (data.flag) {
                number++;
                $('#like-list-'+postId).append(''+
                    '<a id="like-'+postId+'-'+data.user+'" href="/profile>'+ 
                    '<div class="img-holder">'+
                        '<img src="'+data.src+'" alt="">'+
                    '</div>'+
                    '</a>');
            } else {
                number--;
                $('#like-'+postId+'-'+data.user).remove();
            }
            $('#likes1-'+postId).html(number);
            $('#likes2-'+postId).html(number);
        }
    });
}

function comment(postId) {
    var commetField = $('#comment-'+postId);
    var commentFieldHolder = commetField.closest('.create-message');
    var comment = commetField.val();
    var form_data = new FormData();                
    form_data.append('comment', comment);
    $.ajax({
        url: '/profile/ajax-commentPost-'+postId,
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(data)
        {
            $('<div class="info-block info-block-message">'+
                '<div class="wrap-holder">'+
                '<div class="img-holder">'+
                     '<img src="'+data.src+'" alt="">'+
                 '</div>'+
             '</div>'+
             '<div class="messenger-box">'+
                 '<div class="comment-content">'+data.content+'</div>'+
             '</div>' +
			 '<div class="span-holder">' +
                '<span class="date">'+data.time+'</span>' +
                '<span class="date">'+data.date+'</span>' +
			 '</div>' +
			 '</div>').insertBefore(commentFieldHolder);
            $('#comment-'+postId).val('');

            if (typeof auto_grow === "function") {
                auto_grow($('#comment-'+postId)[0]);
            }
        },
        error: function(data)
        {
        }
    });
}

function closePopup()
{
    $.magnificPopup.close();
}

function filterPostByPostTypeCategory(postType, postTypeCategory, locale) {

    var urlLocale = locale === 'fr' ? '' : '/' + locale;

    var url = urlLocale + '/profile/ajax-filterPosts';

    $.post({
        url: url,
        data: {
            'post_type': postType,
            'post_type_category': postTypeCategory,
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                $('.posts-wrap').html(response.html);
            }

            return false;
        }
    });

    return false;
}