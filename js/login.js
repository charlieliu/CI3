$(document).ready(function(){
	$('#btn_submit').click(function(event){
		if( event.preventDefault() ) event.preventDefault(); else event.returnValue = false;
		if( $.trim($('#username').val())=='' ){
			alert('name is empty');
			$('#username').focus();
		}
		else if( !/^[\u4e00-\u9fa5|\w|\.|\-]*$/.test($('#username').val()) )
		{
			alert('name 限用中英文數字_.-');
			$('#username').focus();
		}
		else if( $.trim($('#pwd').val())=='' ){
			alert('pwd is empty');
			$('#pwd').focus();
		}
		else
		{
			$.post(
				URLs,
				{
					"username":$('#username').val(),
					"pwd":$('#pwd').val(),
					"repwd":$('#repwd').val(),
					"email":$('#email').val(),
					"addr":$('#addr').val(),
					'csrf_test_name':$('#csrf_test_name').val()
				},
				function(response){
					if(response.status!='100')
					{
						alert(response.status);
					}
					else
					{
						//alert(response.status);
						window.location=IndexURLs;
					}
				},
				"json"
			);
		}
		return false;
	});
});