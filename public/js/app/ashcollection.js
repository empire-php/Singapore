$(document).ready(function(){
    
    var baseUrl = $(".master_form").attr("action").replace("/save","");
    
    if ($( ".nric_autocomplete" ).length > 0){
        
        $( ".nric_autocomplete" ).each(function(){
            var nricInput = $(this);
            nricInput.autocomplete({
            source: function( request, response ) {
              $.getJSON( baseUrl + "/search_nric", {
                term: request.term 
              }, response );
            },
            select: function( event, ui ) {
                nricInput.val( ui.item.nric );
                $( "#" + nricInput.attr("id").replace("nric","name") ).val( ui.item.name );
                $( "#" + nricInput.attr("id").replace("nric","email") ).val( ui.item.email );

                return false;
            }
        }).autocomplete( "instance" )._renderItem = function( ul, item ) {
                return $( "<li>" )
                  .append( "<div>" + item.nric  + "</div>" )
                  .appendTo( ul );
            };
        });
        
        
    }
});