$(document).ready(function(){
    
    $(".hearse_form").find(".item2select").click(function(){
        $(".hearse_form").find(".item2select").removeClass("selected_item");
        $(this).addClass("selected_item");

        $(".hearse_form").find("#hearse_name").val($(".hearse_form").find(this).find(".hearse_name_container").text().trim());
        $(".hearse_form").find("#hearse_selection_container").text($(this).find(".hearse_name_container").text().trim());
        
        $(".hearse_form").find("#unit_price").val($(this).find(".unit_price").text().trim());
        $(".hearse_form").find("#unit_price_container").text("$"+$(this).find(".unit_price").text().trim());
        
        var str = $(this).attr("id");
        
        $(".hearse_form").find("#hearse_id").val(str.replace("item_",""));
        $(".hearse_form").find("#booked_day").val("");
        $(".hearse_form").find("#total_price").val("");
        $(".hearse_form").find("#total_price_span").text("");
    });

    
    
    $(".hearse_form").find('#booked_from_day')
    .datepicker({
        singleDatePicker: true,
        timePicker: false,
        changeMonth: true,
        changeYear: true,
        format: 'dd/mm/yyyy'
    });
  
    var myDatePicker = $(".hearse_form").find('#booked_to_day')
    .datepicker({
        singleDatePicker: true,
        timePicker: false,
        changeMonth: true,
        changeYear: true,
        format: 'dd/mm/yyyy'

    });
     
    
    $(".filter_zone").find('#filter_booked_from_day, #filter_booked_to_day')
    .datepicker({
        singleDatePicker: true,
        timePicker: false,
        changeMonth: true,
        changeYear: true,
        format: 'dd/mm/yyyy'

    });
    
    

    
    
    if ($(".hearse_form").find("#order_id").val()){
        $.getJSON( "/hearse/booked_hours",{booked_from_day: $(".hearse_form").find("#booked_from_day").val(), booked_to_day: $(".hearse_form").find("#booked_to_day").val(),  hearse_id: $(".hearse_form").find("#hearse_id").val(), order_id: $(".hearse_form").find("#order_id").val()}, function( data ) {
            $(".hearse_form").find("#booked_from_time, #booked_to_time").find("option").removeAttr("disabled").css("color","black");
            
            $.each( data.start, function( key, val ) {
                $(".hearse_form").find("#booked_from_time").find("option[value='"+ val +"']").attr("disabled","disabled").css("color","red");
            });
            $.each( data.end, function( key, val ) {
                $(".hearse_form").find("#booked_to_time").find("option[value='"+ val +"']").attr("disabled","disabled").css("color","red");
            });
        });
    }
    
    
    /*
    $(".hearse_form").find("#booked_from_day").on("change", function (e) {
        $(".hearse_form").find("#booked_to_day").val("");
        myDatePicker.datepicker('setStartDate', $(".hearse_form").find("#booked_from_day").val());
        $.getJSON( "/hearse/end_date",{booked_from_day: $(".hearse_form").find("#booked_from_day").val(), hearse_id: $(".hearse_form").find("#hearse_id").val(), order_id: $(".hearse_form").find("#order_id").val()}, function( data ) {     
            if (data.booked_to_day){                
                myDatePicker.datepicker('setEndDate', data.booked_to_day);
            }
        });
    });
    */
   
    $(".hearse_form").find("#booked_from_day").on("change", function (e) {
        
        if ($(this).val() != ""){
            $.getJSON( "/hearse/booked_hours",{booked_from_day: $(".hearse_form").find("#booked_from_day").val(), booked_to_day: $(".hearse_form").find("#booked_from_day").val(), hearse_id: $(".hearse_form").find("#hearse_id").val(), order_id: $(".hearse_form").find("#order_id").val()}, function( data ) {
                $(".hearse_form").find("#booked_from_time, #booked_to_time").find("option").removeAttr("disabled").css("color","black");

                $.each( data.start, function( key, val ) {
                    $(".hearse_form").find("#booked_from_time").find("option[value='"+ val +"']").attr("disabled","disabled").css("color","red");
                });
                var lastVal = "";
                $.each( data.end, function( key, val ) {
                    $(".hearse_form").find("#booked_to_time").find("option[value='"+ val +"']").attr("disabled","disabled").css("color","red");
                    lastVal = val;
                });
                
                $(".hearse_form").find("#booked_to_time").find("option").show();
                if ($(".hearse_form").find("#booked_from_day").val() != $(".hearse_form").find("#booked_from_day").val() && lastVal != ""){
                    var foundFirst = false;
                     $(".hearse_form").find("#booked_to_time").find("option").each(function(){
                        if ($(this).val() == lastVal){
                            foundFirst = true;
                        }
                        else if (foundFirst){
                            $(this).hide();
                        }
                    });
                }
                $(".hearse_form").find('.selectpicker').selectpicker('refresh');
                
            });
        }
    });
    
    
    if ($(this).val() != ""){
        $.getJSON( "/hearse/booked_hours",{booked_from_day: $(".hearse_form").find("#booked_from_day").val(), booked_to_day: $(".hearse_form").find("#booked_to_day").val(), hearse_id: $(".hearse_form").find("#hearse_id").val(), order_id: $(".hearse_form").find("#order_id").val()}, function( data ) {
            $(".hearse_form").find("#booked_from_time, #booked_to_time").find("option").removeAttr("disabled").css("color","black");

            $.each( data.start, function( key, val ) {
                $(".hearse_form").find("#booked_from_time").find("option[value='"+ val +"']").attr("disabled","disabled").css("color","red");
            });
            var lastVal = "";
            $.each( data.end, function( key, val ) {
                $(".hearse_form").find("#booked_to_time").find("option[value='"+ val +"']").attr("disabled","disabled").css("color","red");
                lastVal = val;
            });

            $(".hearse_form").find('.selectpicker').selectpicker('refresh');

        });
    }
    
    
    
    var initialTo, initialFrom = "";
    $(".hearse_form").find("#booked_from_day").focus(function(){
        initialFrom = $(this).val();
    });
    $(".hearse_form").find("#booked_from_day").change(function(){
        if (initialFrom != $(this).val()){
            $(".hearse_form").find("#booked_from_time, #booked_to_time").val("");
        }
    });
    $(".hearse_form").find("#booked_to_day").focus(function(){
        initialTo = $(this).val();
    });
    $(".hearse_form").find("#booked_to_day").change(function(){
        if (initialTo != $(this).val()){
            $(".hearse_form").find("#booked_from_time, #booked_to_time").val("");
        }
    });
    /*$("#booked_from_day, #booked_to_day").change(function(){
        $("#booked_from_time, #booked_to_time").val("");
    });*/
    
    $(".hearse_form").find("#booked_from_time").change(function(){
        if ($(".hearse_form").find("#booked_from_day").val() == $(".hearse_form").find("#booked_to_day").val()){
            $(".hearse_form").find("#booked_to_time").find("option").show();
            var found = false;
            var sVal = $(this).val();
            $(".hearse_form").find("#booked_to_time").find("option").each(function(){

                if ($(this).val() == sVal){
                    found = true;
                    $(this).hide();
                }
                if (!found){
                    $(this).hide();
                }

            });
            $(".hearse_form").find('.selectpicker').selectpicker('refresh');
        }
    });
    
    $(".hearse_form").find("#booked_from_time, #booked_to_time").change(function(){
        if ($(".hearse_form").find("#booked_from_time").val() && $(".hearse_form").find("#booked_to_time").val() && $(".hearse_form").find("#booked_from_day").val() && $(".hearse_form").find("#booked_from_day").val() && $(".hearse_form").find("#unit_price").val()){
            
            var arrDayFrom = $(".hearse_form").find("#booked_from_day").val().split("/");
            var arrTimeFrom = $(".hearse_form").find("#booked_from_time").val().split(":");
            var arrDayTo = $(".hearse_form").find("#booked_from_day").val().split("/");
            var arrTimeTo = $(".hearse_form").find("#booked_to_time").val().split(":");
            var dFrom = new Date(arrDayFrom[2], arrDayFrom[1], arrDayFrom[0], arrTimeFrom[0], arrTimeFrom[1], 0,0);
            var dTo = new Date(arrDayTo[2], arrDayTo[1], arrDayTo[0], arrTimeTo[0], arrTimeTo[1], 0,0);
            var diff = (dTo.getTime() - dFrom.getTime())/(3600*1000);           
            
            var total = (diff * parseFloat($(".hearse_form").find("#unit_price").val()));
            $(".hearse_form").find("#total_price").val(total.toFixed(2));
            $(".hearse_form").find("#total_price_span").text("$"+total.toFixed(2));
            $(".hearse_form").find("#hours").val( diff );
        }
    });
    
    /* Dashboard Hearses listing */
    var table = $('#dbhearslisting_tbl').on( 'order.dt',  function () { 
        $('#dbhearslisting_tbl').find("tr").each(function(){
            var nrTD = 0;
            $(this).find("td, th").each(function(){
                //console.log(nrTD);
                if (nrTD == 2 ||  nrTD == 4 || nrTD == 6 || nrTD == 8){
                    $(this).hide();
                }
                nrTD++;
            });
        });
    } ).DataTable( {
        'ajax': {
            'url' : 'hearse/dblisting',
            'dataSrc' : function (json) {
            //console.log(json.data);
            return json.data;
            }   
        }
           
    } );
    
    var table = $('#listing_tbl').on( 'order.dt',  function () { 
        $('#listing_tbl').find("tr").each(function(){
            var nrTD = 0;
            $(this).find("td, th").each(function(){
                //console.log(nrTD);
                if (nrTD == 2 || nrTD == 3 ||  nrTD == 4 || nrTD == 6 || nrTD == 8){
                    $(this).hide();
                }
                nrTD++;
            });
        });
    } ).DataTable( {
        ajax: 'hearse/listing',
        bFilter: false,
        order: [[ 0, "asc" ]],
            "aoColumnDefs": [
                { "iDataSort": 2, "aTargets": [ 1 ] },
                { "iDataSort": 4, "aTargets": [ 3 ] },
                { "iDataSort": 6, "aTargets": [ 5 ] },
                { "iDataSort": 8, "aTargets": [ 7 ] }
            ]
    } );
        
    
    $('#filter_bttn').click(function(){
        table.ajax.url( 'hearse/listing?'+$(this).parents("form").serialize() ).load();
    });
    
    /* Dashboard Hearses Filter form listing */
    $('#hearsesfilter_bttn').click(function(){
        table.ajax.url( 'hearse/dblisting?'+$(this).parents("form").serialize() ).load();
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

