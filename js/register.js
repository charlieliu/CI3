$(function(){
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
		else if( $.trim($('#repwd').val())=='' ){
			alert('repwd is empty');
			$('#repwd').focus();
		}
		else if( $.trim($('#email').val())=='' ){
			alert('email is empty');
			$('#email').focus();
		}
		else if( !/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test($('#email').val()) )
		{
			alert('email address error');
			$('#email').focus();
		}
		else if( $.trim($('#addr').val())=='' ){
			alert('address is empty');
			$('#addr').focus();
		}
		else if( $('#pwd').val()!=$('#repwd').val() )
		{
			alert('pwd and repwd is different');
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
						alert(response.status);
					}
				},
				"json"
			);
		}
		return false;
	});
	$('#addr').css('width',$('#email').css('width'));
});