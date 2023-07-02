$('.classic-menu-dropdown .dropdown-menu.pull-left').each(function(){
	if( $(this).find('li').length <= 0 )
		$(this).parent().remove();
});
$('.classic-menu-dropdown').removeClass('active open');
// $('.'+li).addClass('active open');
$('.'+li).addClass('active');
$('.'+li+'>a').append('<span class="selected"></span>');
$('.'+li+'>a>span').addClass('open');
