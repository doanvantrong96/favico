$('i.glyphicon-refresh-animate').hide();
var idUser = 0;
function updateItems(r) {
    _opts.items.available = r.available;
    _opts.items.assigned = r.assigned;
    search('available');
    search('assigned');
}
$('.btn-change-status').click(function(){
    var list_input_checked = $('.checkbox_banned:checked');
    if( list_input_checked.length > 0 ){
        var listData       = [];
        for( var i = 0 ; i < list_input_checked.length ; i++ ){
            listData.push( list_input_checked[i].value );
            if($('#tr-user' + list_input_checked[i].value).hasClass('disabled')){
                $('#tr-user' + list_input_checked[i].value).removeClass('disabled').find('.status-user').html('Active');
            }else{
                $('#tr-user' + list_input_checked[i].value).addClass('disabled').find('.status-user').html('InActive');
            }
        }
        list_input_checked.removeAttr('checked');
        $('.checkbox_banned').parent().removeClass('checked');
        $.post('/sale-admin/change-status-sale', {data: listData }, function (r) {
            
        });
    }
});

$('.btn_banned').click(function(){
    var userid = $(this).attr('dtid');
    var text_confirm = '';
    if($('#tr-user' + userid).hasClass('disabled'))
        text_confirm = 'Bạn có chắc chắn muốn mở khoá tài khoản ' + $(this).attr('dtname') + '?';
    else
        text_confirm = 'Bạn có chắc chắn muốn khoá tài khoản ' + $(this).attr('dtname') + '?';

    if( confirm( text_confirm ) ){
        
        if($('#tr-user' + userid).hasClass('disabled')){
            $('#tr-user' + userid).removeClass('disabled').find('.status-user').html('Active');
        }else{
            $('#tr-user' + userid).addClass('disabled').find('.status-user').html('InActive');
        }
        $.post('/sale-admin/change-status-sale', {data: [userid]}, function (r) {
            
        });
    }
});
