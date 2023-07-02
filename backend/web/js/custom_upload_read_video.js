
var ajaxUpload;
var isPendingUpload = false;
var _0xd85bx5;
function _0xd85bx13(){
    jQuery(".videojs-hls-player-wrapper video").each(function (_0xd85bx2) {
    
        var _0xd85bx3 = jQuery(this).attr("id");
        if (jQuery(".u" + "i" + "-m" + "in").length > 0) {
            jQuery(this).on("contextmenu", function (_0xd85bx4) {
                _0xd85bx4.preventDefault()
            })
        };
        
        _0xd85bx5 = videojs(_0xd85bx3, {
            html5: {
                // hls: {
                //     withCredentials: true,
                //     overrideNative: true
                // }
            },
            "playbackRates": [0.25, 0.5, 1, 1.5, 2],
            "preload": "auto"
        });
        
        _0xd85bx5.ready(function () {
            this.on("play", function (_0xd85bx4) {
                this.isPlaying = true;
                jQuery(".video-js").each(function (_0xd85bx7) {
                    if (_0xd85bx2 !== _0xd85bx7) {
                        this.player.pause()
                    }
                })
            });
            if (this.tech_.hls && this.tech_.hls.xhr) {
                // this.tech_.hls.xhr.beforeRequest = function (_0xd85bx8) {
                //     if (_0xd85bx8.uri.indexOf(".ts") >= 0) {
                //         jQuery.ajax({
                //             url: "https://yogalunathai.com/video/touch",
                //             success: function (_0xd85bx9) {
                //                 _0xd85bx8.uri += "?token=" + _0xd85bx9;
                //             },
                //             async: false,
                //             cache: false
                //         })
                //     };
                //     return _0xd85bx8
                // }
            } else {
                this.on("play", function (_0xd85bx4) {
                    this.isPlaying = true;
                    // this.reQuestKeyForStream()
                });
                // _0xd85bx5.on("loadedmetadata", function () {
                //     var _0xd85bxe = this;
                //     setTimeout(function () {
                //         _0xd85bxe.waitForStreamkey()
                //     }, 2000)
                // });
                // _0xd85bx5.__proto__.waitForStreamkey = function _0xd85bxf() {
                //     var _0xd85bx10 = _0xd85bx5;
                //     jQuery.ajax({
                //         url: "/video/point",
                //         success: function (_0xd85bx11) {
                //             console.log(_0xd85bx11);
                //             if (_0xd85bx11 > 0) {
                //                 _0xd85bx10.nss = _0xd85bx11;
                //                 _0xd85bx10.reQuestKeyForStream()
                //             } else {
                //                 setTimeout(function () {
                //                     _0xd85bx10.waitForStreamkey()
                //                 }, 1000)
                //             }
                //         },
                //         cache: false
                //     })
                // };
                // _0xd85bx5.__proto__.reQuestKeyForStream = function _0xd85bx12() {
                //     if (!this.isPlaying) {
                //         return
                //     };
                //     var _0xd85bxe = this;
                //     jQuery.ajax({
                //         url: "/video/touch",
                //         pid: this.nss,
                //         success: function (_0xd85bx9) {
                //             _0xd85bx15(_0xd85bx9, parseInt(this.pid) + 999);
                //             setTimeout(function () {
                //                 _0xd85bxe.reQuestKeyForStream()
                //             }, 3000)
                //         },
                //         cache: false
                //     })
                // };
                _0xd85bx5.on("error", function (_0xd85bx13) {
                    this.isPlaying = false
                });
                _0xd85bx5.on("pause", function (_0xd85bx13) {
                    this.isPlaying = false
                })
            }
        })
    });
}
function _0xd85bx11(){
    if( $('#video_player video').length > 0 )
        _0xd85bx5.dispose();
}
function _0xd85bx12(src){
    $('.box-video').removeClass('hide');
    var video = document.createElement("video");
    video.setAttribute("id", "video");
    video.setAttribute("class", "hasFile video-js vjs-default-skin vjs-fluid vjs-16-9 vjs-big-play-centered ui-min ui-smooth v_5e8494e7ccb30-dimensions vjs-controls-enabled vjs-workinghover vjs-v7 vjs-hls-quality-selector vjs-has-started vjs-paused vjs-user-inactive");
    var video_source = document.createElement("source");
    video_source.setAttribute("src", src);
    video_source.setAttribute("type", "video/mp4");
    video.appendChild(video_source);
    document.getElementById("video_player").appendChild(video);
    _0xd85bx13();
}

function _0xd85bx14(_0xd85bxa) {
    var _0xd85bxb = "";
    var _0xd85bxc = "123456780ABCDEFGHKLMNOPYTRQW";
    for (var _0xd85bxd = 0; _0xd85bxd < _0xd85bxa.length; _0xd85bxd++) {
        if (_0xd85bxd % 2 == 0) {
            _0xd85bxb += _0xd85bxa[_0xd85bxd]
        } else {
            _0xd85bxb += _0xd85bxc[Math.floor((Math.random() * _0xd85bxc.length))];
            _0xd85bxb += _0xd85bxa[_0xd85bxd]
        }
    };
    return _0xd85bxb
}

function _0xd85bx15(_0xd85bx9, _0xd85bx16) {
    jQuery.ajax({
        url: "/video/press?bnid=" + _0xd85bx16 + "&tk=" + _0xd85bx14(_0xd85bx9),
        success: function (_0xd85bx11) {},
        cache: false
    })
}
jQuery(document).ready(function ($) {
    _0xd85bx13();
    $(document).on('change', '#customFile', function() {
        var _this = $(this);
        var _parent = _this.parent().parent();
        if(!isPendingUpload && this.files[0]){
            if( ajaxUpload )
                ajaxUpload.abort();
            var formData = new FormData();
            formData.append("file",this.files[0]);
            formData.append("folder",'video-lesson/' + _this.attr('data-id'));
            isPendingUpload = true;
            ajaxUpload = $.ajax({
                url: "/common/upload-file",
                type: "POST",
                data : formData,
                // dataType: 'jsonp',
                crossOrigin:true,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = ((evt.loaded / evt.total) * 100);
                            _parent.find(".meter > span").width(percentComplete + '%');
                            var percentCompleteShow = percentComplete.toFixed(1);
                            percentCompleteShow     = percentCompleteShow.toString().replace('.0','');
                            _parent.find(".meter > i").html(percentCompleteShow+'%');
                            if( percentComplete == 100 ){
                                setTimeout(function(){
                                    _parent.find(".meter").slideUp();
                                }, 1000);
                            }
                        }
                    }, false);
                    return xhr;
                },
                beforeSend: function() {
                    _parent.find(".meter").slideDown();
                    _parent.find(".meter > span").width('0%');
                    _parent.find(".meter > i").html('');
                },
                success: function(data){
                    isPendingUpload = false;
                    let result = JSON.parse(data);
                    if( result.status ){
                        _parent.find(".meter").slideUp();
                        toastr['success']("Tải video thành công. Bấm Cập nhật để lưu dữ liệu");
                        $(_this.attr('data-input')).val(result.url);
                        _this.parent().find('.custom-file-label').text(result.url);
                        $('#video_player').removeClass('hide').find('video').attr('src', result.url);
                        document.getElementById('customFile').value = "";
                        _0xd85bx11();
                        _0xd85bx12( result.url );
                    }else{
                        toastr['error'](result.message);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    isPendingUpload = false;
                    if(xhr.statusText != 'abort')
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    });
    $(document).on('click','.cancel-upload',function(){
        if( ajaxUpload )
            ajaxUpload.abort();
        $(this).parent().slideUp();
    });
    
})