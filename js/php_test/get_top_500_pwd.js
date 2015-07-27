$(document).ready(function(){
	$("#finder").val('frm1');
	$("#frm1_submit").click(function(event){
		if( event.preventDefault ) event.preventDefault ; else event.returnValue=false ;
		pagenav(1);
	});
	$("#frm1_reset").click(function(event){
		if( event.preventDefault ) event.preventDefault ; else event.returnValue=false ;
		$('#frm1')[0].reset();
		pagenav(1);
	});
	$('#pageNow').change(function(){
		var pg = parseInt( $(this).val() ), pgcnt = parseInt( $('#pageCnt').html() );
		if( pg<=1 ) pg=1;
		if( pg>pgcnt ) pg=pgcnt ;
		pagenav(pg);
	});
	$("#down_xls").click(function(){
		//if( event.preventDefault ) event.preventDefault ; else event.returnValue=false ;
		$('#frm1_page').val($('#pageNow').val()) ;
		$('#frm1').submit() ;
	});
});