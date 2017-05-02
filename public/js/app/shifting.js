/*$(document).ready(function(){
    $( "#send_parlour" ).autocomplete({
        source: function( request, response ) {
          $.getJSON( "/shifting/search_parlour", {
            term: request.term 
          }, response );
        },
        select: function( event, ui ) {
            $( "#send_parlour" ).val( ui.item.name );
            return false;
        }
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
              .append( "<div>" + item.name  + "</div>" )
              .appendTo( ul );
    };  
    
    $('#send_parlour').autocomplete({ minLength: 0 });
    $('#send_parlour').click(function() { $(this).autocomplete("search", ""); });
    
 
});
*/
	$(function(){
		
		$("#pop-up-parlour").click(function(){
		
			//  popup-parlour as modal
			
			$("#booking_parlour input[name='deceased_name']").val($(".container-fluid .row").find("input[name='deceased_name']").val());
			$("#parlour_popup").modal("show");
		});
	});