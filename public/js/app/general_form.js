var pendingReq, pendingFormReq;
var userMadeChanges = 0;
var baseUrl = $(".master_form").attr("action").replace("/save","");
$(document).ready(function(){

    // FA AUTOCOMPLETE
    if ($( "#fa_code" ).length > 0){
        $( "#fa_code" ).autocomplete({
            source: function( request, response ) {
              $.getJSON( baseUrl + "/search_fa", {
                term: request.term 
              }, response );
            },
            select: function( event, ui ) {
                //console.log(ui.item);
                $( "#fa_id" ).val( ui.item.id );
                $( "#fa_code" ).val( ui.item.generated_code );
                $( "#first_cp_title" ).val(ui.item.first_cp_title);
                $( "#first_cp_religion" ).val(ui.item.first_cp_religion);
                $( "#first_cp_email, #confirmed_by_email, #received_by_email" ).val( ui.item.first_cp_email );
                $( "#first_cp_nric, #confirmed_by_nric, #received_by_nric, #parlour_cp_nric" ).val( ui.item.first_cp_nric );
                $( "#first_cp_name, #confirmed_by_name, #received_by_name, #parlour_cp_name" ).val( ui.item.first_cp_name );
                $( "#first_cp_address" ).val( ui.item.first_cp_address );
                $( "#first_cp_mobile" ).val( ui.item.first_cp_mobile_nr );
                $( "#first_cp_postal_code" ).val( ui.item.first_cp_postal_code );
                $( "#first_cp_office" ).val( ui.item.first_cp_office_nr );
                $( "#first_cp_home" ).val( ui.item.first_cp_home_nr );

                $( "#second_cp_title" ).val(ui.item.second_cp_title);
                $( "#second_cp_nric" ).val( ui.item.second_cp_nric );
                $( "#second_cp_name" ).val( ui.item.second_cp_name );
                $( "#second_cp_address" ).val( ui.item.second_cp_address );
                $( "#second_cp_mobile" ).val( ui.item.second_cp_mobile_nr );
                $( "#second_cp_religion" ).val(ui.item.second_cp_religion);

                $( "#final_resting_place, #final_resting_place1, #final_resting_place2" ).val( ui.item.resting_place );
                $( "#deceased_title" ).val(ui.item.deceased_title);
                $( "#funeral_date" ).val( ui.item.funeral_date );
                $( "#deathdate" ).val( ui.item.deathdate );
                $( "#birthdate" ).val( ui.item.birthdate );
                $( "#dialect" ).val( ui.item.dialect );
                $( "[name=race]" ).val( ui.item.race );
                $( "[name=sex]" ).val( ui.item.sex );
                $( "#church" ).val( ui.item.church );
                $( "[name=religion]" ).val( ui.item.religion );
                $( "#deceased_name, #deceased_name_1, #parlour_deceased_name" ).val( ui.item.deceased_name );
                
                //columbarium data
                $( "#niche_location" ).val( ui.item.niche_location );
                $( "#slab_install" ).val( ui.item.slab_install );
                $( "#photo_install" ).val( ui.item.photo_install );
                $( "#type_of_install" ).val( ui.item.type_of_install );
                $( "#meet_family" ).val( ui.item.meet_family );
                $( "#remarks" ).val( ui.item.remarks );
                $( "#type_of_install" ).val( ui.item.type_of_install );
                $( "#niche_location" ).val( ui.item.niche_location );
                $( "#slab_install" ).val( ui.item.slab_install );
                $( "#meet_family" ).val( ui.item.meet_family );
                $( "#photo_install" ).val( ui.item.photo_install );

                return false;
            }
        }).autocomplete( "instance" )._renderItem = function( ul, item ) {
                return $( "<li>" )
                  .append( "<div>" + item.generated_code  + "</div>" )
                  .appendTo( ul );
            };
    }
    
    
    // FA AUTOCOMPLETE
    if ($( "#fa_op_code" ).length > 0){
        $( "#fa_op_code" ).autocomplete({
            source: function( request, response ) {
              $.getJSON( "/operations/search_fa", {
                term: request.term 
              }, response );
            },
            select: function( event, ui ) {
                //alert(ui);
                $( "#fa_op_id" ).val( ui.item.id );
                $( "#fa_op_code" ).val( ui.item.generated_code );
                
                $( "#first_cp_email, #confirmed_by_email, #received_by_email" ).val( ui.item.first_cp_email );
                $( "#first_cp_nric, #confirmed_by_nric, #received_by_nric" ).val( ui.item.first_cp_nric );
                $( "#first_cp_name, #confirmed_by_name, #received_by_name" ).val( ui.item.first_cp_name );
                $( "#first_cp_address" ).val( ui.item.first_cp_address );
                $( "#first_cp_mobile" ).val( ui.item.first_cp_mobile_nr );
                
                $( "#second_cp_nric" ).val( ui.item.second_cp_nric );
                $( "#second_cp_name" ).val( ui.item.second_cp_name );
                $( "#second_cp_address" ).val( ui.item.second_cp_address );
                $( "#second_cp_mobile" ).val( ui.item.second_cp_mobile_nr );
                
                $( "#final_resting_place, #final_resting_place1, #final_resting_place2" ).val( ui.item.resting_place );
                $( "#funeral_date" ).val( ui.item.funeral_date );
                $( "#deceased_dod" ).val( ui.item.deathdate );
                $( "#deceased_dob" ).val( ui.item.birthdate );
                $( "#deceased_dialects" ).val( ui.item.dialect );
                $( "#deceased_race" ).val( ui.item.race );
                $( "#deceased_sex" ).val( ui.item.sex );
                $( "#deceased_church" ).val( ui.item.church );
                $( "#deceased_religion" ).val( ui.item.religion );
                $( "#deceased_name" ).val( ui.item.deceased_name );
                
                //columbarium data
                $( "#niche_location" ).val( ui.item.niche_location );
                $( "#slab_install" ).val( ui.item.slab_install );
                $( "#photo_install" ).val( ui.item.photo_install );
                $( "#type_of_install" ).val( ui.item.type_of_install );
                $( "#meet_family" ).val( ui.item.meet_family );
                $( "#remarks" ).val( ui.item.remarks );
                $( "#type_of_install" ).val( ui.item.type_of_install );
                $( "niche_location" ).val( ui.item.niche_location );
                $( "slab_install" ).val( ui.item.slab_install );
                $( "meet_family" ).val( ui.item.meet_family );
                $( "photo_install" ).val( ui.item.photo_install );
                $( "#funeral_remarks" ).val( ui.item.final_remarks );
                
                //deceased details
                $.getJSON( '/operations/search_deceased_name' ,{deceased_name: ui.item.deceased_name}, function( responsedata ) {
                    $( "#shifting_hospital" ).val( responsedata[0].hospital );
                    $( "#shifting_remarks" ).val( responsedata[0].remarks );
                });
                
        
                $(".print").on('click', function() {
        
                    var mode = 'iframe'; // popup
                    var close = mode == "popup";
                    var options = { mode : mode, popClose : close};
                    $("div.printable").printArea( options );

                });
                return false;
            }
        }).autocomplete( "instance" )._renderItem = function( ul, item ) {
                return $( "<li>" )
                  .append( "<div>" + item.generated_code  + "</div>" )
                  .appendTo( ul );
            };
    }
    
    
    // DECEASED_NAME AUTOCOMPLETE
    if ($("#deceased_name").length > 0){
        
        $("#deceased_name")
          .autocomplete({
                source: function( request, response ) {
                  $.getJSON( baseUrl + "/search_deceased_name", {
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
        }
    
        // SIGNATURES 
        if ($('#signature1').length > 0){
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
        }

        
        
        // SUBMIT
        $("#submit_other_email_bttn").click(function(e){
            if ($("#bttn_clicked").length == 0){
                $(".master_form").prepend('<input type="hidden" name="bttn_clicked" id="bttn_clicked" value="" />');
            }
            $("#bttn_clicked").val("submit_other_email_bttn");

            var otherEmailPopup = ''+
                '<div class="modal fade" id="box_other_email" tabindex="-1" role="dialog">'+
                '    <div class="modal-dialog" role="document">'+
                '        <div class="modal-content">'+
                '            <div class="modal-header">'+
                '                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                '                <h4 class="modal-title" id="myModalLabel">E-mail address requested</h4>'+
                '            </div>'+
                '            <div class="modal-body">'+
                '                <div class="form-group">'+
                '                    <label class="control-label" for="inputWarning1">E-mail address</label>'+
                '                    <input type="text" id="popup_new_email" value="" class="form-control" />'+
                '                </div>'+
                '            </div>'+
                '            <div class="modal-footer">'+
                '                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                '                <button type="button" class="btn btn-primary" id="popup_send_bttn">SEND</button>'+
                '            </div>'+
                '        </div>'+
                '    </div>'+
                '</div>'    
                ;
            if ($("#box_other_email").length){
                
                $("body").append(otherEmailPopup);
                
                $("#popup_send_bttn").click(function(e){
                    if ($("#new_email").length == 0){
                        $(".master_form").prepend('<input type="hidden" name="new_email" id="new_email" value="" />');
                    }
                    $("#new_email").val($("#popup_new_email").val());
                    $("#popup_new_email").val("");
                    $('#box_other_email').modal('hide');
                    $(".master_form").submit();
                });
            }

            $('#box_other_email').modal('show');
 
            e.preventDefault();
        });
        
        $("#submit_bttn, #submit_email_bttn, #submit_print_bttn").click(function(e){

            var bttn_clicked_txt = $(this).attr("id");
            var initialText = $(this).val();
            var bttn = $(this);
            
            if ($("#bttn_clicked").length == 0){
                $(".master_form").prepend('<input type="hidden" name="bttn_clicked" id="bttn_clicked" value="" />');
            }

            $("#bttn_clicked").val(bttn_clicked_txt);

            // SAVE FORM DATA
            $(".master_form").submit();

        });
        
      
        // POPUP ACTIONS
        $(".cancel_bttn").click(function(){
            $("#save_msg").modal("hide");
        });

        // DATEPICKER
        $('.datepicker_day_format').datepicker({
		
            singleDatePicker: true,
            timePicker: false,
            changeMonth: true,
            changeYear: true,
            format: 'dd/mm/yyyy'
        });
        
        
        
        // CHECK FOR CHANGES
        $(".master_form input, .master_form select, .master_form textarea").focus(function(){
            var initialValue = $(this).val();
            $(this).blur(function(){
                if ($(this).val() != initialValue){
                    userMadeChanges = 1; 
                }
            });
        });
        
        // CHECK ON EXIT
        if ($(".needs_exit_warning").length > 0){
            $("[role=navigation] a, [role=search] button, #sidebar-menu a").click(function(e){
                var elem = $(this);
                var doCheck = false;
                var isLink = false;
                if (elem.attr("href") && elem.attr("href").indexOf("#") < 0){
                    doCheck = true;
                    isLink = true;
                }
                if(elem.is("button") ){
                    doCheck = true;
                }
                if (doCheck && userMadeChanges || doCheck && $("#is_draft").val() == 1){
                    
                    var confirmPopup = ''+
                        '<div class="modal fade" id="form_changed_confirm_exit" tabindex="-1" role="dialog">'+
                        '    <div class="modal-dialog" role="document">'+
                        '        <div class="modal-content">'+
                        '            <div class="modal-header">'+
                        '                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '                <h4 class="modal-title" id="myModalLabel">WARNING</h4>'+
                        '            </div>'+
                        '            <div class="modal-body">'+
                        '                <div class="form-group">'+
                        '                    Your latest edit will not be saved if you exit without submitting. Do you still wish to exit?'+
                        '                </div>'+
                        '            </div>'+
                        '            <div class="modal-footer">'+
                        '                <button type="button" class="btn btn-default cancel_bttn">Exit without saving</button>'+
                        '                <button type="button" class="btn btn-primary save_bttn">Submit changes</button>'+
                        '            </div>'+
                        '        </div>'+
                        '    </div>'+
                        '</div>';
                
                    if ($("#form_changed_confirm_exit").length == 0){
                        $("body").append(confirmPopup);
                    }
                    
                    $("#form_changed_confirm_exit").modal("show");
                    $("#form_changed_confirm_exit .cancel_bttn").click(function(){
                        if ($("#is_draft").val() == 1){
                            $.ajax({
                                url: baseUrl + '/delete_current',
                                method: 'post',
                                data: {_token: $("[name=_token]").val()},
                                complete: function(){
                                    if (isLink){
                                        window.location = elem.attr("href");
                                    }
                                    else if($(this).is("button") ){
                                        elem.parents("form").submit();
                                    }
                                }
                            });
                        }
                        else{
                            if (isLink){
                                window.location = elem.attr("href");
                            }
                            else if($(this).is("button") ){
                                elem.parents("form").submit();
                            }
                        }
                        $("#form_changed_confirm_exit").modal("hide");
                    });

                    $("#form_changed_confirm_exit .save_bttn").click(function(){
                        $(".master_form").submit();
                        //$("#form_changed_confirm_exit").modal("hide");
                    });
                    
                }
                else{
                    if (isLink){
                        window.location = elem.attr("href");
                    }
                    else if($(this).is("button") ){
                        elem.parents("form").submit();
                    }
                }
                
                e.preventDefault();

            });
        }

        // SEE IF WE HAVE TO DO SOME ACTIONS AFTER SUBMIT
        if ( typeof saveMessage != "undefined"){
            if (typeof openPdf != "undefined" && openPdf == true){
                if ($("#order_id").length > 0){
                    var win = window.open( baseUrl + '/pdf/' + $("#order_id").val() , '_blank');
                }
                else{
                    var win = window.open( baseUrl + '/pdf/' + $("#form_id").val() , '_blank');
                }
                win.focus();
            }
            
            showMessage(saveMessage);   
        }
        
        
        
        // AUTOSAVE
        if ($("#is_draft").val() == "1"){
            setInterval(autoSaveForm, 10000);
        }
});

function showMessage( text ){
    var msgPopup =  '<div class="modal fade" id="save_msg" tabindex="-1" role="dialog">'+
                    '    <div class="modal-dialog" role="document">'+
                    '        <div class="modal-content">'+
                    '            <div class="modal-header">'+
                    '                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '                <h4 class="modal-title" id="myModalLabel">Status</h4>'+
                    '            </div>'+
                    '            <div class="modal-body">'+
                    '                <div class="form-group" id="message_container">'+
                    '                </div>'+
                    '            </div>'+
                    '            <div class="modal-footer">'+
                    '            </div>'+
                    '        </div>'+
                    '    </div>'
                    '</div>';
                    
    if ($("#save_msg").length == 0){
        $("body").append(msgPopup);
    }
    $('#save_msg #message_container').html(text);
    $('#save_msg').modal('show');
}

function autoSaveForm(){
    
    if ( userMadeChanges ) {
        
        var form = $( ".master_form" );
        
        if (pendingFormReq) { 
            pendingFormReq.abort();
        }
        pendingFormReq = $.ajax({
            url: baseUrl + '/save',
            method: 'post',
            data: form.serialize(),
            complete: function(){ 
                pendingFormReq = null;
                //userMadeChanges = false;
                if ($("#autosave_msg").length > 0){
                    var parts = $(this).val().split("/");
                    var d = new Date(parts[2]+ "-" + parts[1]+ "-" + parts[0]);
                    var dObj = new Date();
                    var d = dObj.Date();
                    var m = dObj.Date();
                    var h = dObj.Date();
                    var min = dObj.Date();
                    var s = dObj.Date();
                    $("#autosave_msg").html(((d < 10)?"0":"")+ d +"/" + ((m < 10)?"0":"")+ m + "/" + dObj.getFullYear()+ " "+ ((h < 10)?"0":"")+ h+ " "+ ((min < 10)?"0":"")+ min+ ":"+ ((s < 10)?"0":"")+ s);
                }
            }
        });
    }
}
/////////////////////

	$(".input_container #birthdate").datepicker({
			startView:2,
		
            singleDatePicker: true,
            timePicker: false,
            changeMonth: true,
            changeYear: true,
            format: 'dd/mm/yyyy',
			
			
        }).on("changeDate",function(date){
			    
			var date2 = $(this).datepicker('getDate');
            date2.setDate(date2.getDate() + 1);
			$(".input_container #deathdate").datepicker('setStartDate',date2).focus();
			$(this).datepicker("hide");
			
			});
			
$(".input_container #deathdate").datepicker({
	startView:2,
		
            singleDatePicker: true,
            timePicker: false,
            changeMonth: true,
            changeYear: true,
            format: 'dd/mm/yyyy',
}).on("changeDate",function(date){
	$(this).datepicker("hide");
})	
