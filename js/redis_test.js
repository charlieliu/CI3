$(document).ready(function(){
	$(".redis_test").submit(function(event) {
		if( event.preventDefault ) event.preventDefault ; else event.returnValue=false ;
		$('#redis_log').html('Please wait a minute');
		$('#xhprof_dif').html('');
		$.ajax({
			url: URLs,
			type: "POST",
			data:$(this).serialize(),
			dataType: "json"
		}).done(function(response){
			//$('#results').html(response.result);
			alert(response.result);
			$('.dblink').html(response.dblink);
			$('#redis_log').html(response.redis_log);
			$('#xhprof_dif').html(response.xhprof_dif);
		});
		return false;
	});
});