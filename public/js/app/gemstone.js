$(document).ready(function(){
    /*$( "#fa_code" ).autocomplete({
        source: function( request, response ) {
          $.getJSON( "/gemstone/getFA", {
            term: request.term 
          }, response );
        },
        select: function( event, ui ) {
            $( "#fa_id" ).val( ui.item.id );
            $( "#fa_code" ).val( ui.item.generated_code );
            $( "#deceased_name_1" ).val( ui.item.deceased_name );
            $( "#first_cp_email" ).val( ui.item.first_cp_email );
            $( "#first_cp_nric" ).val( ui.item.first_cp_nric );
            $( "#first_cp_name" ).val( ui.item.first_cp_name );
            $( "#name_signature_1" ).html( ui.item.first_cp_name );
            $( "#first_cp_address" ).val( ui.item.first_cp_address );
            $( "#first_cp_mobile" ).val( ui.item.first_cp_mobile_nr );
            $( "#second_cp_nric" ).val( ui.item.second_cp_nric );
            $( "#second_cp_name" ).val( ui.item.second_cp_name );
            $( "#name_signature_2" ).html( ui.item.second_cp_name );
            $( "#second_cp_address" ).val( ui.item.second_cp_address );
            $( "#second_cp_mobile" ).val( ui.item.second_cp_mobile_nr );
            
            return false;
        }
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
              .append( "<div>" + item.generated_code  + "</div>" )
              .appendTo( ul );
        };
    
    
    
        var s = $('#signature1').signField(). // Setup
        on('change', function(){ 
          var signature = $(this); // div
        });
        var s = $('#signature2').signField(). // Setup
        on('change', function(){ 
          var signature = $(this); // div
        });
        $("#box1, #box2").click(function(){
            $(this).next().show();
            $(this).hide();
            
        });
        $(".signature_box button").click(function(e){
            $(this).parents(".signature_box").prev().show();
            $(this).parents(".signature_box").hide();
            var m = moment().format("DD/MM/YYYY");
            var boxNr =  $(this).parents(".signature_box").attr("id").replace("signature_box_","");
            $("#date_signature_" + boxNr).html(m);
            $("#input_date_signature_" + boxNr).val(m);
            
            $("#signature_image_" + boxNr).html($(this).parents(".signature_box").find(".imgdata").val());
            
            $("#box" +boxNr).html("<img src='"+  $(this).parents(".signature_box").find(".imgdata").val() +"' style='width: 98px' />");
            
            e.preventDefault();
        });
        
        
        $("#submit_bttn, #submit_email_bttn, #submit_print_bttn").click(function(){
            
            var bttn_clicked_txt = $(this).attr("id");
            var initialText = $(this).val();
            var bttn = $(this);
            
            $("#bttn_clicked").val(bttn_clicked_txt);
           
            $(this).val("Please wait");

            var jqxhr = $.ajax({
                url: '/gemstone/save',
                method: 'post',
                data:  $("#info_frm").serialize()
              })
            .done(function(data) {
                bttn.val(initialText);

                if (bttn.attr("id") == "submit_print_bttn"){
                    var win = window.open('/gemstone/genpdf/' + data.id, '_blank');
                    win.focus();
                }
                $("#message_container").html("Data saved");
                $("#save_msg").modal("show");
    
                
            })
            .fail(function() {
                $("#message_container").html("Error saving data" + ((  bttn_clicked_txt == "submit_email_bttn")?" or sendind mail.":""));
                $("#save_msg").modal("show");
                bttn.val(initialText);
            })
 
        });
        */
        
        $("#add_products").click(function(e){
            var obj = $( "#default_product" ).clone();
            obj.removeAttr("id");
            obj.find("input").val("");
            obj.find("select").val("");
            $( "#calc_zone" ).before(obj);
            obj.find("#deceased_name_1").attr("id",'deceased_name_' + $(".active_rows").length);
            create_autocomplete( 'deceased_name_' + $(".active_rows").length );
            e.preventDefault();
        });

        create_autocomplete("deceased_name_1");
        
        /*$(".cancel_bttn").click(function(){
           $("#save_msg").modal("hide");
       });*/
        
       
});

function create_autocomplete( id ){
    $( "#"+id )
      .autocomplete({
            source: function( request, response ) {
              $.getJSON( "/gemstone/search_deceased", {
                term: request.term 
              }, response );
            },
            select: function( event, ui ) {
                $( "#"+id ).val( ui.item.deceased_name );
                return false;
            }
        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
              .append( "<div>" + item.deceased_name + "</div>" )
              .appendTo( ul );
        };
        $( "#"+id ).on( "autocompleteopen", function( event, ui ) {
              $(".ui-menu-item").parent().append("<li id='"+ id +"_autocomplete_close' class='autocomplete_close'>" + $( "#" +id ).val() + " (new case)</li>");
              $("#"+ id +"_autocomplete_close").click(function(){
                  $( "#"+id ).autocomplete( "close" );
              });
        } );
        
        
        $("#"+id).parents("tr").find("select, input").change(function(){
            var subtotal = 0;
            $(".active_rows").each(function(){
                var price = $(this).find("select").val().split("||");
                var weight_ashes = $(this).find("[name^=weight_ashes]").val();
                if (price.length == 2){
                    $(this).find("[name^=price]").val(price[1]);
                    $(this).find(".price_view").html(price[1]);
                    $(this).find(".product_name").val($(this).find("select  option:selected").text().trim());
                    
                    var calcPrice = weight_ashes * $(this).find("[name^=quantity]").val() * price[1];
                    $(this).find("[name^=amount]").val(calcPrice.toFixed(2));
                    $(this).find(".amount_view").html(calcPrice.toFixed(2));
                    subtotal += calcPrice;
                }
            });

            $("#subtotal_val").val(Math.round(subtotal*100) /100);
            $("#subtotal").html((Math.round(subtotal*100) /100).toFixed(2)); 
            
            var gst = subtotal*7/100;
            $("#gst_val").val(Math.round(gst*100) /100);
            $("#gst").html((Math.round(gst*100) /100).toFixed(2));
            
            var t = Math.round(subtotal*100 + gst*100) /100;
            
            $("#total_amount_val").val( t );
            $("#total_amount").html(t.toFixed(2));
            
        });
}