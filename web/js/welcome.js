function sendConfirmationEmail(userEmail)
{
    $.ajax({
        url: '/ajax-send-confirmation-email?userEmail=' + encodeURIComponent(userEmail),
        type: 'get',
        success: function(data){
            $("#send-confirm-email").attr("disabled","disabled");
            $("#confirmation-modal").append('<p>The mail was sent, please check your Email address </p>');
        }
     });
}

function showNewUserModal(){
    if($("#new-user-modal")){
        $("#new-user-modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    }
};

function showNewUserCloseableModal(){
    if($("#new-user-modal")){
        $("#new-user-modal").modal();
    }
};

$(document).ready(function(){

    $('form#feedback-impressions-form').submit(function(e) {
        var form = this;

        $.ajax({
            type: "POST",
            url: '/profile/ajax-send-feedback/impressions',
            data: $(form).serialize(),
            success: function(data)
            {
                form.append(  data.message );
                $('#feedback-impressions-send')
                    .replaceWith('<button class="submit submit-send" type="button" data-dismiss="modal"><span>Close</span></button>');
            },
            error: function(data)
            {
                console.log('error');
            }
        });
        return false;
    });

    $('form#feedback-priorities-form').submit(function(e) {
        var form = this;

        $.ajax({
            type: "POST",
            url: '/profile/ajax-send-feedback/priorities',
            data: $(form).serialize(),
            success: function(data)
            {
                form.append(  data.message );
                $('#feedback-priorities-send')
                    .replaceWith('<button class="submit submit-send" type="button" data-dismiss="modal"><span>Close</span></button>');
            },
            error: function(data)
            {
                console.log('error');
            }
        });
        return false;
    });
});
