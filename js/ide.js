$(document).ready(function(){
	$("ajax").load('ideone.php');
	var cd=$(':input:eq(0)').val();
	var lag=$(':input:eq(1)').val();
	var pid=$(':input:eq(2)').val();
	$.post('ideone.php',$("#for").serialize(),
		function(result)
		{
			$("#ajax").fadeOut('slow',function(){
				$("#ajax").html(result);
				$("#ajax").fadeIn('slow');
				});
		});
	});
