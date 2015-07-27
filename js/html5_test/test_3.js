$(document).ready(function(){
	$("#contact1").submit(function(event) {
		if( event.preventDefault ) event.preventDefault ; else event.returnValue=false ;
		$.ajax({
			url: URLs,
			type: "POST",
			data:$("#contact1").serialize(),
			dataType: "json"
		}).done(function(response){
			var str = 'total='+response.total+'<br>';
			for(var i=0; i<response.data.length ; i++)
			{
				str += response.data[i].UA_id+'<br>' ;
			}
			$('#results').html(str);
		});
		return false;
	});
});