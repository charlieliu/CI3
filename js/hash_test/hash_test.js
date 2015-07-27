$(document).ready(function(){
	$("#btn_submit").click(function(){
		$("#btn_show").hide();$("#btn_disp").show();
		$.post(
			URLs,
			{
				hash_ary[hash_str] : $("#hash_str").val()
			},
			function(response){
				alert(response);
				$("#btn_show").show();$("#btn_disp").hide();
			},
			"json"
		);
	});
});