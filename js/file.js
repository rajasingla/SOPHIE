$(document).ready(function(){
	$(".panel").hide();
	$(".use1").hide();
	$(".pass1").hide();
	$("#reguse").hide();
	$("#regpass").hide();
	$("#regrepass").hide();
	$("#regemail").hide();
	$(".pagi").hide();
	$(".pagination_1").show();
	$('#reguse').load('async.php');
  $(".flip").click(function(){
		$(this).next().slideToggle("slow");
  });
  $("#ford").submit(function(){
	  if($(":input:eq(0)").val()==''){
			$(".use1").show();
			event.preventDefault();}
			//return;}
		else
			$(".use1").hide();
	  if($("input:eq(1)").val()==''){
			$(".pass1").show();
			event.preventDefault();}
			//return;}
		else
			$(".pass1").hide();
	  });
	 $("#register").submit(function(){
		 
		$("#reguse").hide();
		$("#regpass").hide();
		$("#regrepass").hide();
		$("#regemail").hide();
		
		event.preventDefault();
		
		var hit=1;
		 
		 if($(":input:eq(3)").val()=="")
		 {
			 $("#reguse").html('Required');
			 $("#reguse").show();
			 hit=2;
		 }
		 else
		 {
			 var us=$("input:eq(3)").val().length;
			 var use=$("input:eq(3)").val();
			 if(us<6){
				$("#reguse").html('Must be 6 characters atleast');
				$("#reguse").show();
				hit=2;
			 }
			 else
			 {
			 	var pattern = new RegExp("[^a-zA-Z0-9]");
				var ans=pattern.test($(":input:eq(3)").val());
				if(ans)
				{
					$("#reguse").html('Username should match [a-zA-Z0-9]!');
					$("#reguse").show();
					hit=2;
				}
			 }
		 }
		 if($(":input:eq(4)").val()=="")
		 {
			 $("#regpass").html('Required');
			 $("#regpass").show();
			 hit=2;
		 }
		 else
		 {
			 var us=$("input:eq(4)").val().length;
			 if(us<6){
				$("#regpass").html('Must be 6 characters atleast');
				$("#regpass").show();
				hit=2;
			 }
		 }
		 if($(":input:eq(5)").val()=="")
		 {
			 $("#regrepass").html('Required');
			 $("#regrepass").show();
			 hit=2;
		 }
		 else
		 {
			 if($(":input:eq(4)").val()!="")
			 {
				 if($(":input:eq(4)").val()!=$(":input:eq(5)").val())
				 {
					 $("#regrepass").html('Passwords do not match');
					 $("#regrepass").show();
					 hit=2;
				 }
			 }
			 else
			 {
				 $("#regrepass").html('Passwords do not match');
				 $("#regrepass").show();
				 hit=2;
			 }
		 }
		 if($(":input:eq(6)").val()=="")
		 {
			 $("#regemail").html('Required');
			 $("#regemail").show();
			 hit=2;
		 }
		 else
		 {
			 var em=$("input:eq(6)").val();
			 if(!isValidEmailAddress(em))
			 {
				 $("#regemail").html('Invalid Email');
				 $("#regemail").show();
				 hit=2;
			 }
		 }
		 if(hit==2)
			event.preventDefault();
		 else	
		 {
			var use=$("input:eq(3)").val();
			$.post("async.php",{username : use},
			function(result)
			{
				var res=result;
				var da=che(res);
				if(da=='0')
					$("#register").submit();
			});
		 }
	  });
});

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}

function che(result)
{
	result=parseInt(result);
	if(result==1)
	{
		$("#reguse").html('Username already exists!');
		$("#reguse").show();
		return 1;
	}
	else
	{
		$("#reguse").html('<div style="color:green">Available!</div>');
		$("#reguse").show();
		return 0;
	}
}
