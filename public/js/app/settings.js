
$(document).ready(function () {
       
    // Settings tables
    $.ajax({
        url: "/settings/get_items_settings",
        method: "GET",
        data: {elem: 'ala_carte'}
    }).done(function(data) {
        $("#collapseSeven .table_container").html( data );
    });
    
    $.ajax({
        url: "/settings/get_items_settings",
        method: "GET",
        data: {elem: 'hearse'}
    }).done(function(data) {
        $("#collapseEight .table_container").html( data );
    });
      
    
    $.ajax({
        url: "/settings/get_items_settings",
        method: "GET",
        data: {elem: 'individual_sales'}
    }).done(function(data) {
        $("#collapseNine .table_container").html( data );
    });
    
    
    $.ajax({
        url: "/settings/get_items_settings",
        method: "GET",
        data: {elem: 'parlour'}
    }).done(function(data) {
        $("#collapse11 .table_container").html( data );
    });
    
    // for point 5 //
    
    $.ajax({
        url: "/settings/save_term_condition",
        method: "GET",
        data: {elem: 'columbarium'}
    }).done(function(data) {
        $("#collapseTwelve .table_container").html( data );
    });
    

    $("#term_condition_save").click(function(){
        $.ajax({
            url: "/settings/save_term_condition",
            method: "GET",
            data: {term_condition: $("#term_condition").val()}
        }).done(function(data) {
        });
    });

    //
    $(".add_items").click(function(){
        var popup = $("#" + $(this).attr("id") + "_popup");
               
        if ($(this).attr("id") == "add_scc_chanting_items" || $(this).attr("id") == "add_scc_tentage_items" || $(this).attr("id") == "add_scc_tidbits_items" || $(this).attr("id") == "add_scc_christian_items" || $(this).attr("id") == "add_scc_buddhist_items" || $(this).attr("id") == "add_far_items"){
            popup = $("#add_general_items_popup");
            var elemType = $(this).attr("id").replace("add_","").replace("_items","");
            popup.find("#item_type").val(elemType);
           /* Make input type='file' id to add multiple images */
            popup.find("[type=file]").attr("id",elemType+"_images");
           /* END */
            if (elemType == "far" || elemType == "fa_individual_sales"){
                popup.find("#category_label, #category_name").hide();
                popup.find("#package_label, #package_name").show();
            }
            else{
                popup.find("#package_label, #package_name").hide();
                popup.find("#category_label, #category_name").show();
            }
        }
        popup.find("input, textarea, select").each(function(){
            if ($(this).attr("name") !="_token" && $(this).attr("id") !="item_type"){
                $(this).val("");
            }

            $(this).find("option").removeAttr("selected");

        });
        
        popup.find(".modal-title").html("");
        if ($(this).attr("id") == "add_scc_chanting_items"){
            popup.find(".modal-title").html("SCC Chanting Items");
        }
        if ($(this).attr("id") == "add_scc_tentage_items"){
            popup.find(".modal-title").html("SCC Tentage Items");
        }
        if ($(this).attr("id") == "add_scc_tidbits_items"){
            popup.find(".modal-title").html("SCC Tidbits & Drinks settings");
        }
        if ($(this).attr("id") == "add_scc_christian_items"){
            popup.find(".modal-title").html("SCC Christian settings");
        }
        if ($(this).attr("id") == "add_scc_buddhist_items"){
            popup.find(".modal-title").html("SCC Buddhist settings");
        }
        if ($(this).attr("id") == "add_far_items"){
            popup.find(".modal-title").html("FA for Repatriation Item");
        }
        
        popup.find('select').selectpicker('refresh');
        popup.modal("show");     
        
        
        
        popup.find( "#package_name" ).autocomplete({
            source: function( request, response ) {
              $.getJSON( "/settings/search_fa_sales_package", {
                term: request.term 
              }, response );
            }
        });
        popup.find('#package_name').autocomplete({ minLength: 0 });
        popup.find('#package_name').click(function() { $(this).autocomplete("search", ""); });
    });
    
    
    
    $("#add_ala_carte_items_popup .submit_bttn, #add_hearse_items_popup .submit_bttn, #add_individual_sales_items_popup .submit_bttn, #add_parlour_items_popup .submit_bttn, #add_general_items_popup .submit_bttn, #add_columbarium_items_popup .submit_bttn").click(function(){
       
        var elem = $(this).parents(".modal");
        var elemType = elem.attr("id").replace("add_","").replace("_items_popup","");
        if (elemType == "general"){
            elemType = elem.find("#item_type").val();
        }
	
        var fd = new FormData();    
        fd.append( 'elem', elemType );
		
        if (elem.find("[name=image]").length > 0){
			 for (var i = 0, len = document.getElementById(elemType+'_images').files.length; i < len; i++) {
				
                                fd.append("image[]", document.getElementById(elemType+'_images').files[i]);
			 }
        }
            //fd.append( 'image',elem.find("[name=image]")[0].files[0] );
        
        elem.find("form input, form select, form textarea").each(function(){
            if ($(this).attr("name") != "image"){
                fd.append( $(this).attr("name"),$(this).val() );
            }
        });
	
        $.ajax({
            url: "/settings/save_items_settings",
            method: "POST",
            data: fd,
            processData: false,
            contentType: false,
        }).done(function() {
            elem.modal("hide");

            $.ajax({
                url: "/settings/get_items_settings",
                method: "GET",
                data: {elem: elemType}
            }).done(function(data) {
                $("#add_" + elemType+"_items").parents(".panel-body").find(".table_container").html( data );
            });
        });
    });
    
    $("[name=selection_item]").change(function(){
        $(this).parents("form").find("[name=unit_price]").val($(this).find("option:selected").data("price"));
    })
    
    
    // autocomplete - begin
    if ($( "#add_ala_carte_items_popup [name=selection_category]"  ).length > 0){
        $( "#add_ala_carte_items_popup [name=selection_category]"  ).autocomplete({
            source: function( request, response ) {
              $.getJSON( "/settings/search_inventory_category", {
                term: request.term 
              }, response );
            },
            select: function( event, ui ) {
                $( "#add_ala_carte_items_popup [name=selection_category]"  ).val( ui.item.category );
                $( "#add_ala_carte_items_popup [name=selection_category_selected]"  ).val( ui.item.category );
                return false;
            },
            search: function( event, ui ) {
                $( "#add_ala_carte_items_popup [name=selection_category_selected]"  ).val("");
            }
        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
              .append( "<div>" + item.category + "</div>" )
              .appendTo( ul );
        };
    }
    
    ///for point 5
     if ($( "#add_columbarium_items_popup [name=selection_category]"  ).length > 0){
        $( "#add_columbarium_items_popup [name=selection_category]"  ).autocomplete({
            source: function( request, response ) {
              $.getJSON( "/settings/search_inventory_category", {
                term: request.term 
              }, response );
            },
            select: function( event, ui ) {
                $( "#add_columbarium_items_popup [name=selection_category]"  ).val( ui.item.category );
                $( "#add_columbarium_items_popup [name=selection_category_selected]"  ).val( ui.item.category );
                return false;
            },
            search: function( event, ui ) {
                $( "#add_columbarium_items_popup [name=selection_category_selected]"  ).val("");
            }
        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
              .append( "<div>" + item.category + "</div>" )
              .appendTo( ul );
        };
    }
    
     $("#add_columbarium_items_popup [name=selection_category]").autocomplete({ minLength: 0 });
    $("#add_columbarium_items_popup [name=selection_category]").click(function() { $(this).autocomplete("search", ""); });
    $( "#add_columbarium_items_popup [name=selection_category]" ).blur(function(){
        if (!$( "#add_columbarium_items_popup [name=selection_category_selected]" ).val()){
            $( "#add_columbarium_items_popup [name=selection_category]" ).val("");
        }
    });
    
    
     
    if ($( "#add_columbarium_items_popup [name=selection_item_name]" ).length > 0){
        $( "#add_columbarium_items_popup [name=selection_item_name]" ).autocomplete({
            source: function( request, response ) {
              $.getJSON( "/settings/search_inventory_item", {
                term: request.term , category:  $( "#add_columbarium_items_popup [name=selection_category]" ).val()
              }, response );
            },
            select: function( event, ui ) {
                $( "#add_columbarium_items_popup [name=selection_item_name]" ).val( ui.item.item );
                $( "#add_columbarium_items_popup [name=selection_item_id]" ).val( ui.item.id );
                $( "#add_columbarium_items_popup [name=unit_price]").val( ui.item.unit_price );
                return false;
            },
            search: function( event, ui ) {
                $( "#add_columbarium_items_popup [name=selection_item_id]" ).val( "" );
                $( "#add_columbarium_items_popup [name=unit_price]").val( "" );
            }
        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
              .append( "<div>" + item.item + "</div>" )
              .appendTo( ul );
        };
    }
    $("#add_columbarium_items_popup [name=selection_item_name]").autocomplete({ minLength: 0 });
    $("#add_columbarium_items_popup [name=selection_item_name]").click(function() { $(this).autocomplete("search", ""); });
    $( "#add_columbarium_items_popup [name=selection_item_name]" ).blur(function(){
        if (!$( "#add_columbarium_items_popup [name=selection_item_id]" ).val()){
            $( "#add_columbarium_items_popup [name=selection_item_name]" ).val("");
        }
    });
    /////
    
    
    $("#add_ala_carte_items_popup [name=selection_category]").autocomplete({ minLength: 0 });
    $("#add_ala_carte_items_popup [name=selection_category]").click(function() { $(this).autocomplete("search", ""); });
    $( "#add_ala_carte_items_popup [name=selection_category]" ).blur(function(){
        if (!$( "#add_ala_carte_items_popup [name=selection_category_selected]" ).val()){
            $( "#add_ala_carte_items_popup [name=selection_category]" ).val("");
        }
    });
    
    
    
    if ($( "#add_individual_sales_items_popup [name=selection_category]"  ).length > 0){
        $( "#add_individual_sales_items_popup [name=selection_category]"  ).autocomplete({
            source: function( request, response ) {
              $.getJSON( "/settings/search_inventory_category", {
                term: request.term 
              }, response );
            },
            select: function( event, ui ) {
                $( "#add_individual_sales_items_popup [name=selection_category]"  ).val( ui.item.category );
                $( "#add_individual_sales_items_popup [name=selection_category_selected]"  ).val( ui.item.category );
                return false;
            },
            search: function( event, ui ) {
                $( "#add_individual_sales_items_popup [name=selection_category_selected]"  ).val("");
            }
        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
            
            return $( "<li>" )
              .append( "<div>" + item.category + "</div>" )
              .appendTo( ul );
        };
    }
    $("#add_individual_sales_items_popup [name=selection_category]").autocomplete({ minLength: 0 });
    $("#add_individual_sales_items_popup [name=selection_category]").click(function() { $(this).autocomplete("search", ""); });
    $( "#add_individual_sales_items_popup [name=selection_category]" ).blur(function(){
        if (!$( "#add_individual_sales_items_popup [name=selection_category_selected]" ).val()){
            $( "#add_individual_sales_items_popup [name=selection_category]" ).val("");
        }
    });
    
    
    
    
    if ($( "#add_ala_carte_items_popup [name=selection_item_name]" ).length > 0){
        $( "#add_ala_carte_items_popup [name=selection_item_name]" ).autocomplete({
            source: function( request, response ) {
              $.getJSON( "/settings/search_inventory_item", {
                term: request.term , category:  $( "#add_ala_carte_items_popup [name=selection_category]" ).val()
              }, response );
            },
            select: function( event, ui ) {
                $( "#add_ala_carte_items_popup [name=selection_item_name]" ).val( ui.item.item );
                $( "#add_ala_carte_items_popup [name=selection_item_id]" ).val( ui.item.id );
                $( "#add_ala_carte_items_popup [name=unit_price]").val( ui.item.unit_price );
                return false;
            },
            search: function( event, ui ) {
                $( "#add_ala_carte_items_popup [name=selection_item_id]" ).val( "" );
                $( "#add_ala_carte_items_popup [name=unit_price]").val( "" );
            }
        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
              .append( "<div>" + item.item + "</div>" )
              .appendTo( ul );
        };
    }
    $("#add_ala_carte_items_popup [name=selection_item_name]").autocomplete({ minLength: 0 });
    $("#add_ala_carte_items_popup [name=selection_item_name]").click(function() { $(this).autocomplete("search", ""); });
    $( "#add_ala_carte_items_popup [name=selection_item_name]" ).blur(function(){
        if (!$( "#add_ala_carte_items_popup [name=selection_item_id]" ).val()){
            $( "#add_ala_carte_items_popup [name=selection_item_name]" ).val("");
        }
    });
    
    
    if ($( "#add_individual_sales_items_popup [name=selection_item_name]" ).length > 0){
        $( "#add_individual_sales_items_popup [name=selection_item_name]" ).autocomplete({
           source: function( request, response ) {
             $.getJSON( "/settings/search_inventory_item", {
               term: request.term , category:  $( "#add_individual_sales_items_popup [name=selection_category]" ).val()
             }, response );
           },
           select: function( event, ui ) {
               $( "#add_individual_sales_items_popup [name=selection_item_name]" ).val( ui.item.item );
               $( "#add_individual_sales_items_popup [name=selection_item_id]" ).val( ui.item.id );
               $( "#add_individual_sales_items_popup [name=unit_price]").val( ui.item.unit_price );
               return false;
           },
            search: function( event, ui ) {
                $( "#add_individual_sales_items_popup [name=selection_item_id]" ).val( "" );
                $( "#add_individual_sales_items_popup [name=unit_price]").val( "" );
            }
       })
       .autocomplete( "instance" )._renderItem = function( ul, item ) {
           return $( "<li>" )
             .append( "<div>" + item.item + "</div>" )
             .appendTo( ul );
       };
    }
    $("#add_individual_sales_items_popup [name=selection_item_name]").autocomplete({ minLength: 0 });
    $("#add_individual_sales_items_popup [name=selection_item_name]").click(function() { $(this).autocomplete("search", ""); });
    $( "#add_individual_sales_items_popup [name=selection_item_name]" ).blur(function(){
        if (!$( "#add_individual_sales_items_popup [name=selection_item_id]" ).val()){
            $( "#add_individual_sales_items_popup [name=selection_item_name]" ).val("");
        }
    });
   
   
   $( "#package_name" ).autocomplete({
        source: function( request, response ) {
          $.getJSON( "/settings/search_fa_sales_package", {
            term: request.term 
          }, response );
        }/*,
        select: function( event, ui ) {
            $( "#package_name" ).val( ui.item.id );
            return false;
        }*/
    })/*.autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
              .append( "<div>" + item.name  + "</div>" )
              .appendTo( ul );
    }*/;  
    
    $('#package_name').autocomplete({ minLength: 0 });
    $('#package_name').click(function() { $(this).autocomplete("search", ""); });
   
   
   
    // GENERAL ITEMS
    
    if ($( "#add_general_items_popup [name=category_name]"  ).length > 0){

        $( "#add_general_items_popup [name=category_name]"  ).autocomplete({
            source: function( request, response ) {
              $.getJSON( "/settings/search_group_name", {
                term: request.term, elem: $( "#add_general_items_popup #item_type").val()
              }, response );
            },
            select: function( event, ui ) {
                $( "#add_general_items_popup [name=category_name]"  ).val( ui.item.category );
                $( "#add_general_items_popup [name=category_name_selected]"  ).val( ui.item.category );
                return false;
            },
            search: function( event, ui ) {
                $( "#add_general_items_popup [name=category_name_selected]"  ).val("");
            }
        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
            
            return $( "<li>" )
              .append( "<div>" + item.category + "</div>" )
              .appendTo( ul );
        };
    }
    $("#add_general_items_popup [name=category_name]").autocomplete({ minLength: 0 });
    $("#add_general_items_popup [name=category_name]").click(function() { $(this).autocomplete("search", ""); });

    
    if ($( "#add_general_items_popup [name=selection_category]"  ).length > 0){
        $( "#add_general_items_popup [name=selection_category]"  ).autocomplete({
            source: function( request, response ) {
              $.getJSON( "/settings/search_inventory_category", {
                term: request.term 
              }, response );
            },
            select: function( event, ui ) {
                $( "#add_general_items_popup [name=selection_category]"  ).val( ui.item.category );
                $( "#add_general_items_popup [name=selection_category_selected]"  ).val( ui.item.category );
                return false;
            },
            search: function( event, ui ) {
                $( "#add_general_items_popup [name=selection_category_selected]"  ).val("");
            }
        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
            
            return $( "<li>" )
              .append( "<div>" + item.category + "</div>" )
              .appendTo( ul );
        };
    }
    $("#add_general_items_popup [name=selection_category]").autocomplete({ minLength: 0 });
    $("#add_general_items_popup [name=selection_category]").click(function() { $(this).autocomplete("search", ""); });
    $( "#add_general_items_popup [name=selection_category]" ).blur(function(){
        if (!$( "#add_general_items_popup [name=selection_category_selected]" ).val()){
            $( "#add_general_items_popup [name=selection_category]" ).val("");
        }
    });
    
    if ($( "#add_general_items_popup [name=selection_item_name]" ).length > 0){
        $( "#add_general_items_popup [name=selection_item_name]" ).autocomplete({
           source: function( request, response ) {
             $.getJSON( "/settings/search_inventory_item", {
               term: request.term , category:  $( "#add_general_items_popup [name=selection_category]" ).val()
             }, response );
           },
           select: function( event, ui ) {
               $( "#add_general_items_popup [name=selection_item_name]" ).val( ui.item.item );
               $( "#add_general_items_popup [name=selection_item_id]" ).val( ui.item.id );
               $( "#add_general_items_popup [name=unit_price]").val( ui.item.unit_price );
               return false;
           },
            search: function( event, ui ) {
                $( "#add_general_items_popup [name=selection_item_id]" ).val( "" );
                $( "#add_general_items_popup [name=unit_price]").val( "" );
            }
       })
       .autocomplete( "instance" )._renderItem = function( ul, item ) {
           return $( "<li>" )
             .append( "<div>" + item.item + "</div>" )
             .appendTo( ul );
       };
    }
    $("#add_general_items_popup [name=selection_item_name]").autocomplete({ minLength: 0 });
    $("#add_general_items_popup [name=selection_item_name]").click(function() { $(this).autocomplete("search", ""); });
    $("#add_general_items_popup [name=selection_item_name]" ).blur(function(){
        if (!$( "#add_general_items_popup [name=selection_item_id]" ).val()){
            $( "#add_general_items_popup [name=selection_item_name]" ).val("");
        }
    });
    
   
   
    // autocomplete - end
    
    
    
    
    
    // DISCOUNT
    
    $("[id=tbl_fa_discount], [id=tbl_far_discount]").discountActions();
    
    $("#add_fa_discount, #add_far_discount").click(function(e){
        e.preventDefault();
        var elemName = $(this).attr("id").replace("add_","");
        var max = 0;
        $("[id^=" + elemName + "]").each(function(){
            if (max < parseInt($(this).attr("id").replace(elemName + "_",""))){
                max = parseInt($(this).attr("id").replace(elemName + "_",""));
            }
        });
        max++;
        
        var newTr = $("#base_" + elemName + "_tr").clone();
        newTr.find("input, span, a").each(function(){
            $(this).attr("id", $(this).attr("id").replace("_0","_" + max));
        });
        newTr.removeAttr("id");
        newTr.show();
        newTr.discountActions();
        $("#tbl_"+ elemName+ " tbody").append(newTr);
    });
    
    
    // FA PACKAGES BUILDER
    $("#add_package").click(function(e){
        e.preventDefault();
        
        $.ajax({
            url: "/settings/edit_fa_package",
            method: "GET",
            dataType: "html",
            data: {id: 0},
        
            statusCode: {
                401: function() {
                  alert( "Login expired. Please sign in again." );
                }
            }
        }).done(function(html) {
            
            
            $("#edit_package_container").html(html);
            $("#edit_package_container").show();
            
            
        });
        
        
    });
    
    $.ajax({
        url: "/settings/list_fa_packages",
        method: "GET",
        dataType: "html",

        statusCode: {
            401: function() {
              alert( "Login expired. Please sign in again." );
            }
        }
    }).done(function(html) {
        $("#tbl_list_package").html(html);
    });
    
});




$.fn.discountActions = function () {
    $(this).find("[id^=fa_save_], [id^=far_save_]").click(function(e){
        e.preventDefault();
        
        var obj = $(this);
        var arr = $(this).attr("id").split("_");

        $.ajax({
            url: "/settings/save_discount",
            method: "GET",
            dataType: "json",
            data: {elem: arr[0], inc: arr[2], value: $("#"+arr[0] + "_discount_" + arr[2]).val()},
        
            statusCode: {
                401: function() {
                  alert( "Login expired. Please sign in again." );
                }
            }
        }).done(function(data) {
            if (data.msg == "ok"){
                obj.hide();
                $("#"+ obj.attr("id").replace("save","edit")).show();
                $("#"+ obj.attr("id").replace("save","delete")).show();
                
                $("#"+ obj.attr("id").replace("save","discount")).hide();
                $("#span_"+ obj.attr("id").replace("save","discount")).text($("#"+arr[0] + "_discount_" + arr[2]).val());
                $("#span_"+ obj.attr("id").replace("save","discount")).show();
            }
            else{
                alert("Error saving data.");
            }
        });
    });
    
    $(this).find("[id^=fa_edit_], [id^=far_edit_]").click(function(e){
        e.preventDefault();
        
        $(this).hide();
        $("#"+ $(this).attr("id").replace("edit","delete")).hide();
        $("#"+ $(this).attr("id").replace("edit","save")).show();
        
        $("#"+ $(this).attr("id").replace("edit","discount")).css("display","table-cell");
        $("#span_"+ $(this).attr("id").replace("edit","discount")).hide();
        
    });
    
    $(this).find("[id^=fa_delete_], [id^=far_delete_]").click(function(e){
        e.preventDefault();
        if (confirm("Are you sure?")){
            var obj = $(this);
            var arr = obj.attr("id").split("_");

            $.ajax({
                url: "/settings/delete_discount",
                method: "GET",
                dataType: "json",
                data: {elem: arr[0], inc: arr[2]},

                statusCode: {
                    401: function() {
                      alert( "Login expired. Please sign in again." );
                    }
                }
            }).done(function(data) {
                obj.parents("tr").remove();
            });
        }
    });
};

function removePdf(e){
   
    $path = $(e).attr("id");
     
     $.ajax({
                url: "/settings/delete_pdf",
                method: "GET",
                dataType: "text",
                data: {id:$path},

                statusCode: {
                    401: function() {
                      alert( "Login expired. Please sign in again." );
                    }
                }
            }).done(function(data) {
               
                if(data =="ok"){
                    $(e).prev().remove();
                    $(e).remove();
                }
            });
}