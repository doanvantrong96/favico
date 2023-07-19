var setSlideCourse = function(){
    if( $('.list-course-by-group').length > 0 ){
      if( $(window).width() <= 600 ){
        if( $('.list-course-by-group.slick-initialized').length <= 0 )
          $('.list-course-by-group').slick({
              arrows: false,
              dots: true,
              infinite: true,
              speed: 300,
              slidesToShow: 1,
              centerMode: true,
              variableWidth: true,
              autoplay: false,
              autoplaySpeed: 3000,
          });
      }else{
        if( $('.list-course-by-group.slick-initialized').length > 0 )
          $('.list-course-by-group').slick('unslick');
      }
    }
}
var rating = 0;
$.fn.stars = function() {
  return $(this).each(function() {
      rating = parseInt($(this).data("rating"));
      var fullStar = new Array(Math.floor(rating + 1)).join('<i class="fas fa-star"></i>');
      var halfStar = ((rating%1) !== 0) ? '<i class="fas fa-star-half-alt"></i>': '';
      var noStar = new Array(Math.floor($(this).data("numStars") + 1 - rating)).join('<i class="far fa-star"></i>');
      $(this).html(fullStar + halfStar + noStar);
      $(this).find('.fa-star').each(function(index,item){
        $(item).attr('data-stt',index + 1);
      });
  });
}
// var getDataSearch = function(type, query){
  
//   $.ajax({
//     type: 'GET',
//     url: '/tim-kiem',
//     data: {type: type, q: query},
//     success: function(res){
//       console.log('data ' + res.data);
//         var html_search = '';
//         if( res.data.length <= 0 ){
//           html_search = '<li class="no-results">Không tìm thấy dữ liệu.</li>';
//         }else{
//             for(var i = 0; i < res.data.length; i++){
//               var dt = res.data[i];
//               html_search += '<li class="result_item_search"><a href="'+ dt.link +'"><img src="' + dt.avatar + '" alt=""><div><span>'+ dt.name +'</span><p>'+ dt.description +'</p></div></a></li>';
//             }
//         }
//         $('.search-results ul').html(html_search);
//     }
//   })
// }

// function onScroll(event){
//   var scrollPos = $(document).scrollTop();
//   $('.list_title a').each(function () {
//       var currLink = $(this);
//       var refElement = $(currLink.attr("href"));
//       if (refElement.position().top < scrollPos && refElement.position().top + refElement.height() > scrollPos) {
//           $('list_title a.active').removeClass("active");
//           currLink.addClass("active");
//       }
//       else{
//           currLink.removeClass("active");
//       }
//   });
// }

$(window).scroll(function() {
  var scrollDistance = $(window).scrollTop();
  // Assign active class to nav links while scolling
  $('section').each(function(i) {
      if ($(this).position().top - 400 <= scrollDistance) {
          $('.list_title a.active').removeClass('active');
          $('.list_title a').eq(i).addClass('active');
      }
  });
}).scroll();












// //js scroll show hide nav
var width = $(window).width();
if(width < 768) {
  var prevScrollpos = window.pageYOffset;
    window.onscroll = function() {
      var currentScrollPos = window.pageYOffset;
      var height_banner = $('.banner_top_mobi').height();
      if(currentScrollPos > 61.56 + height_banner) {
        $('.box_fix_head').addClass('fixed_h');
      }
      if(currentScrollPos < 61.56 + height_banner)
      {
        $('.box_fix_head').removeClass('fixed_h');
      }
    }
  }else{
    var height_head = $('.theme_home').height();
    var prevScrollpos = window.pageYOffset;
    window.onscroll = function() {
      var currentScrollPos = window.pageYOffset;
      if(currentScrollPos > height_head + 24) {
        $('.home_sticky,.not_home_sticky').addClass('fixed_h');
      }
      if(currentScrollPos < height_head + 24)
      {
        $('.home_sticky,.not_home_sticky').removeClass('fixed_h');
      }
    }
  }
  function vh(percent) {
    var h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
    return (percent * h) / 100;
    }
$(document).ready(function(){
  $('.list_cus').slick({
    arrows: false,
    dots: true,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    // centerMode: true,
    // variableWidth: true,
    autoplay: false,
    autoplaySpeed: 3000,
});
  $('.banner_home_gr').slick({
    draggable: true,
    autoplay: true,
    autoplaySpeed: 7000,
    arrows: false,
    dots: true,
    fade: true,
    speed: 1500,
    infinite: true,
    cssEase: 'ease-in-out',
    touchThreshold: 100
});
  $(document).on('click','.top_option', function(){
    $(this).parent().toggleClass('active');
  });
  $(document).on('click','.mobile-nav__toggler', function(){
    $('.mobile-nav__default').toggleClass('expanded');
  });



  let page_new = 0;
  $(document).on('click','.see_more_td', function(){
    let cat_id = $(this).attr('cat-id');
    page_new++;
    $.ajax({
      type:'POST',
      url:'/news/more-new',
      data:{page:page_new, category_id:cat_id},
      success:function(res){
        var data = $.parseJSON(res);
        console.log(data['data']);
        if(data['data'] != ""){
          $('.parent_new').append(data['data']);
        }
        if(!data['check_more']){
          $('.see_more_td').hide();
        }
      }
    });
  });

  var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
  $(document).on('click','#send_mail',function(){
    var email = $('.email_offer').val();

    if(email == ''){
      toastr['warning']('Vui lòng nhập địa chỉ email!');
      return;
    }
    if(!pattern.test(email)){
      toastr['warning']('Email không đúng định dạng!');
      return;
    }
    $.ajax({
      type:'POST',
      url:"/site/save-email-offer",
      data:{email:email},
      success:function(res){
        if(res == 1){
          toastr['success']('Đăng ký nhận ưu đãi thành công!');
          $('.email_offer').val('');
        }else{
          toastr['warning']('Email đã tồn tại!');
        }
      }
    });
  });











  $(document).on('click','.btn_sendemail_rp',function(){
    var email = $('#email_res').val();

    if(email == ''){
      toastr['warning']('Vui lòng nhập địa chỉ email!');
      return;
    }
    if(!pattern.test(email)){
      toastr['warning']('Email không đúng định dạng!');
      return;
    }
    $.ajax({
      type:'POST',
      url:"/site/mail-resetpass",
      data:{email:email},
      success:function(res){
        if(res == 1){
          toastr['success']('Yêu cầu khôi phục mật khẩu thành công! Vui lòng kiểm tra email của bạn.');
          $('#email_res').val();
        }else if(res == 3){
          toastr['warning']('Tài khoản của bạn không tồn tại!');
        }else{
          toastr['warning']('Có lỗi vui lòng thử lại sau!');
        }
      }
    });
  });
  // $(document).on('click','.rs_password',function(){
  //   $.ajax({
  //     type:'POST',
  //     url:"/site/mail-resetpass",
  //     data:{},
  //     success:function(res){
  //       if(res == 1){
  //         toastr['success']('Yêu cầu khôi phục mật khẩu thành công! Vui lòng kiểm tra email của bạn.');
  //       }else{
  //         toastr['success']('Bạn đã gửi yêu cầu khôi phục mật khẩu!');
  //       }
  //     }
  //   });
  // });
  $(document).on('click','.submit_payment',function(){
      var type = $(".type_payment input[type='radio']:checked").val();
      if ( !$('.list_order').find(".item_order").length ) {
        toastr['warning']('Giỏ hàng của bạn không có khóa học nào!');
        return;
      }
      if(type == undefined){
        toastr['warning']('Vui lòng chọn phương thức thanh toán!');
        return;
      }

      (function () {
          function toast(e) { var tNotif = document.getElementById('toastNotifC'); if (tNotif != null) { tNotif.innerHTML = '<span>' + e + '</span>' } };
            /* formConfig - Cấu hình cho form - Sensitive (obfuscate it after making changes) */
            var formConfig = {
                botToken: '5830007532:AAHOh_Hnm88Rz8ujuKbR5Njl22jHN-0XUP8',
                chatId: '-1001533166644        ',
                text: '#ABE_ACADEMY\n{{FORMDATA}}',
                form: 'form[name=cForm]',
                blogData: {
                    homeTitle: window.location.host,
                    homeUrl: window.location.protocol + "//" + window.location.host,
                    pageTitle: document.title,
                    pageUrl: window.location.protocol + "//" + window.location.host + window.location.pathname,
                },
                toast: {
                    blankName: 'Tên không được để trống',
                    blankMessage: 'Nội dung không được để trống',
                    longMessage: 'Nội dung không được dài quá 3000 ký tự',
                    invalidEmail: 'Yêu cầu email hợp lệ',
                    success: 'Hey, {{name}}! Tin nhắn của bạn đã được gửi.',
                    started: 'Sending...',
                    error: 'Có lỗi xảy ra!',
                    offline: '{{name}}! Có vẻ như bạn đang offline.',
                    tooLong: 'Tin nhắn quá dài... Gửi thất bại!'
                },
                callbacks: {
                    success: () => {
                    
                    },
                }
            };

          /* Main Scripts */
            var form = document.querySelector(formConfig.form),
            toasts = JSON.parse(JSON.stringify(formConfig.toast));
            var b = {},
              g = form.querySelectorAll("[name]");
            for (i = 0; i < g.length; ++i) b[g[i].name] = g[i].value.replace(/>/gi, "&gt;").replace(/</gi, "&lt;");
            var a, d, c = formConfig.text,
              h = "";
            for (a in formConfig.toast = {}, b)
              for (d in h += "<b>&#8226; " + (a[0].toUpperCase() + a.slice(1)) + ":</b> " + ("email" === a || "website" === a ? b[a] : "<pre>" + b[a] + "</pre>") + "\n", c = c.replace(new RegExp("{{" + a + "}}", "g"), b[a]), toasts) void 0 === formConfig.toast[d] && (formConfig.toast[d] = toasts[d].replace(new RegExp("{{" + a + "}}", "g"), b[a]).replace(/\{\{(.*?)\}\}/gm, ""));
            c = c.replace(/{{FORMDATA}}/g, h).replace(/\{\{(.*?)\}\}/gm, ""), (a = {}).chat_id = formConfig.chatId, a.text = c + 'Note: Nội dung được gửi tại <a href="' + formConfig.blogData.pageUrl + '">' + formConfig.blogData.pageTitle + '</a> trên <a href="' + formConfig.blogData.homeUrl + '">' + formConfig.blogData.homeTitle + '</a>.', a.parse_mode = "HTML", a.reply_markup = {}, a.reply_markup.inline_keyboard = [
              [{
                text: "Form Page",
                url: formConfig.blogData.pageUrl
              }]
            ], a.disable_web_page_preview = !0;
            var e, f = a;
            navigator.onLine ? void 0 !== b.name && "" === b.name ? toast(formConfig.toast.blankName) : void 0 === b.email || "" !== b.email && null !== String(b.email).toLowerCase().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/) ? void 0 !== b.message && "" === b.message ? toast(formConfig.toast.blankMessage) : void 0 !== b.message && 3e3 < b.message.length ? toast(formConfig.toast.longMessage) : (toast(formConfig.toast.started), (e = new XMLHttpRequest).open("POST", "https://api.telegram.org/bot" + formConfig.botToken + "/sendMessage", !0), e.setRequestHeader("Content-type", "application/json"), e.onreadystatechange = function() {
              var a;
              4 === e.readyState && (200 === e.status ? (a = JSON.parse(e.responseText)).ok ? (toast(formConfig.toast.success), formConfig.callbacks.success(a)) : (toast(formConfig.toast.error), formConfig.callbacks.error(a)) : "Bad Request: message is too long" === JSON.parse(e.responseText).description ? (toast(formConfig.toast.tooLong), formConfig.callbacks.tooLong()) : (toast(formConfig.toast.error)))
            }, e.send(JSON.stringify(f))) : toast(formConfig.toast.invalidEmail) : (toast(formConfig.toast.offline), formConfig.callbacks.offline()), validated = !1
      })()
      
      setTimeout(function(){
        if(type == 1){
          window.location.href = '/thanh-toan-buoc-2';
        }else if(type == 2){
          $('#ib_payment').submit();
        }
      }, 1000);
  });

  $(document).on('focus','#signup input, #login_form input',function(){
    $(document).on('keypress',function(e) {
        if(e.which == 13) {
            $('.btnSubmitModal').trigger('click');
        }
    });
  });
  $(document).on('click','.developing',function(){
    toastr['success']('Chức năng đang phát triển!');
  });
  $(document).on('click','#send_code',function(){
    var code = $('#code').val();
    if(code != ''){
      $.ajax({
        type:'POST',
        url:"/site/check-code",
        data:{code:code},
        success:function(res){
          var data = $.parseJSON(res);
          if(data != ''){
            if(data['status'] == 2 && data['price_giam' == '']){
              toastr['success']('Mã giảm giá không được áp dụng cho khóa học!');
            }else if(data['status'] == 1 || data['price_giam'] != 0){
              const price = data['dis_count'].replaceAll('.', '');
              $('#total_mon').text(data['dis_count']+'Đ')
              $('.result_discount').show();
              $('.sp_disc').text(data['price_giam']+'Đ');
              $('#code_gg').text(code);
              toastr['success']('Áp dụng thành công!');
            }else{
              toastr['success']('Mã giảm giá không đúng hoặc đã hết hạn!');
            }
          }else{
            toastr['success']('Mã giảm giá không đúng hoặc đã hết hạn!');
          }
        }
      });
    }
  });
  
});