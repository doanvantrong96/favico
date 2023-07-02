function addCommas(str) {
   return str.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
function formatRepo (repo) {
   if (repo.loading) {
     return repo.text;
   }
 
   var $container = $(
     "<div class='select2-result-repository clearfix'>" +
       "<div class='select2-result-repository__meta'>" +
         "<div class='select2-result-repository__title'></div>" +
       "</div>" +
     "</div>"
   );
 
   $container.find(".select2-result-repository__title").text(repo.name);
   return $container;
}
 
function formatRepoSelection (repo) {
   return repo.name || repo.text;
}
var callBackModal = function(response, status, jqXHR){
   if( status == "error" ){
       var msg = "";
       if (jqXHR.status === 0) {
           msg = "Không có kết nối mạng [0]";
       }
       else if (jqXHR.status == 403) {
           msg = "Bạn không đủ quyền để thực hiện hành động này. [403]";
       } else if (jqXHR.status == 404) {
           msg = "Trang yêu cầu không tìm thấy. [404]";
       } else if (jqXHR.status == 500) {
           msg = "Lỗi máy chủ nội bộ [500].";
       } else if (exception === "parsererror") {
           msg = "Phân tích JSON không thành công.";
       } else if (exception === "timeout") {
           msg = "Time out error.";
       } else if (exception === "abort") {
           msg = "";
       } else {
           msg = `Uncaught Error.\n${jqXHR.responseText}`;
       }
       if(msg != "")
           toastr["error"](msg);
   }else{
   }
};
jQuery(document).ready(function(){
   var timeout;
   $('.table-bordered th').hover(function(){
       clearTimeout(timeout);
       var _this = $(this);
       if( _this.find('.sp_tooltip').css('display') !== 'block' )
           $('.sp_tooltip').hide();
       timeout = setTimeout(function(){
           _this.find('.sp_tooltip').show();
       },550);
   }, function(){
       clearTimeout(timeout);
       $(this).find('.sp_tooltip').hide();
   });

   $('[data-toggle="tooltip"]').tooltip();

   var list_menu = $('.classic-menu-dropdown');
   if( list_menu.length > 0 ){
           for(var i = 0 ; i < list_menu.length; i++){
               var totalRow = $(list_menu[i]).find('.col-md-4').length;
               if(  totalRow > 0 ){
               var min_width= totalRow*244;
               if( min_width > 1000 )
                   min_width = 1000;
               $(list_menu[i]).find('.dropdown-menu').css('min-width',min_width + 'px');
               }
           }
   }

   $('ul.nav li.classic-menu-dropdown').hover(function() {
       $(this).addClass('open');
   }, function() {
       $(this).removeClass('open');
   });
    if( $('.alert').length > 0 ){
        setTimeout(function(){
            $('.alert:not(.keep)').slideUp();
        }, 5000);
    }
    $('.select2:not(".ajax")').each(function(i,item){
        var that = $(item);
        var placeholder = that.attr("placeholder");
        that.select2({
            placeholder: placeholder
        });
    });
    $('.select2.ajax').each(function(key,item){

        var optionSelect2 = {
            closeOnSelect: $(item).hasClass("disabled-close") ? false : true,
            ajax: {
              url: $(item).attr('data-url'),
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  q: params.term, // search term
                  ids_igrs: $(item).attr('data-id-igrs') !== undefined ? $(item).attr('data-id-igrs') : '',
                  page: params.page
                };
              },
              processResults: function (data, params) {
                params.page = params.page || 1;
          
                return {
                  results: data.items,
                  pagination: {
                    more: (params.page * 30) < data.total_count
                  }
                };
              },
              cache: true
            },
            placeholder: $(item).attr('data-placeholder'),
            minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        };
        if( $(item).attr('maxItem') !== undefined && $(item).attr('maxItem') != "" ){
            optionSelect2.maximumSelectionLength = parseInt($(item).attr('maxItem'));
            optionSelect2.language = {
                maximumSelected: function (e) {
                    return 'Chỉ được chọn tối đa ' +  e.maximum +  ' ' + $(item).attr('maxItemName');
                }
            }
        }

        $(item).select2(optionSelect2);
        var _element = $(item);
        _element.on("select2:unselect", function (evt) {
            if (_element.find(":selected").length > 0) {
                var element = evt.params.data.element;
                _element.find(":selected").eq(-1).after($(element));
            }
        });
        _element.on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);
            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        });
    });
    if( $('.input-max-length').length > 0 ){
        $('.input-max-length').each(function(key,item){
            var input = $(item);
            var max_length = input.attr('maxlength');
            var value = input.val();
            var html_counter = '<span style="float:right" class="counter_char" max="' + max_length + '">' + value.length + '/' + max_length + '</span>';
            var _parent = input.parent();
            _parent.find('> label').append(html_counter);
            input.on('keyup',function(){
                var counter_char = _parent.find('.counter_char');
                counter_char.text($(this).val().length + '/' + counter_char.attr('max'));
            });
        });
    }
   toastr.options = {
       closeButton:true,
       progressBar:true,
       showDuration:300,
       hideDuration:2500,//3 giây ẩn
       showEasing: "swing",
       hideEasing: "linear",
       showMethod: "fadeIn",
       hideMethod: "fadeOut"
   };
   if( $('.input-price').length > 0 ){
       $('.input-price').each(function(){
            $(this).val(addCommas($(this).val()));
       });
   }
   $(document).on('keyup','.input-price',function(){
        if( $.trim($(this).val()) != "" )
            $(this).val(addCommas($(this).val()));
    });
    
    $(document).on('change','.remove-unicode', function() {
        var _this   = $(this);
        var _parent = _this.parent().parent();
        if( _this.val() != '' ){
            ajaxUpload = $.ajax({
                url: "/common/remove-unicode",
                type: "POST",
                data : {text : _this.val(), char : '-'},
                success: function(res){
                    $(_this.attr('input-set')).val(res);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    if(xhr.statusText != 'abort')
                        toastr["error"](thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }else{
            $(_this.attr('input-set')).val('');
        }
    });

   var ajaxUpload;
   $(document).on('click','.cancel-upload',function(){
       ajaxUpload.abort();
       $(".meter").slideUp();
   });
   $(document).on('change','.file-upload-ajax', function() {
       var _this   = $(this);
       var _parent = _this.parent().parent();
       if(this.files[0]){
           var formData = new FormData();
           formData.append("file",this.files[0]);
           formData.append("folder",_this.attr('data-folder'));
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
                               _parent.find(".meter").slideUp();
                           }
                       }
                   }, false);
                   return xhr;
               },
               beforeSend: function() {
                   if( _parent.find('.meter').length <= 0 ){
                       _parent.append('<div class="meter" style="display:none"><span style="width:0"></span><i></i><p class="cancel-upload"><b class="fal fa-times-circle"></b> Huỷ</p></div>');
                   }
                   _parent.find(".meter").slideDown();
                   _parent.find(".meter > span").width('0%');
                   _parent.find(".meter > i").html('');
               },
               success: function(data){
                   let result = JSON.parse(data);
                   if( result.status ){
                       _parent.find(".meter").slideUp();
                       _parent.find('.cancel-upload').show();
                       toastr["success"](result.message);
                       _parent.find('.input-hidden-value').val(result.url);
                       $('.button_action button[type="button"]').attr('type', 'submit');
                       _parent.find('.img-preview').attr('src',result.url).show();
                       _this.parent().find('.custom-file-label').text(result.url);
                   }else{
                       toastr["error"](result.message);
                   }
               },
               error: function(xhr, ajaxOptions, thrownError) {
                   if(xhr.statusText != 'abort')
                       toastr["error"](thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
               }
           });
       }
   });
   
   $(document).on('change','.sl-set-name',function(){
       var _parent = $(this).parent().parent();
       if( $(this).val() != '' )
           _parent.find('input[type="hidden"]').val($(this).find('option:selected').text());
       else
           _parent.find('input[type="hidden"]').val('');
   });
   
   $(document).on('click','.icon-calendar-form',function(){
       $(this).parent().find('.input-date').focus();
   });
   $('.input-date').each(function(index,_this){
        var options = {
            singleDatePicker: true,
            showDropdowns: true,
            minDate: moment().startOf('year').format('YYYY-MM-DD'),
            minYear: parseInt(moment().format('YYYY'),10),
            maxYear: parseInt(moment().add(10, 'Y').format('YYYY')),
            format: $(_this).attr('data-format'),
            locale: {
                format: $(_this).attr('data-format'),
                daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            }
        };
        
        $(_this).daterangepicker(options, function(start, end, label) {
           
        });
   });
   
   $(document).on('keyup','.count-char',function(){
       var maxChar     = parseInt($(this).attr('maxlength'));
       var valInput    = $(this).val();
       var lengthInput = valInput.length;
       var _parent     = $(this).parent();
       if(lengthInput > maxChar ){
           valInput    = valInput.substring(0, maxChar);
           $(this).val(val);
           _parent.find('.sp-number-char').addClass("red").html(maxChar + "/" + maxChar);
       }
       else{
           _parent.find('.sp-number-char').removeClass("red").html(lengthInput+"/" + maxChar);
           _parent.find('.sp-number-char')
       }
   });
});