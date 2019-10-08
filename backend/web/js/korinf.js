$(document).ready(function(e)
{
	if( $(document).scrollTop() > 400 )
	{
		$("#top").show(500);
		$('#header').css('background-color', 'rgba(247, 247, 247, 0.93)');
	}
	
	$(document).scroll(function(e)
	{			
		if( $(this).scrollTop() > 300 )
		{
			$("#top").show(500);
			$('#header').css('background-color', 'rgba(247, 247, 247, 0.93)');	
		}
		else
		{
			$("#top").hide(500);
			$('#header').css('background-color', 'rgba(255, 255, 255, 0.93)');
		}	
	});
	
	$("#top").click(function()
	{
		$('body, html').animate( { scrollTop: 0 }, 500 );
	});
});
