$(document).ready(function(){
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
    
    $("tbody [id^=categories]").change(function(){
        var trElem = $(this).parents("tr");
        trElem.find("[id^=selection_item]").hide();
        if ($(this).val() != ""){
            trElem.find("[id^=selection_item_" + $(this).val()+"]").show();
            trElem.find("[name^=category_name]").val($(this).find("option:selected").text());
        }
    });
    
    
    $("tbody [id^=selection_item]").change(function(){
        var trElem = $(this).parents("tr");
        trElem.find("[id^=unit_price]").val($(this).find("option:selected").data("price"));
    });
    
    $(".add_column_td").click(function(){
        var th = $("#base_th_qty").clone().removeAttr("id");
        th.find("input").val("").datepicker({
			startView:2,
            singleDatePicker: true,
            timePicker: false,
            changeMonth: true,
            changeYear: true,
            format: 'dd/mm/yyyy'
        });
        $("#products_table th.add_column_td").before(th);
        
        var td_qty = $("#base_td_qty_r1").clone().removeAttr("id");
        
        td_qty.find("input").blur(function(){
            calculate_input_values($(this).parent());
        })
        td_qty.find("input").removeAttr("id").val("");
        calculate_input_values( td_qty );
        $("#products_table td.add_column_td").before(td_qty);

        $("#products_table tr.not_editable_line .qty input").hide();
        $("#products_table #click_add_td").attr("colspan", parseInt($("#products_table #click_add_td").attr("colspan")) + 1);
    });
    
    /*$("#base_td_qty_r1 input").blur(function(){
        calculate_input_values($(this));
    });
    $("#return_qty_r1").blur(function(){
        calculate_input_values($(this));
    });*/
    
//    $(".qty_order" ).change(function(){
//        calculate_input_values($(this));
//    });
    
    $("[id^=qty_order_" ).blur(function(){
       
        calculate_input_values($(this));
    });
    $("[id^=return_qty_").blur(function(){
        calculate_input_values($(this));
    });
    
    
    $("#click_add_td a").click(function(e){
        e.preventDefault();
        var tr = $("#r1").clone();
        tr.find("input, select").each(function(){
            $(this).val("");
            if (typeof $(this).attr("id") != "undefined"){
                $(this).attr("id",$(this).attr("id").replace("_r1","_r"+($("#products_table tbody tr").length +1)));
            }
            $(this).attr("name",$(this).attr("name").replace("_r1","_r"+($("#products_table tbody tr").length +1)));
        });
        tr.find("td").removeAttr("id");
        tr.find("[name^=row]").val("r"+($("#products_table tbody tr").length +1));
        tr.attr("id","r"+ ($("#products_table tbody tr").length +1));
        
        $("#products_table tbody").append(tr);
        
        tr.find("[id^=categories]").change(function(){
            var trElem = $(this).parents("tr");
            trElem.find("[id^=selection_item]").hide();
            if ($(this).val() != ""){
                trElem.find("[id^=selection_item_" + $(this).val()+"]").show();
                trElem.find("[name^=category_name]").val($(this).find("option:selected").text());
            }
        });
        
        tr.find("[id^=selection_item]").change(function(){
            var trElem = $(this).parents("tr");
            trElem.find("[id^=unit_price]").val($(this).find("option:selected").data("price"));
        });
        
        tr.find("[name^=qty_order]" ).blur(function(){
            calculate_input_values($(this));
        });
        tr.find("#return_qty_r"+ $("#products_table tbody tr").length ).blur(function(){
            calculate_input_values($(this));
        });
    });
    
    
    
     var s = $('#signature_1').signField(). // Setup
        on('change', function(){ 
          var signature = $(this); // div
        });

        var s = $('#signature_2').signField(). // Setup
        on('change', function(){ 
          var signature = $(this); // div
        });
        var s = $('#signature_3').signField(). // Setup
        on('change', function(){ 
          var signature = $(this); // div
        });

        $("#box1, #box2, #box3").click(function(){
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
    
    

});

function calculate_input_values( elem ){
  
    var sum = 0;
   
    $order_type = $(elem).parents("#info_frm").find("input[id='order_type']").val();
  
    var selector_name = "name";
    if ($(elem).parents("tr").find("[name^=qty_order]").length == 0){
        selector_name = "id";
    }


    $(elem).parents("tr").find("["+ selector_name +"^=qty_order]").each(function(){
        if ($(this).val()){
            sum += parseInt($(this).val());
           
        }
    });
    //For point 2.2
    if($(elem).parents("tr").find("#return_qty_r1").val() =='' ){
        $return_qty_val = 0;
    }else{
        $return_qty_val = parseFloat($(elem).parents("tr").find("#return_qty_r1").val());
    }
    
    if($order_type == "chanting" || $order_type =='tentage'){
         $(elem).parents("tr").find("#total_sold_r1").val(sum);
    }else{
        $(elem).parents("tr").find("#total_sold_r1").val(sum-$return_qty_val);
    }
        $(elem).parents("tr").find("#amount_r1").val($(elem).parents("tr").find("#total_sold_r1").val() * parseFloat($(elem).parents("tr").find("#unit_price_r1").val()));
   ////////////////////////////////////////////////////////////////////////////////////
    var q = 0;
    if ($(elem).parents("tr").find("[id^=selection_item] option:selected").length){
        
        var categ = elem.parents("tr").find("[id^=categories] option:selected").val();

        q = parseInt(elem.parents("tr").find("[id^=selection_item_" + categ+ "] option:selected").data("wq"));
        q += parseInt(elem.parents("tr").find("[id^=selection_item_" + categ+ "] option:selected").data("sq"));

  
        var sel_id = $(elem).parents("tr").find("[id^=selection_item] option:selected").val();
        var general_sum = 0;
        $("[id^=selection_item] option:selected").each(function(){
            if ($(this).val() == sel_id){
                $(this).parents("tr").find("["+ selector_name +"^=qty_order]").each(function(){
                    if ($(this).val()){
                        general_sum += parseInt($(this).val());
                    }
                });
            }
        });

        
        if (general_sum > q){
            alert("Quantity not available");
            elem.val("");
        }
        
    
        var return_qty = 0;
        if (elem.parents("tr").find("[id^=return_qty]").val()){
            return_qty = parseInt(elem.parents("tr").find("[id^=return_qty]").val());
        }
        
        if (return_qty > 0 && return_qty > sum){
            
            alert("Return quantity should be less than " + sum);
            elem.parents("tr").find("[id^=return_qty]").val("0");
            return_qty = 0;
        }
        
         
        var total_sold = Math.round((sum - return_qty)*100)/100;
        elem.parents("tr").find("[id^=total_sold]").val( total_sold );
        

        var unit_price = 0;
        var amount = 0;
        if (elem.parents("tr").find("[id^=unit_price]").val()){
            unit_price = parseFloat(elem.parents("tr").find("[id^=unit_price]").val());
            amount = Math.round( total_sold * unit_price *100 )/100;
        }
        
        elem.parents("tr").find("[id^=amount]").val( amount );
    }
    var total = 0;
    $("#products_table").find("[id^=amount]").each(function(){
        if ($(this).val()){
            total += parseFloat($(this).val());
        }
    });

    total = Math.round(total*100)/100;

    $("#products_table [id=total]").text(total);
    $("#products_table [name=total]").val(total);
}


// For point 2.2

function getInfomationToDetails(e){
    
    $id = $(e).attr("id").replace("item_category_id_","");
    
     $.ajax({
            url: "/scc/get_all_images",
            method: "GET",
            dataType: "json",
            data: {id:$id},
        
            statusCode: {
                401: function() {
                  alert( "Login expired. Please sign in again." );
                }
            }
        }).done(function(data) {
    
			$htmls="";
			if(data != ""){
                        
                            $htmls += "<div style='width:100%;padding:0 30px'><h3><b>Group Name</b> :"+data.group_name+"</h3><h3><b>Unit Price </b>:"+data.unit_price+"</h3></div>";
                            for($i=0;$i<data.images.length-1;$i++){
                                    $htmls += "<img src='/uploads/"+data.images[$i]+"' width=300 style='margin:10px 10px 10px 10px'/>";
                                  
                            }
			}else{
				$htmls = "No preview images";
			}
			$("#view_all_images_for_product .modal-body").html($htmls);
			$("#view_all_images_for_product").modal("show");
		});
                
                $("#all_image_view_close").click(function(){
                    $("#view_all_images_for_product").modal("hide"); 
                })
}
