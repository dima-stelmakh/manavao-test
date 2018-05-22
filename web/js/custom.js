jQuery(document).ready(function($) {

    $('.select-with-search').select2();

    $( "#opp_date" )
        .datepicker({
          //defaultDate: "+1w",
          minDate: 0,
          changeMonth: true,
          dateFormat: "dd/mm/yy"
        });

    $('#avatar-input').on('change', function() {
        var mnv_avatar = document.querySelector('.mnv-avatar');
        if (mnv_avatar) {
            var file_data = $(this).prop('files')[0];
            var form_data = new FormData();
            form_data.append('your-avatar', file_data);
            form_data.append('email', mnv_avatar.dataset.userEmail);
            $.ajax({
                url: localStorage.getItem('api_url') + '/user/avatar/set', // point to server-side PHP script
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(data){
                    $('#avatar-image').attr('src', data.avatar);
                }
            });
        }
    });

    var dateFormat = "dd/mm/yy",
      from = $( "#start_day" )
        .datepicker({
          defaultDate: "+1w",
          minDate: 0,
          changeMonth: true,
          dateFormat: dateFormat
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#end_date" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        dateFormat: dateFormat
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });

    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }

      return date;
    }
    jQuery("#user-dropdown").hover(function() {
        jQuery("#user-link").css('background-color', '#ededed');
    }, function() {
        jQuery("#user-link").css('background-color', 'initial');
        jQuery("#user-link").hover(function() {
           jQuery("#user-link").css('background-color', '#ededed');
        }, function() {
            jQuery("#user-link").css('background-color', 'initial');
        });
    });


    //registration page

    //DB imitation
//    var communityListArray={};
//
//    communityListArray.england=["London Business Community",
//                                    "Birmingham Business Community",
//                                    "Leeds Business Community"];
//    communityListArray.italy=["Rome Business Community",
//                                    "Milan Business Community",
//                                    "Naples Business Community"];
//    communityListArray.germany=["Berlin Business Community",
//                                    "Hamburg Business Community",  "Munich Business Community"];
//
//    var communityList =$("#community-list");
//    var selectedCommunityList= $("#selected-community-list");
    //add listener
//    submitStep0();
//    showCommunitiesStep1();
//    storeCommunitiesStep1();
//    clickContinueStep1();
    showMoreStep2();

    //wall page
    //add listener
    jQuery(".submit-post-type button").click(function(event) {
        if(jQuery('.submit-post-wrap').is(":visible")){
            jQuery('.submit-post-wrap').hide('fast/100/fast', function() { });
        }

        jQuery('.submit-post-wrap-active').show('fast/100/fast', function() { });
        jQuery(".post-tab-content-wrap>div").hide('fast/100/fast', function() { });

        var contentTab = event.target.getAttribute( "name" );

        jQuery(".submit-post-type button").removeClass('active');
        jQuery(".submit-post-type button").removeAttr('disabled')
        jQuery("button[name="+contentTab+"]").addClass('active');
        jQuery("button[name="+contentTab+"]").attr('disabled','disabled');
        jQuery("#"+contentTab).show('fast/400/fast', function() { });

        $( "#map-event" ).trigger( "resize" );

    });
    jQuery(".datepicker-holder .create-event").click(function(event) {
        if (!$("#submit-content-event").is(":visible")) {
            jQuery(".submit-post-type .submit-event").eq(0).click();
        }
        return false;
    });
    jQuery("button[name='continue-content-opportunity']").click(function(event) {
        jQuery(".step2-content-opportunity").show('fast/400/fast', function() {

        });
        jQuery("button[name='continue-content-opportunity']").hide('fast/100/fast', function() {

        });
        return false;
    });

    function showTabWall(showElem, disElem){
            disElem.hide('slow/400/fast', function() {
                showElem.show('slow/400/fast', function() {

                });
            });
    }

    function submitStep0(){
            $("#step0-form").submit(function(event) {

            var userEmail= $("input[name='user-email']");
            var userCity= $("input[name='user-city']");

            if (userEmail && userCity) {

                    $("#step0").hide('slow/400/fast', function() {

                            communityList.html("<li>"+userCity.val()+" Business Community</li> <li>"+userCity.val()+"2 Business Community</li><li>"+userCity.val()+"3 Business Community</li>");
                            $("#registration-tabs li:first-child").addClass('active');
                    });

                    $("#step1").addClass('active in');
            }
                    return false;
    });
    };

    function showCommunitiesStep1(){
            $("#community-area").change(function(event) {
            var currnetOption= $( '#community-area option:selected' ).val();
            var newListData="";
            if(currnetOption){
                    for (var i = 0; i <communityListArray[currnetOption].length; i++) {
                            newListData+="<li>"+communityListArray[currnetOption][i]+"</li>"
                    }
                    communityList.html(newListData);
                }
            });
    };
    function storeCommunitiesStep1(){
            $("#community-list").click(function(event) {
            $("#selected-title").html("You already selected:" );
            var selectElem=event.target;
            selectedCommunityList.html(selectedCommunityList.html()+" "+ selectElem.outerHTML+" ");
    });
    };


    function clickContinueStep1(){
            $("#to-step2").click(function(event) {
            if(selectedCommunityList.html()){
                    $("#registration-tabs li:nth-child(2)").addClass('active');
                    $("#step1").hide('slow/400/fast', function() { });

                    $("#step2").addClass('active in');
            }
            else(
                    $("#selected-title").html("Select your community")
                    )
                    return false;

    });
    };

    function showMoreStep2(){
            $("#step2-more").click(function(event) {
                    $("#step2-more").hide('slow/400/fast', function() {

                    });
                    $("#step2-more-content").show('slow/400/fast', function() {

                    });
            });

    };

    initDistantToggleTab();
    initMessagePopupLogic();
    initDatepicker();
});

(function() {
    var toggleDropdownElem = $('.dropdown-message-window');
    var firstLoad = true;

    if (!toggleDropdownElem.length) { return; }

    toggleDropdownElem.on('click', function() {
        var jThis = $(this);
        var parentElem = jThis.closest('li');

        if (!parentElem.length) { return; }

        parentElem.addClass('open');

        $('html').on('click',function(iEvent) {
            if (firstLoad) {
                firstLoad = false;
                return;
            }
            if (!$(iEvent.target).closest('.link-menu').length) {
                parentElem.removeClass('open');
                $(this).unbind(iEvent);
                firstLoad = true;
            }
        });
    });
})();

(function() {
    var infoBlockEl = $('.foto-wrap, .avatar-holder');
    var imgEl = infoBlockEl.find('img');
    var inputTypeFile;
    var filePath;
    var uploadCrop;
    var getCropResultBtn;
    var getImg = function (input) {
        var inputJsEl = input[0];
        if (inputJsEl.files && inputJsEl.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                uploadCrop.croppie('bind', {
                    url: e.target.result
                }).then(function(){

                });
            }

            reader.readAsDataURL(inputJsEl.files[0]);
        }
    };

    if (!infoBlockEl.length) {
        return;
    }

    uploadCrop = $('#image-cropp').croppie({
        viewport: {
            width: 200,
            height: 200,
            type: 'circle'
        },
        enableExif: true
    });

    inputTypeFile = infoBlockEl.find('input[type="file"]');
    inputTypeFile.change(function(){
       getImg(inputTypeFile);

       $.magnificPopup.open({
            items: {
                src: $('#cropp-img-popup'),
                type: 'inline'
            },
            callbacks: {
                beforeOpen: function() {
                    this.st.mainClass = this.st.mainClass + 'image-cropp-popup';
                },
                open: function() {
                  console.log(this.el);
                }
            }
        });

        getCropResultBtn = $('#get-cropp-result');
        getCropResultBtn.on('click', function() {
            uploadCrop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) {
                imgEl.attr('src', resp);
                uploadCroppedAvatar(resp);
                $.magnificPopup.close();
            });
        });
    });
})();

function uploadCroppedAvatar(dataURI) {
    var mnv_avatar = document.querySelector('.mnv-avatar-sidebar');
    if (mnv_avatar) {
        var blob = dataURItoBlob(dataURI);
        var form_data = new FormData();

        form_data.append('your-avatar', blob);
        form_data.append('email', mnv_avatar.dataset.userEmail);
        $.ajax({
            url: localStorage.getItem('api_url') + '/user/avatar/set', // point to server-side PHP script
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(data){
              var timestamp = new Date().getTime();
              $('img.user-avatar').attr('src', data.avatar + '?' + timestamp);
            }
        });
    }
}

function dataURItoBlob(dataURI) {
    // convert base64/URLEncoded data component to raw binary data held in a string
    var byteString;
    if (dataURI.split(',')[0].indexOf('base64') >= 0)
        byteString = atob(dataURI.split(',')[1]);
    else
        byteString = unescape(dataURI.split(',')[1]);

    // separate out the mime component
    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

    // write the bytes of the string to a typed array
    var ia = new Uint8Array(byteString.length);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }

    return new Blob([ia], {type:mimeString});
}

$('#new-user-modal').on('hidden.bs.modal', function() {
    var currPopupIndex = 0;
    var popupTmpls = [
        '#details-popup-1',
        '#details-popup-2',
        '#details-popup-3',
        '#details-popup-4',
        '#details-popup-5',
        '#details-popup-6'
    ];
    var onSkip = function() {
        $.magnificPopup.close();
    };
    var openNextPopup = function(event) {
        openTutorialPopup(popupTmpls[currPopupIndex], function(popupElem) {
            var nextPopupLink = $('.mfp-s-ready .details-popup .next-popup-link');
            var skipElem = $('.mfp-s-ready .details-popup .skip');

            nextPopupLink.on('click', function(e) {
                e.preventDefault();
                ++currPopupIndex;
                $.magnificPopup.close();

                setTimeout(function() {
                    openNextPopup();
                }, 500);
            });

            skipElem.on('click', function(e) {
                e.preventDefault();
                onSkip();
            });
        });
    };

    openNextPopup();
});

function openTutorialPopup(templ, onOpenCallback) {
    var anchorElem = $('[data-tutorial-popup="'+ templ +'"]');
    var secondaryHighlightElem = $('[data-tutorial-secondary="'+ templ +'"]');
    var anchorElemHeight = anchorElem.innerHeight();
    var screenRelativeTop;
    var screenRelativeLeft;
    var currPopupCssProps = {
        'position': 'absolute'
    };
    var getAnchorElemOffsetTop = function() {
        return anchorElem.offset().top;
    };
    var highlightElem = function(isToggle, defaultBg) {
        if (isToggle) {
            anchorElem.css({
                'position': 'relative',
                'z-index': '1042',
                'background': '#fff'
            });

            if (secondaryHighlightElem.length) {
                secondaryHighlightElem.css({
                    'position': 'relative',
                    'z-index': '1042',
                    'background': '#fff'
                });
            }

            return;
        }

        anchorElem.css({
            'position': 'relative',
            'z-index': 'auto',
            'background': defaultBg
        });

        secondaryHighlightElem.css({
            'position': 'relative',
            'z-index': 'auto',
            'background': defaultBg
        });
    };

    if (anchorElem.length) {
        $(window).scrollTop(getAnchorElemOffsetTop());
        setTimeout(function() {
            var anchorElemDefaultBg = anchorElem.css('background');
            currPopupCssProps.top = getAnchorElemOffsetTop() + anchorElemHeight;
            currPopupCssProps.left = anchorElem.offset().left - (window.scrollX || window.pageXOffset || document.body.scrollLeft) - 90;

            $.magnificPopup.open({
                items: {
                    src: templ,
                    type: 'inline'
                },
                callbacks: {
                    beforeOpen: function() {
                        this.st.mainClass = this.st.mainClass + 'hide-close-btn mfp-zoom-in tutorial-popup-opened';
                    },
                    open: function() {
                        var currentPopup = this.container.find('.details-popup');
                        var popupWrapper = $('.mfp-wrap.tutorial-popup-opened');

                        popupWrapper.height($('body').height());

                        if(anchorElem.length) {
                            currentPopup.css(currPopupCssProps);
                            highlightElem(true);
                        }
                        onOpenCallback();
                    },
                    close: function() {
                        var currentPopup = this.container.find('.details-popup');
                        highlightElem(false, anchorElemDefaultBg);
                    }
                }
            });
        }, 500);
    }
}


$(' .partners-wrap .partner .become-partner').magnificPopup({
    removalDelay: 500,
    items: {
        src: '#contact-us-popup',
        type: 'inline'
    },
    callbacks: {
        beforeOpen: function() {
            this.st.mainClass = this.st.mainClass + ' hide-close-btn mfp-zoom-in';
        }
    }
});


$(' #toggleFeedbackPopups1').magnificPopup({
    removalDelay: 500,
    items: {
        src: '#feedback-marketing-team',
        type: 'inline'
    },
    callbacks: {
        beforeOpen: function() {
            this.st.mainClass = this.st.mainClass + ' hide-close-btn mfp-zoom-in';
            setTimeout(function() {
                $('.details-popup-feedback .item h4 ').matchHeight();
            }, 100);
            initFeedbackRateSelect();
        }
    }
});

$(' #toggleFeedbackPopups2').magnificPopup({
    removalDelay: 500,
    items: {
        src: '#feedback-functions',
        type: 'inline'
    },
    callbacks: {
        beforeOpen: function() {
            this.st.mainClass = this.st.mainClass + ' hide-close-btn mfp-zoom-in';
            setTimeout(function() {
                $('.details-popup-feedback .item h4 ').matchHeight();
            }, 100);
            initFeedbackRateSelect();
        }
    }
});
function initFeedbackRateSelect() {
    var progressBarSelectors = $('.progress-holder .list-number li');

    if (!progressBarSelectors.length) { return; }

    progressBarSelectors.on('click', function() {
        var jthis = $(this);
        var holder = jthis.closest('.progress-holder');
        var progressBar = holder.find('.progres-bar .progres');
        var resInput = holder.find('input[type="hidden"]');
        var selectedValue = parseInt(jthis.text());

        if (!holder.length || !progressBar.length || !resInput.length) { return; }

        resInput.val(selectedValue);
        progressBar.css('width', selectedValue + '0%');
    });
}


$(' .post-action .link-popup-share').magnificPopup({
            removalDelay: 500,
                type: 'ajax',
            callbacks: {
                beforeOpen: function() {
                    this.st.mainClass = this.st.mainClass + ' hide-close-btn mfp-zoom-in';
                    setTimeout(function() {
                        customClosePopup();
                    }, 100);
                }
            }
        });

$(' .post-action .link-popup-update').magnificPopup({
        removalDelay: 500,
        type: 'ajax',
        callbacks: {
            beforeOpen: function() {
                this.st.mainClass = this.st.mainClass + ' hide-close-btn mfp-zoom-in';
                setTimeout(function() {
                    customClosePopup();
                }, 100);
            }
        }
    });

$(' .post-action .link-popup-event').magnificPopup({
        removalDelay: 500,
        type: 'ajax',
        callbacks: {
            beforeOpen: function() {
                this.st.mainClass = this.st.mainClass + ' hide-close-btn mfp-zoom-in';
                setTimeout(function() {
                    customClosePopup();
                }, 100);
            }
        }
    });

$(' .post-action .link-popup-likes').magnificPopup({
    removalDelay: 500,
    type: 'ajax',
    callbacks: {
        beforeOpen: function() {
            this.st.mainClass = this.st.mainClass + ' hide-close-btn mfp-zoom-in';
            setTimeout(function() {
                customClosePopup();
            }, 100);
        }
    }
});

$('.content-registration-wrap .registration-box .city-popup').magnificPopup({
    removalDelay: 500,
    items: {
        src: '#details-popup-city',
        type: 'inline'
    },
    callbacks: {
        beforeOpen: function() {
            this.st.mainClass = this.st.mainClass + ' hide-close-btn mfp-zoom-in';
        }
    }
});

function customClosePopup() {
    $('.mfp-wrap .custom-close-btn').on('click', function() {
        $.magnificPopup.close();
    });
}



function initDistantToggleTab() {
    var distantToggleTabs = $('[data-trigger-toggle]');
    var tabToggles = $('a[data-toggle]');

    if (tabToggles.length) {
        tabToggles.on('click', function() {
            var currentLink = $(this);
            var relativeDistantTabLinkHref = currentLink[0].hash.substring(1);
            var link = $('a[data-trigger-toggle="'+ relativeDistantTabLinkHref +'"]');

            distantToggleTabs.removeClass('active');
            link.addClass('active');
        });
    }

    if (distantToggleTabs.length) {
        distantToggleTabs.on('click', function(event) {
            var currentLink = $(this);
            var relativeTabLinkHref = '#' + currentLink.data('trigger-toggle');
            var link = $('a[data-toggle][href="'+ relativeTabLinkHref +'"]');

            event.preventDefault();

            distantToggleTabs.removeClass('active');
            currentLink.addClass('active');
            link.trigger('click');
        });
    }
}

(function() {
    var serchButton = $('.custom-icon-search');

    serchButton.on('click', function () {
        var input = $(this).closest('.input-holder').find('.search');
        input.focus();
    });
}());

function initMessagePopupLogic() {
    var triggerBtnSelector = 'button.send-msg, .trigger-message-window';
    // var triggerBtnSelector = 'button.send-msg';
    var messagePopupTriggerButton = $(triggerBtnSelector);
    var messagePopup = $('#message-window');
    var defaultPositionCssObj = {
        'top': '100%',
        'rigth': '4%',
        'left': 'auto'
    };
    var calcTopMarginShift = function(popup) {
        var height = popup.height();
        popup.css('margin-top', -height);
    };
    var initHideMessagePopup = function(popup) {
        var hideButton = popup.find('.icon-close');
        var unbindOnClickEvent = function(button) {
            button.off('click', '**');
        };
        hideButton.on('click', function() {
            popup.removeClass('active');
            popup.css(defaultPositionCssObj);
            unbindOnClickEvent(hideButton);
        });
    };
    var addMessagePopupDraggable = function(popup) {
        popup.draggable({
            containment: "window",
            scroll: false
        });
    };

    if (!messagePopupTriggerButton.length) { return; }
    if (!messagePopup.length) { return; }

    messagePopupTriggerButton.on('click', function() {
        messagePopup.css(defaultPositionCssObj);

        if (messagePopup.hasClass('active')) { return; }

        messagePopup.addClass('active');
        messagePopup.css(defaultPositionCssObj);
        addMessagePopupDraggable(messagePopup);
        calcTopMarginShift(messagePopup);
        initHideMessagePopup(messagePopup);
    });
}

(function() {
    var toggleAddCommentElem = $('.toggle-add-comment');

    if (!toggleAddCommentElem) { return; }

    toggleAddCommentElem.on('click', function(eventObj) {
        var jThis = $(this);
        var parentElem = jThis.closest('.post');
        var addCommentBtn;
        var commentInputEl;

        eventObj.preventDefault();

        if (parentElem.hasClass('add-comment')) {
            parentElem.removeClass('add-comment');
            return;
        }

        parentElem.addClass('add-comment');
        commentInputEl = parentElem.find('.messenger-box textarea');
        commentInputEl.on('input selectionchange propertychange', function() {
            parentElem.find('.info-block-message').addClass('btn-show');
        });
    });
})();

(function() {
    var openNotifficationLink = $('[data-toggle-notifications]');

    if (!openNotifficationLink.length) {
        return;
    }

    openNotifficationLink.on('click', function(event) {
        var jThis = $(this);
        var popupElem = $('.notifications-popup');
        $('html').on('click',function(iEvent) {
            if (!$(iEvent.target).closest('.notifications-popup').length) {
                jThis.closest('div').removeClass('open');
                $(this).unbind(iEvent);
            }
        });
        jThis.closest('div').addClass('open');
        event.stopPropagation();
    });
})();


function auto_grow(element) {
    element.style.height = "5px";
    element.style.height = (element.scrollHeight)+"px";
}

function initTextareaSetHeight() {
    var textareaSetHeightElems = $('textarea.set-content-height');

    if (!textareaSetHeightElems.length) { return; }

    [].forEach.call(textareaSetHeightElems, function(item) {
        if ($(item).is(':visible')) {
            auto_grow(item);
        }
    });

};
initTextareaSetHeight();

(function() {
    var tabSelectors = $('a[data-toggle="tab"]');

    if(!tabSelectors.length) { return; }

    tabSelectors.on('click', function() {
        setTimeout(function() {
            initTextareaSetHeight();
        }, 500);
    });
})();

function initDatepicker() {
  var datepickerEl = $('.datepicker-inline');
  var lang = datepickerEl.closest('.datepicker-holder').data('lang') || 'en';
  var datepickerI18nConfig = $.datepicker.regional[ lang ];
  var config = Object.assign({}, datepickerI18nConfig, {
    autoSize: true,
    altFormat: 'yy-mm-dd',
    firstDay: 1,
    showOtherMonths: true,
    selectOtherMonths: false,
    onSelect: function(dateText, inst) {
        dateText = dateText.split('/').join('-');
        window.location.href =  '/event-date/' + dateText;
    }
  })
  datepickerEl.datepicker(config);
}

