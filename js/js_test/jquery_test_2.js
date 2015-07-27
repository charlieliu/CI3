$(document).ready(function(){
    $( "#check1" ).change(function() {
        $( "p[id='show_me1']" ).html(
            ".attr( 'checked' ): <b>" + $(this).attr( "checked" ) + "</b><br>" +
            ".prop( 'checked' ): <b>" + $(this).prop( "checked" ) + "</b><br>" +
            ".is( ':checked' ): <b>" + $(this).is( ":checked" ) + "</b><br>" +
            ".attr( 'disabled' ): <b>" + $(this).attr( "disabled" ) + "</b><br>" +
            ".prop( 'disabled' ): <b>" + $(this).prop( "disabled" ) + "</b><br>" +
            ".is( ':disabled' ): <b>" + $(this).is( ":disabled" ) + "</b>"
        );
    }).change();

    $('#attr_me').click(function(){
        if( $("#check1").attr( "disabled" )!=undefined )
            $("#check1").removeAttr("disabled").change();
        else
            $("#check1").attr( "disabled", "disabled" ).change();
    });

    $('#prop_me').click(function(){
        if( $("#check1").prop( "disabled" )==true )
            $("#check1").prop("disabled",false).change();
        else
            $("#check1").prop( "disabled", true ).change();
    });
});