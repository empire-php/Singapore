var popupId = "";
$(document).ready(function(){
        
   
    
    /*$( "#category" ).autocomplete({
        source: function( request, response ) {
          $.getJSON( "/inventory/prodcateg", {
            term: request.term 
          }, response );
        }
    });*/
    $('body').find('input:radio[name="unlimited_stock"]').change(
        function(){

            if ($(this).is(':checked') && $(this).val() == '1') {
                $("#warehouse").attr("readonly", "true");
                $("#store_room").attr("readonly", "true");
                $("#low_stock_amount").attr("readonly", "true");
                $("#warehouse").attr("placeholder", "unlimited");
                $("#store_room").attr("placeholder", "unlimited");
                $("#low_stock_amount").attr("placeholder", "unlimited");
                $("#warehouse").val('');
                $("#store_room").val('');
                $("#low_stock_amount").val('');
            }
            else{

                $("#warehouse").removeAttr("readonly");
                $("#store_room").removeAttr("readonly");
                $("#low_stock_amount").removeAttr("readonly");
                $("#warehouse").attr("placeholder", "");
                $("#store_room").attr("placeholder", "");
                $("#low_stock_amount").attr("placeholder", "");
            }
        });



    
    $(".add_new, .add_more_bttn, .stock_transfer_bttn, .mark_damage_bttn, .edit_remarks_bttn, .change_status_bttn").click(function(){
        if ($(this).hasClass("add_new")){
            popupId = "#new_product_form_container";
        }

        if ($(this).hasClass("add_more_bttn")){
            popupId = "#add_more_form_container";
            $("#add_product_id").val($(this).attr("id").replace("add_more_prod_",""));
        }

        if ($(this).hasClass("stock_transfer_bttn")){
            popupId = "#stock_transfer_form_container";
            $("#transfer_product_id").val($(this).attr("id").replace("stock_transfer_",""));
        }

        if ($(this).hasClass("mark_damage_bttn")){
            popupId = "#mark_damage_form_container";
            $("#damage_product_id").val($(this).attr("id").replace("mark_damage_prod_",""));
        }
        
        if ($(this).hasClass("edit_remarks_bttn")){
            popupId = "#edit_remarks_form_container";
            var id = $(this).attr("id").replace("edit_remarks_prod_","");
            $("#edit_remarks_txt").val( $("#remarks_"+ id ).html().trim() );
            $("#er_product_id").val(id);
        }
        
        if ($(this).hasClass("change_status_bttn")){
            popupId = "#change_status_form_container";
            var id = $(this).attr("id").replace("change_status_prod_","");
            if ( $("#status_"+ id ).html().trim() == "Available"){
                $("#change_status_sel").val(1);
            }
            else{
                $("#change_status_sel").val(0);
            }
            $("#cs_product_id").val(id);
        }

        $(popupId).modal("show");

    });

    $(".cancel_bttn").click(function(){
        $(popupId).modal("hide");
    });

    $(".save_bttn").click(function(){
        $(this).parents(".modal").find("form").submit();
    });


});

