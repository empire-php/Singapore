$(document).ready(function(){
    
    /* SMS notification listing */
    var table = $('#listing_tbl').on( 'order.dt',  function () { 
        $('#listing_tbl').find("tr").each(function(){
            var nrTD = 0;
            $(this).find("td, th").each(function(){
                //console.log(nrTD);
                /*
                if (nrTD == 2 ||  nrTD == 4 || nrTD == 6 || nrTD == 8){
                    $(this).hide();
                }*/
                nrTD++;
            });
        });
    } ).DataTable( {
        'ajax': {
            'url' : '/smsnotification/smslisting',
            'dataSrc' : function (json) {
            //console.log(json.data);
            return json.data;
            }   
        }
           
    } );
    
    
    $('#filter_bttn').click(function(){
        table.ajax.url( 'hearse/listing?'+$(this).parents("form").serialize() ).load();
    });
    
    
    $('#contact_name').change(function() {
        var selectedVal = $(this).val();
        
        var arrVal = selectedVal.split('_');
        var pointsVal = arrVal[3];
        var pointsName = arrVal[0]+"_"+arrVal[1]+"_"+arrVal[2];
        
        $.getJSON( '/smsnotification/searchfuneral' ,{funeral_id: pointsVal, funeral_points_contact_name: pointsName}, function( responsedata ) {
            if( pointsName == 'first_cp_id' && responsedata[0].first_cp_mobile_nr != "" ){
                $( "#recipient_no" ).val( responsedata[0].first_cp_mobile_nr );
            }else if( pointsName == 'second_cp_id' && responsedata[0].first_cp_mobile_nr != "" ){
                $( "#recipient_no" ).val( responsedata[0].second_cp_mobile_nr );
            }
            //alert(responsedata);
        });
    });
    
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

function countChar(val) {
    var len = val.value.length;
    if (len > 160) {
        val.value = val.value.substring(0, 160);
    } else {
        $('#charNum').text(len+"/160");
    }
};