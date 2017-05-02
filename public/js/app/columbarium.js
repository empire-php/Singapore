$(document).ready(function(){
    /*$( "#fa_code" ).autocomplete({
        source: function( request, response ) {
          $.getJSON( "/columbarium/getFA", {
            term: request.term 
          }, response );
        },
        select: function( event, ui ) {
            $( "#fa_id" ).val( ui.item.id );
            $( "#fa_code" ).val( ui.item.generated_code );
            $( "#first_cp_email" ).val( ui.item.first_cp_email );
            $( "#first_cp_nric" ).val( ui.item.first_cp_nric );
            $( "#first_cp_name" ).val( ui.item.first_cp_name );
            $( "#first_cp_address" ).val( ui.item.first_cp_address );
            $( "#first_cp_mobile" ).val( ui.item.first_cp_mobile_nr );
            $( "#second_cp_nric" ).val( ui.item.second_cp_nric );
            $( "#second_cp_name" ).val( ui.item.second_cp_name );
            $( "#second_cp_address" ).val( ui.item.second_cp_address );
            $( "#second_cp_mobile" ).val( ui.item.second_cp_mobile_nr );
            $( "#final_resting_place" ).val( ui.item.resting_place );
            $( "#funeral_date" ).val( ui.item.funeral_date );
            $( "#deathdate" ).val( ui.item.deathdate );
            $( "#birthdate" ).val( ui.item.birthdate );
            $( "#dialect" ).val( ui.item.dialect );
            $( "[name=race]" ).val( ui.item.race );
            $( "[name=sex]" ).val( ui.item.sex );
            $( "#church" ).val( ui.item.church );
            $( "[name=religion]" ).val( ui.item.religion );
            $( "#deceased_name" ).val( ui.item.deceased_name );

            return false;
        }
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
              .append( "<div>" + item.generated_code  + "</div>" )
              .appendTo( ul );
        };
    
    
    
    $( "#deceased_name" )
      .autocomplete({
            source: function( request, response ) {
              $.getJSON( "/columbarium/search_deceased", {
                term: request.term 
              }, response );
            },
            select: function( event, ui ) {
                $( "#deceased_name" ).val( ui.item.deceased_name );
                $( "#first_cp_name" ).val( ui.item.first_contact_name );
                $( "#first_cp_mobile" ).val( ui.item.first_contact_number );
                $( "#second_cp_name" ).val( ui.item.second_contact_name );
                $( "#second_cp_mobile" ).val( ui.item.second_contact_number );
                $( "#shifting_id" ).val( ui.item.id );
                return false;
            }
        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
              .append( "<div>" + item.deceased_name + " - " + item.first_contact_name + "</div>" )
              .appendTo( ul );
        };
        $( "#deceased_name" ).on( "autocompleteopen", function( event, ui ) {
              $(".ui-menu-item").parent().append("<li id='autocomplete_close'>" + $( "#deceased_name" ).val() + " (new case)</li>");
              $("#autocomplete_close").click(function(){
                  $( "#deceased_name").autocomplete( "close" );
              });
        } );
    
    
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
            
            
            / *if (bttn_clicked_txt == "submit_print_bttn"){
                $("#info_frm").attr('target', '_blank');
            }
            else{
                $("#info_frm").removeAttr('target');
            }* /
            
            $("#info_frm").submit();
            
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

        
        $("[name^=amount]").blur(function(){
            calcTotal();
        });
        
        
        $("#deposit_val").change(function(){
            var total = ($("#total_amount_val").val())?parseFloat($("#total_amount_val").val()):0;
            var val = ($(this).val())?parseFloat($(this).val()):0;
            
            var balance_payable = (Math.round(total*100) - Math.round(val*100))/100;
            $("#balance_payable").html(balance_payable.toFixed(2));
            $("#balance_payable_val").val(balance_payable.toFixed(2));
        });
       
       $(".cancel_bttn").click(function(){
           $("#save_msg").modal("hide");
       });
       
       if ($("#save_msg_reload").length && $("#save_msg_reload").html() != ""){
            $("#message_container").html($("#save_msg_reload").html());
            $("#save_msg").modal("show");
       }
       
       
    $("#add_items").click(function(e){
        var newTrNr = $("#order_items_tbl tr").length + 1;
        $( "#click_add_zone" ).before('<tr id="added_tr_'+ newTrNr + '" class="active_rows">'+
                                            '<td><input type="text" class="form-control" name="item_name[]" value=""></td>'+
                                            '<td>'+
                                            '    <input type="text" class="form-control" name="selection[]" value="">'+
                                            '</td>'+
                                            '<td><input type="text" class="form-control" name="comments[]" value=""></td>'+
                                            '<td><span class="amount_view"></span><input type="text" class="form-control" name="amount[]" value=""></td>'+
                                        '</tr>');

        $("#added_tr_"+ newTrNr).find("[name^=amount]").blur(function(){
            calcTotal();
        });
        e.preventDefault();
    });
});

function calcTotal(){
    var subtotal = 0;
    $(".active_rows").each(function(){
        subtotal += ($(this).find("[name^=amount]").val())?parseFloat($(this).find("[name^=amount]").val()) * 100:0;
    });

    subtotal = Math.round(subtotal)/100;

    $("#subtotal_val").val(subtotal);
    $("#subtotal").html(subtotal); 

    var gst = subtotal*7/100;
    $("#gst_val").val(gst);
    $("#gst").html(gst);

    var total_amount_val = (Math.round(subtotal*100) + Math.round(gst*100))/100;
    $("#total_amount_val").val(total_amount_val.toFixed(2));
    $("#total_amount").html(total_amount_val.toFixed(2));

    $("#deposit_val").change();
}

/// for point 6 ///

var whichModal = "";
var whichItem = ""
$("#get_columbarium_items").click(function(e){
        e.preventDefault();
        
        $elementType = "add_columbarium";
        
        whichModal = $elementType;
        whichItem = $(this).attr("id");
        $.ajax({
            method: "GET",
            url: "/settings/get_images_for_popup",
            data: {elementType: $elementType}
        })
        .done(function( data ) {
            $("#"+$elementType +" .modal-body").html(data);
    
            
            
            $("#"+$elementType).modal("show");
          
           // jQuery.getScript("/js/app/hearse.js");
        });


    });	





function selectImagesInsteadItem2select(e){
      
        if (!$(e).hasClass("not_available")){

           $("#"+whichModal).find(".item2select").removeClass("selected_item");
            $(e).addClass("selected_item");
            
           
           $item_id =  $(e).attr("id").replace("columbarium_item_",""); 
           $item_price = $(e).find("span.unit_price").text();
           $("#group_items").val($item_id);
      
            		///////////////////// get all images//
		//	$id = $(e).attr("id");
		//	$changedId = $id.replace("ala_carte_item_","");
			
			 $.ajax({
            url: "/settings/get_all_images",
            method: "GET",
            dataType: "json",
            data: {id:$item_id},
        
            statusCode: {
                401: function() {
                  alert( "Login expired. Please sign in again." );
                }
            }
        }).done(function(data) {
           
			$htmls="";
			if(data != ""){
			for($i=0;$i<data.length-1;$i++){
				$htmls += "<img src='/uploads/"+data[$i]+"' width=300 style='margin:10px 10px 10px 10px'/>";
			}
			}else{
				$htmls = "No preview images";
			}
			$("#view_all_images_for_columbarium .modal-body").html($htmls);
			$("#view_all_images_for_columbarium").modal("show");
		})
        }
    }
    
     $("#all_image_view_close").click(function(){
        $("#view_all_images_for_columbarium").modal("hide");
    });
    
    $(".selected-item-ok").click(function(){
        
        $selected_columbarium = $(this).parents("#add_columbarium").find(".selected_item .columbarium_name_container").text();
        $selected_columbarium_price = $(this).parents("#add_columbarium").find(".selected_item .unit_price").text();
        
        $("#get_columbarium_items").parent().next().find("input[type='hidden']").val($selected_columbarium);
        $("#get_columbarium_items").parent().next().find("input[name='disabled_selection']").val($selected_columbarium);
        
         $("#get_columbarium_items").parent().next().next().next().find("input[name='disabled_amount']").val($selected_columbarium_price);
        $("#get_columbarium_items").parent().next().next().next().find("input[type='hidden']").val($selected_columbarium_price);
        calcTotal();
        $("#"+whichModal).modal("hide");
        
        
        
//        For point 9 
                        $.ajax({
                        url: "/columbarium/get_stock_info",
                        method: "GET",
                        data: {selected_item: $("#group_items").val()}
                    }).done(function(data) {
                      
                        if (data){
                          
                            $("#general_popup").find(".modal-body").html(data);
                            $("#general_popup").find(".modal-title").text("Stock status");
                            $("#general_popup").modal("show");

                            $("#general_popup").find("#save_general_bttn").click(function(){
                               
                                var group =[];
                                $("[id ^=group_select_item_]").each(function(){
                                   
                                  group.push($(this).attr("id").replace("group_select_item_","")+ $(this).val());
                                   
                                });
                                $("#group_items").val(group.join(","));
                                  $("#general_popup").modal("hide");
                           });
                           
                            $("#general_popup").find("#cancel_general_bttn").click(function(){
                                $("#general_popup").modal("hide");
                            });
                       }
                   });
    });