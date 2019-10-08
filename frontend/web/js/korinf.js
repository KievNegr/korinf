$(document).ready(function()
{
	var breadTop = $('.breadcrumb').outerHeight();
	var headerTop = $('#header').outerHeight();
	var top = breadTop + headerTop;

	$('.block-25').hover(function(){
		$('.filter-p').css('width', $(this).width());
	});


	if( $(document).scrollTop() > 400 )
	{
		$("#top").fadeIn(500);
		//$('#header').css('background-color', 'rgba(247, 247, 247, 0.93)');
	}
	
	$(document).scroll(function(e)
	{			
		if( $(this).scrollTop() > 300 )
		{
			$("#top").fadeIn(500);
			//$('#header').css('background-color', 'rgba(247, 247, 247, 0.93)');	
		}
		else
		{
			$("#top").fadeOut(500);
			//$('#header').css('background-color', 'rgba(255, 255, 255, 0.93)');
		}
	});
	
	$("#top").click(function()
	{
		$('body, html').animate( { scrollTop: 0 }, 500 );
	});	

	$(function($) {
		$.mask.definitions['~']='[+-]';
		//$('#name_buy').mask("");
		$('#phone-user').mask('+38(999)999-99-99');
		//$('#email_buy').mask("*?@?*");
		//$("#tin").mask("99-9999999");
		//$("#ssn").mask("999-99-9999");
		//$("#product").mask("a*-999-a999");
		//$("#eyescript").mask("~9.99 ~9.99 999");
	});
});
