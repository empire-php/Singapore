$(document).ready(function(){

    $(".parlour_form").find(".item2select").click(function(){
   
        if (!$(this).hasClass("not_available")){

            $(".parlour_form").find(".item2select").removeClass("selected_item");
            $(this).addClass("selected_item");

            $(".parlour_form").find("#parlour_name").val($(this).find(".parlour_name_container").text().trim());
            $(".parlour_form").find("#parlour_selection_container").text($(".parlour_form").find(this).find(".parlour_name_container").text().trim());

            $(".parlour_form").find("#unit_price").val($(this).find(".unit_price").text().trim());
            $(".parlour_form").find("#unit_price_container").text("$"+$(this).find(".unit_price").text().trim());
            
            $(".parlour_form").find("#capacity").val($(".parlour_form").find("#capacity_filter").val());

            $(".parlour_form").find("#parlour_id").val($(this).attr("id").replace("item_",""));
            $(".parlour_form").find("#booked_from_day").val("");
            $(".parlour_form").find("#booked_to_day").val("");
            $(".parlour_form").find("#total_price").val("");
            $(".parlour_form").find("#total_price_span").text("");
			///////////////////// get all images//
			$id = $(this).attr("id");
			$changedId = $id.replace("item_","");
			
			 $.ajax({
            url: "/parlour/get_all_images",
            method: "GET",
            dataType: "json",
            data: {id:$changedId},
        
            statusCode: {
                401: function() {
                  alert( "Login expired. Please sign in again." );
                }
            }
        }).done(function(data) {
			$htmls="";
			if(data != ""){
			for($i=0;$i<data.length;$i++){
				$htmls += "<img src='uploads/"+data[$i]+"' width=300 style='margin:10px 10px 10px 10px'/>";
			}
			}else{
				$htmls = "No preview images";
			}
			$("#view_all_images .modal-body").html($htmls);
			$("#view_all_images").modal("show");
		})
        }
    });
    
    $(".parlour_form").find("#capacity_filter").keyup(function(){
        var selCapacity = parseInt($(this).val());
        $(".parlour_form").find(".item2select .parlour_capacity_container").each(function(){
            if (selCapacity > parseInt($(this).text().trim())){
                $(this).parents(".item2select").addClass("not_available").css("cursor","default");
                $(this).parents(".item2select").find(".item_btn").html("NOT AVAILABLE").css("color","red");
                $(this).parents(".item2select").find(".img_container").css("opacity","0.5");
                $(this).parents(".item2select").find(".item_text").css("opacity","0.5");
            }
            else{
                $(this).parents(".item2select").removeClass("not_available").css("cursor","pointer");
                $(this).parents(".item2select").find(".item_btn").html("SELECT").css("color","black");
                $(this).parents(".item2select").find(".img_container").css("opacity","1");
                $(this).parents(".item2select").find(".item_text").css("opacity","1");
            }
        });
    });
    
    
    
    
    $(".parlour_form").find('#booked_from_day')
    .datepicker({
        singleDatePicker: true,
        timePicker: false,
        changeMonth: true,
        changeYear: true,
        format: 'dd/mm/yyyy',
        defaultDate:null
    });
  
    var myDatePicker = $(".parlour_form").find('#booked_to_day')
    .datepicker({
        singleDatePicker: true,
        timePicker: false,
        changeMonth: true,
        changeYear: true,
        format: 'dd/mm/yyyy',
        defaultDate:null

    });
   
    
    $(".filter_zone").find('#filter_booked_from_day, #filter_booked_to_day')
    .datepicker({
        singleDatePicker: true,
        timePicker: false,
        changeMonth: true,
        changeYear: true,
        format: 'dd/mm/yyyy',
        defaultDate:null

    });
    
    
   if ($(".parlour_form").find("#order_id").val()){
       $.getJSON( "/parlour/booked_hours",{booked_from_day: $(".parlour_form").find("#booked_from_day").val(), booked_to_day: $(".parlour_form").find("#booked_to_day").val(), parlour_id: $(".parlour_form").find("#parlour_id").val(), order_id: $(".parlour_form").find("#order_id").val()}, function( data ) {
            $(".parlour_form").find("#booked_from_time, #booked_to_time").find("option").removeAttr("disabled").css("color","black");
            
            $.each( data.start, function( key, val ) {
                $(".parlour_form").find("#booked_from_time").find("option[value='"+ val +"']").attr("disabled","disabled").css("color","red");
            });
            $.each( data.end, function( key, val ) {
                $(".parlour_form").find("#booked_to_time").find("option[value='"+ val +"']").attr("disabled","disabled").css("color","red");
            });
        });
   }

    $(".parlour_form").find("#booked_from_day").on("change", function (e) {
        $(".parlour_form").find("#booked_to_day").val("");
        myDatePicker.datepicker('setStartDate', $(".parlour_form").find("#booked_from_day").val());
        $.getJSON( "/parlour/end_date",{booked_from_day: $(".parlour_form").find("#booked_from_day").val(), parlour_id: $(".parlour_form").find("#parlour_id").val(), order_id: $(".parlour_form").find("#order_id").val()}, function( data ) {
//  for point xx          if (data.booked_to_day){
//                alert(data.booked_to_day);
//                myDatePicker.datepicker('setEndDate', data.booked_to_day);
//            }
        });
    });
    
    $(".parlour_form").find("#booked_to_day").on("change", function (e) {
        if ($(this).val() != ""){
            $.getJSON( "/parlour/booked_hours",{booked_from_day: $(".parlour_form").find("#booked_from_day").val(), booked_to_day: $(".parlour_form").find("#booked_to_day").val(), parlour_id: $(".parlour_form").find("#parlour_id").val(), order_id: $(".parlour_form").find("#order_id").val()}, function( data ) {
                $(".parlour_form").find("#booked_from_time, #booked_to_time").find("option").removeAttr("disabled").css("color","black");

                $.each( data.start, function( key, val ) {
                    $(".parlour_form").find("#booked_from_time").find("option[value='"+ val +"']").attr("disabled","disabled").css("color","red");
                });
                var lastVal = "";
                $.each( data.end, function( key, val ) {
                    $(".parlour_form").find("#booked_to_time").find("option[value='"+ val +"']").attr("disabled","disabled").css("color","red");
                    lastVal = val;
                });

                $(".parlour_form").find("#booked_to_time").find("option").show();
                if ($(".parlour_form").find("#booked_from_day").val() != $(".parlour_form").find("#booked_to_day").val() && lastVal != ""){
                    var foundFirst = false;
                    $(".parlour_form").find("#booked_to_time").find("option").each(function(){
                        if ($(this).val() == lastVal){
                            foundFirst = true;
                        }
                        else if (foundFirst){
                            $(this).hide();
                        }
                    });
                }
                $(".parlour_form").find('.selectpicker').selectpicker('refresh');
            });
        }
    });
    
    if ($(".parlour_form").find("#booked_to_day").val() != ""){
        $.getJSON( "/parlour/booked_hours",{booked_from_day: $(".parlour_form").find("#booked_from_day").val(), booked_to_day: $(".parlour_form").find("#booked_to_day").val(), parlour_id: $(".parlour_form").find("#parlour_id").val(), order_id: $(".parlour_form").find("#order_id").val()}, function( data ) {
            $(".parlour_form").find("#booked_from_time, #booked_to_time").find("option").removeAttr("disabled").css("color","black");

            $.each( data.start, function( key, val ) {
                $(".parlour_form").find("#booked_from_time").find("option[value='"+ val +"']").attr("disabled","disabled").css("color","red");
            });
            var lastVal = "";
            $.each( data.end, function( key, val ) {
                $(".parlour_form").find("#booked_to_time").find("option[value='"+ val +"']").attr("disabled","disabled").css("color","red");
                lastVal = val;
            });

            $(".parlour_form").find('.selectpicker').selectpicker('refresh');
        });
    }
    
    
    var initialTo, initialFrom = "";
    $(".parlour_form").find("#booked_from_day").focus(function(){
        initialFrom = $(this).val();
    });
    $(".parlour_form").find("#booked_from_day").change(function(){
        if (initialFrom != $(this).val()){
            $(".parlour_form").find("#booked_from_time, #booked_to_time").val("");
        }
    });
    $(".parlour_form").find("#booked_to_day").focus(function(){
        initialTo = $(this).val();
    });
    $(".parlour_form").find("#booked_to_day").change(function(){
        if (initialTo != $(this).val()){
            $(".parlour_form").find("#booked_from_time, #booked_to_time").val("");
        }
    });
    
    $(".parlour_form").find("#booked_from_time, #booked_to_time").change(function(){

        if ($("#booked_from_time").val() && $("#booked_to_time").val() && $("#booked_from_day").val() && $("#booked_to_day").val() && $("#unit_price").val()){
            
            var arrDayFrom = $(".parlour_form").find("#booked_from_day").val().split("/");
            var arrTimeFrom = $(".parlour_form").find("#booked_from_time").val().split(":");
            var arrDayTo = $(".parlour_form").find("#booked_to_day").val().split("/");
            var arrTimeTo = $(".parlour_form").find("#booked_to_time").val().split(":");
            var dFrom = new Date(arrDayFrom[2], arrDayFrom[1], arrDayFrom[0], arrTimeFrom[0], arrTimeFrom[1], 0,0);
            var dTo = new Date(arrDayTo[2], arrDayTo[1], arrDayTo[0], arrTimeTo[0], arrTimeTo[1], 0,0);
            var diff = (dTo.getTime() - dFrom.getTime())/(3600*1000);

            var total = (diff * parseFloat($("#unit_price").val()));
            $(".parlour_form").find("#total_price").val(total.toFixed(2));
            $(".parlour_form").find("#total_price_span").text("$"+total.toFixed(2));
            $(".parlour_form").find("#hours").val( diff );
        }
    });

    /* Dashboard Parlour listing */
    var table = $('#dblisting_tbl').on( 'order.dt',  function () { 
        $('#dblisting_tbl').find("tr").each(function(){
            var nrTD = 0;
            $(this).find("td, th").each(function(){
                //console.log(nrTD);
                if (nrTD == 3 || nrTD == 5 || nrTD == 7 || nrTD == 9){
                    $(this).hide();
                }
                nrTD++;
            });
        });
    } ).DataTable( {
        'ajax': {
            'url' : 'parlour/dblisting',
            'dataSrc' : function (json) {
            //console.log(json.data);
            return json.data;
            }
            
        }
        
    } );


    
    var table = $('#listing_tbl').on( 'draw.dt',  function () {
        $('#listing_tbl').find("tr").each(function(){
           // console.log('DATATABLES');
            var nrTD = 0;
            $(this).find("th, td").each(function(){
                //console.log(nrTD);
                if (nrTD == 3 || nrTD == 5 || nrTD == 7 || nrTD == 9){
                    $(this).hide();
                }
                nrTD++;
            });
        });
    } ).DataTable( {
        ajax: 'parlour/listing',
        bFilter: false,
        order: [[ 0, "asc" ]],
            "aoColumnDefs": [
                { "iDataSort": 3, "aTargets": [ 2 ] },
                { "iDataSort": 5, "aTargets": [ 4 ] },
                { "iDataSort": 7, "aTargets": [ 6 ] },
                { "iDataSort": 9, "aTargets": [ 8 ] }
            ]
    } );
    
    $('#filter_bttn').click(function(){
        table.ajax.url( 'parlour/listing?'+$(this).parents("form").serialize() ).load();
    });
    
    /* Dashboard Parlour Filter form listing */
    $('#db_filter_bttn').click(function(){
        table.ajax.url( 'parlour/dblisting?'+$(this).parents("form").serialize() ).load();
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
