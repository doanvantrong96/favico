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













  $(document).on('click','.overlay_left_right .slick-prev',function(){
    $(this).parent().parent().find('.mc-carousel__peek--after').css('opacity',1);
    if( $(this).hasClass('slick-disabled')){
      $(this).parent().parent().find('.mc-carousel__peek--before').css('opacity',0);
    }else{
      $(this).parent().parent().find('.mc-carousel__peek--before').css('opacity',1);
    }
  });

  $(document).on('click','.overlay_left_right .slick-next',function(){
    $(this).parent().parent().find('.mc-carousel__peek--before').css('opacity',1);
    if( $(this).hasClass('slick-disabled')){
      $(this).parent().parent().find('.mc-carousel__peek--after').css('opacity',0);
    }else{
      $(this).parent().parent().find('.mc-carousel__peek--after').css('opacity',1);
    }
  });

  //js story
  var arrFiles = [];
  var imgType = ["image/png", "image/jpg", "image/jpeg", "image/svg","video/mp4"];
  $('.file_story').change(function() {
    let file = this.files[0]
    console.log('file: ' + file.type)
    if(this.files && file) {
      let maxSize = 10000;
      let fileSize = file.size / 1024 //kB
      if(fileSize > maxSize || !imgType.includes(file.type)) {
          $('.simply-toast').fadeOut();
          toastr['warning']("Định dạng PNG/JPEG/JPG/SVG/MP4 và dung lượng tối đa "+maxSize+' KB');
          $(this).val('');
      } else {
         $(this).parent().find('.file_name').text(file.name).css('color', '#555555')
         arrFiles.push(file)
      }
    }
  })
  let page = 0;
  $(document).on('click','.see_more', function(){
    page++;
    $.ajax({
      type:'POST',
      url:'/site/my-story',
      data:{page:page},
      success:function(res){
        var data = $.parseJSON(res);
        console.log(data['data']);
        if(data['data'].length > 0){
          $('.list_library_story').append(data['data']);
        }
        if(data['offset'] == null){
          $('.see_more').hide();
        }
      }
    });
  });
  $('#warning_mobi').modal('show');
  // $(document).on('click','#btn_sendemail_rp', function(){
   
  // });
  $(document).on('click','.submit_story', function(){
    const province = $('#province').val();
    const content = $('#content_st').val();
    const expert_name = $('#expert_name').val();
    if(content == '' || content.length < 6){
      $('#content_st').focus();
      toastr['warning']('Nội dung phải có tối thiểu 10 ký tự và không được để trống.');
      return;
    }
    if(expert_name == ''){
      $('#expert_name').focus();
      toastr['warning']('Tên chuyên gia không được để trống.');
      return;
    }
    if(province == ''){
      $('#province').focus();
      toastr['warning']('Quận, Thành phố không được để trống.');
      return;
    }
    var formData = new FormData($('.form_story')[0]);
    if (arrFiles.length > 0) {
        arrFiles.forEach(function(v, i) {
            formData.append('images[]', arrFiles[i]);
        });
    }
    $.ajax({
      type:'POST',
      url:"/site/create-story",
      data:formData,
      processData: false,
      contentType: false,
      success:function(res){
        if(res == 1){
          toastr['success']('Chia sẻ câu truyện thành công!');
          $(".form_story")[0].reset();
          arrFiles = [];
          $(".file_story").val('');
        }else{
          toastr['warning']('Có lỗi vui lòng thử lại sau!');
        }
      }
    });
  });
  //end js story


  $(window).scroll(function () {
    if ($(window).scrollTop() + $(window).height() > $('footer').offset().top || $(window).scrollTop() == 0) {
      $('.sticky_bottom').removeClass('active_sticky_bottom');
    } else {
      $('.sticky_bottom').addClass('active_sticky_bottom');
    }
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

  $(document).on('click','.save_info',function(){
    var name = $('#name').val();
    var email = $('#email').val();
    var password = $('#password').val();
    $.ajax({
      type:'POST',
      url:"/site/update-info-user",
      data:{name:name,email:email,password:password},
      success:function(res){
        if(res == 1){
          toastr['success']('Cập nhật thành công!');
        }
      }
    });
  });

  $(document).on('click','#reset_question',function(){
    if(confirm("Bạn có chắc chắn muốn reset câu trả lời?")){
      var course_id = $(this).attr('course-id');
      $.ajax({
        type:'POST',
        url:"/course/reset-question",
        data:{course_id:course_id},
        success:function(res){
          if(res == 1){
            location.reload();
          }
        }
      });
    }
    else{
        return false;
    }
  })

  $(document).on('click','.img_chungchi',function(){
    var img = $(this).attr('src');
    $('.chungchi').attr('src',img)
  })
  $(document).on('click','.update_ip',function(){
    $(this).parent().parent().find('input').prop('disabled', false).focus();
  })
  
  $(document).on('click','.plus_button',function(){
    var course_id = $(this).attr('cour-id');
    $.ajax({
      type:'POST',
      url:"/site/like-course",
      data:{course_id:course_id},
      success:function(res){
        if(res == 1){
          toastr['success']('Khóa học đã thêm vào danh sách yêu thích!');
          $('.plus_button').find('img').attr("src","/images/page/done.png")
        }
        else{
          toastr['success']('Khóa học đã xóa khỏi danh sách yêu thích!');
          $('.plus_button').find('img').attr("src","/images/page/Layer_3.svg")
        }
      }
    });
  });


  $(document).on('click','.remove_cart',function(){
    var id_cart = $(this).attr('id-cart');
    $(this).parent().parent().remove();
    var count_curent = parseInt($('.count_cart').text());
    $('.count_cart').text(count_curent - 1);
    $.ajax({
      type:'POST',
      url:"/site/remove-cart",
      data:{id_cart:id_cart},
      success:function(res){
        if(res != ''){
          $('#total_mon').text(res+'Đ');
        }
      }
    });
  });

  $(document).on('click','#add_cart',function(){
    var id_course = $(this).attr('id-course');
    if(id_course != ''){
         $.ajax({
              type:'POST',
              url:"/site/add-to-cart",
              data:{id_course:id_course},
              success:function(res){
                   if(res == 1){
                        var count_curent = parseInt($('.count_cart').text());
                        $('.count_cart').text(count_curent + 1);
                        toastr['success']('Khóa học đã được thêm vào giỏ hàng!');
                   }
                   if(res == 2){
                        toastr['success']('Khóa học đã có trong giỏ hàng!');
                   }   
              }
         });
    }
  });
  $(document).on('click','.buy_now',function(){
    var id_course = $(this).attr('id-course');
    if(id_course != ''){
         $.ajax({
              type:'POST',
              url:"/site/add-to-cart",
              data:{id_course:id_course},
              success:function(res){
                   if(res == 1){
                        var count_curent = parseInt($('.count_cart').text());
                        $('.count_cart').text(count_curent + 1);
                        window.location.href = '/thanh-toan';
                        
                   }
                   if(res == 2){
                      window.location.href = '/thanh-toan';
                   }   
              }
         });
    }
  });


  $(document).on('click','.show_hide_filter',function(){
    $(this).parent().find('.content_filter').toggleClass('active');
  });

  $("#check_show_all,.ip_checkbox").on("click", function (e) {
    if($($(this)).is(":checked")){
      $(this).parent().find('.checkbox_cus_show').addClass('checked_sp');
    }else{
      $(this).parent().find('.checkbox_cus_show').removeClass('checked_sp');
    }
  });
  $(document).on("click",'.radio_answer', function (e) {
    if($($(this)).is(":checked")){
      $('.item_answer').find('i').removeClass('active');
      $(this).parent().find('i').addClass('active');
    }
  });
  $(".radio_payment").on("click", function (e) {
    if($($(this)).is(":checked")){
      $('.radio_payment').find('i').removeClass('active');
      $(this).parent().find('i').addClass('active');
    }
  });

  $('.slide_video_index_us').on('beforeChange', function(){
    $('.slide_video_index_us video').each(function() {
      $(this).get(0).pause();
    });
  });
  $('.slide_video_index_us').on('afterChange', function () {
      $(".slide_video_index_us .slick-current video")[0].play();
  });

  $('.slider_home').slick({
    speed: 10000,
    autoplay: true,
    autoplaySpeed: 0,
    centerMode: true,
    cssEase: 'linear',
    slidesToShow: 1,
    slidesToScroll: 1,
    variableWidth: true,
    infinite: true,
    arrows: false,
    buttons: false,
    rows:2,
  });
  $('.slide_video_index_us').slick({
		speed: 800,
		slidesToShow: 1,
		slidesToScroll: 1,
		focusOnSelect: false,
		pauseOnHover:false,
    fade: true,
    dots:false,
    infinite: true,
  });

  $('.list_type_cat').slick({
		autoplay: false,
		speed: 800,
		slidesToShow: 9,
		slidesToScroll: 1,
		focusOnSelect: false,
		pauseOnHover:false,
    dots:true,
    infinite: false,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToScroll: 0,
					infinite: false,
					swipeToSlide: true,
					speed: 800,
					slidesToShow: 2,
					slidesToScroll: 1,
					centerMode: false,
					arrows: false,
				}
			}
		]
  });
  // $('.my_node_list').slick({
	// 	autoplay: false,
	// 	speed: 800,
	// 	slidesToShow: 5,
	// 	slidesToScroll: 1,
	// 	focusOnSelect: false,
	// 	pauseOnHover:false,
  //   dots:true,
  //   infinite: false,
	// 	responsive: [
	// 		{
	// 			breakpoint: 768,
	// 			settings: {
	// 				slidesToScroll: 0,
	// 				infinite: false,
	// 				swipeToSlide: true,
	// 				speed: 800,
	// 				slidesToShow: 1,
	// 				slidesToScroll: 1,
	// 				centerMode: false,
	// 				arrows: false,
	// 			}
	// 		}
	// 	]
  // });
  $('.slider_cour').slick({
		autoplay: false,
		speed: 800,
		slidesToShow: 4,
		slidesToScroll: 1,
		centerMode: false,
		focusOnSelect: false,
		centerPadding: '20%',
		variableWidth: true,
		pauseOnHover:false,
    dots:true,
    infinite: false,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToScroll: 0,
					infinite: false,
					swipeToSlide: true,
					speed: 800,
					slidesToShow: 1,
					slidesToScroll: 1,
					centerMode: false,
					arrows: false,
				}
			}
		]
  });
  $('.slider_comming').slick({
		autoplay: false,
		speed: 800,
		slidesToShow: 2,
		slidesToScroll: 1,
		centerMode: false,
		focusOnSelect: false,
		infinite: false,
		centerPadding: '20%',
		variableWidth: true,
		pauseOnHover:false,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToScroll: 0,
					infinite: false,
					swipeToSlide: true,
					speed: 800,
					slidesToShow: 1,
					slidesToScroll: 1,
					centerMode: false,
					autoplay: false,
          arrows: false,
				}
			}
		]
  });

  $('.slider_comming').on('beforeChange', function(event, slick, currentSlide, nextSlide){
    console.log(nextSlide);
  });

  $('.slider_story').slick({
    dots:true,
    responsive: [
			{
				breakpoint: 768,
				settings: {
          arrows: false,
				}
			}
		]
  });
  $('.slider_related').slick({
    speed: 800,
    slidesToShow: 6,
    slidesToScroll: 1,
    infinite: true,
    arrows: true,
    buttons: false,
    dots:false,
    responsive: [
			{
				breakpoint: 768,
				settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          arrows: false,
				}
			}
		]
  });
  $('.course_top_list').slick({
    speed: 800,
    slidesToShow: 4,
    slidesToScroll: 1,
    infinite: true,
    arrows: true,
    buttons: false,
    dots:false,
    responsive: [
			{
				breakpoint: 768,
				settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          arrows: false,
				}
			}
		]
  });
  
  $('.slider_continue_lesson').slick({
    speed: 800,
    slidesToShow: 4,
    slidesToScroll: 1,
    infinite: false,
    arrows: true,
    buttons: false,
    dots:false,
    variableWidth: false,
    responsive: [
			{
				breakpoint: 768,
				settings: {
          variableWidth: true,
          centerPadding: '30%',
					slidesToScroll: 0,
					infinite: false,
					swipeToSlide: true,
					speed: 800,
					slidesToShow: 1,
					slidesToScroll: 1,
					centerMode: false,
					autoplay: false,
          arrows: false,
				}
			}
		]
  });
  $('.list_chungchi').slick({
    speed: 800,
    slidesToShow: 5,
    slidesToScroll: 1,
    infinite: false,
    arrows: true,
    buttons: false,
    dots:false,
    variableWidth: true,
    responsive: [
			{
				breakpoint: 768,
				settings: {
          variableWidth: true,
          centerPadding: '30%',
					slidesToScroll: 0,
					infinite: false,
					swipeToSlide: true,
					speed: 800,
					slidesToShow: 1,
					slidesToScroll: 1,
					centerMode: false,
					autoplay: false,
          arrows: false,
				}
			}
		]
  });
 
$(document).on('click','.question_child,.show_hide_filter',function(){
  $(this).toggleClass('active');
  if($(this).find('i').hasClass('fa-angle-down')){
    $(this).find('i').removeClass('fa-angle-down').addClass('fa-angle-up');
  }else{
    $(this).find('i').removeClass('fa-angle-up').addClass('fa-angle-down');
  }
});

$(document).on('click','.list_title a', function(e) {
  // e.preventDefault();
  var target = $(this).attr('href');
  $('html').animate({
    scrollTop: ($(target).offset().top - 150)
  }, 10);
  $('.list_title a').removeClass('active');
  $(this).addClass('active');
});




  $(document).on('mouseover','.stars .fa-star',function(){
    var onStar = parseInt($(this).attr('data-stt'), 10);
    $(this).parent().children('.fa-star').each(function(e){
      if (e + 1 <= onStar) {
        $(this).addClass('fas');
      }
      else {
        $(this).removeClass('fas').addClass('far');
      }
    });
  });
  $(document).on('click','.stars .fa-star',function(){
    rating = parseInt($(this).attr('data-stt'), 10);
    $(this).parent().children('.fa-star').each(function(e){
      if (e + 1 <= rating) {
        $(this).addClass('fas');
      }
      else {
        $(this).removeClass('fas').addClass('far');
      }
    });
    $.ajax({
      type: 'POST',
      url : '/danh-gia',
      data: {id: id, star: rating},
      success: function(res){
        if( res.status ){
          $('.point,.pt').text(res.star);
          $('.stars').attr('data-rating',res.star).stars();
          toastr['success'](res.msg);
          if( $('.des-pt').length <= 0 ){
            $('.text-muted').remove();
            $('.ml-2s').after('<p class="text-muted m-0 des-pt">Học viên đánh giá BMG Edu <span class="pt">' + res.star + '</span> trên 5 sao.</p>');
          }
        }else{
          toastr['error'](res.msg);
        }
      }
    });
  });
  $(document).on('mouseout','.stars .fa-star',function(){
    $(this).parent().children('.fa-star').each(function(e){
      if (e + 1 > rating) 
        $(this).removeClass('fas');
      else
        $(this).addClass('fas');
    });
  });
  $(document).on('click','.btn-open-modal',function(){
    var url = $(this).attr('data-url');
    $('#modal .modal-content').load(url,function(){
      setTimeout(function(){
        $('#modal').modal('show');
      }, 500);
    });
  });
  $(document).on('click','#modal .close',function(){
    $('#modal').modal('hide');
  });
  $(document).on('click','.faq-item h4',function(){
    
    if( $(this).parent().find('.collapse.open').length <= 0 ){
      $('.faq-item .collapse.open').removeClass('open').slideUp();
      $(this).parent().find('.collapse').slideToggle('slow', function() {
        if( $(this).parent().find('.collapse').css('display') == 'block' ){
          $(this).parent().find('.collapse').addClass('open');
        }else{
          $(this).parent().find('.collapse').removeClass('open');
        }
      });
    }else{
      $('.faq-item .collapse.open').removeClass('open').slideUp();
    }
  });
  $(document).on('click','.menu-toggle',function(){
    $('.main-nav').toggleClass('open');
    if( $('.main-nav').hasClass('open') )
      $('body').css('overflow','hidden');
    else
      $('body').removeAttr('style');
  });
  setSlideCourse();
  $(window).resize(function(){
    setSlideCourse();
  });
  $(document).on('click','.reveal',function(){
    if($(this).hasClass('fa-eye-slash')){
      $(this).removeClass('fa-eye-slash').addClass('fa-eye');
      $(this).parent().find('input').attr('type','password');
    }else{
      $(this).removeClass('fa-eye').addClass('fa-eye-slash');
      $(this).parent().find('input').attr('type','text');
    }
  });
  $(document).on('click','.dropdown.nav-item > .nav-link',function(e){
    e.preventDefault();
    $(this).parent().toggleClass('show');
    $(this).parent().find('.dropdown-menu').toggleClass('show');
  });
  $(document).mouseup(function(e) {
    var container1 = $(".dropdown.nav-item > .dropdown-menu");
    var container = $(".dropdown.nav-item > .nav-link");
    var container2 = $(".search");
    var container3 = $(".search-panel");
    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0 && !container1.is(e.target) && container1.has(e.target).length === 0) {
        if( container1.hasClass('show') ){
          container.trigger('click');
        }
    }
    if(container3.hasClass('show') && !container2.is(e.target) && container2.has(e.target).length === 0 && !container3.is(e.target) && container3.has(e.target).length === 0){
      container2.trigger('click');
      
    }
  });
  $(document).on('click','.btnSubmitModal',function(){
      var form = $(this).parent();
      var list_input = form.find('input');
      for( var i = 0; i < list_input.length; i++ ){
          var value = $.trim($(list_input[i]).val());
          if( value == "" ){
            toastr['error']('Nhập ' + $(list_input[i]).attr('placeholder').toLowerCase());
            $(list_input[i]).focus();
            return false;
          }
      }

      $.ajax({
        type: 'POST',
        url: form.attr('action'),
        data: form.serializeArray(),
        success:function(res){
            if( res.status ){
              window.location.reload();
            }else{
              toastr['error'](res.message);
            }
        }
      })
  });
  $(document).on('click','.promotion-banner-close',function(){
    $('.promotion-banner').slideUp('slow');
  });
  $(document).on('click','.search',function(){
    $(this).parent().find('.search-panel').toggleClass('show');
  });
  var timeout;
  $(document).on('click','.category-item',function(){
    var name = $(this).attr('data-name');
    if( timeout )
      clearTimeout(timeout);
    $('.category-list').hide();
    $('.btn-clear').show();
    $('.search-results').show();
    if( $('.search-results .loading').length <= 0 ){
      $('.search-results').find('ul').html('<li class="loading text-center"><img width="100" src="/images/icon-loadings.svg" /></li>');
    }
    getDataSearch('cate',name);
    $('#input-search').val(name);
  });

  $(document).on('click','.btn-clear',function(){
    $('#input-search').val('');
    $(this).hide();
    $('.category-list').show();
    $('.search-results').hide();
  });
  $(document).on('keyup','#input-search',function(){
    $('.result_search_default').hide();
    if( timeout )
      clearTimeout(timeout);
    if( $(this).val() != "" ){
      var value = $(this).val();
      $('.category-list').hide();
      $('.btn-clear').show();
      $('.search-results').show();
      if( $('.search-results .loading').length <= 0 )
        // $('.search-results').find('ul').html('<li class="result_item_search"><a href=""><img src="/images/home/result-search.png" alt=""><div><span>michael porter</span><p>Dạy ăn có chủ đích</p></div></a></li>');
        $('.search-results').find('ul').html('<li class="loading text-center"><img width="100" src="/images/icon-loadings.svg" /></li>');
      timeout  = setTimeout(function(){
        getDataSearch('all',value);
      },200);
    }
    else{
      $('.category-list').show();
      $('.search-results').hide();
      $('.result_search_default').show();
    }
      
  });
  $(document).on('focus','#input-search',function(){
    if($(this).val() == '')
      $('.result_search_default').show();
  });

  $(document).on('click', function (e) {
      if ($(e.target).closest("#input-search").length === 0) {
          $(".result_search_default").hide();
      }
  });

  $(document).on('click','.btn-buy.needLogin',function(){

    $('#modal .modal-content').load('/dang-nhap',function(){
      setTimeout(function(){
          $('#modal').modal('show');
      }, 500);
    });
      
  });
  
  
  
});