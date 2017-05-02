$(document).ready(function(){
        
    $.ajax({
        method: "GET",
        url: "/embalming/timelog/today"
    })
    .done(function( data ) {
        $("#tbl_header").after( data );
    });
    
    $('#start_value, #end_value').datepicker({
        singleDatePicker: true,
        timePicker: false,
        changeMonth: true,
        changeYear: true,
        format: 'dd/mm/yyyy'
    });
    
    $("#timelog_container").find("#get_logs_bttn").on("click",function(){
        
        $.ajax({
            method: "GET",
            url: "/embalming/timelog/logs",
            data: {search: $("#search_term").val(), start: $("#start_value").val(), end: $("#end_value").val()}
        })
        .done(function( data ) {
            $(".search_added_tr").remove();
            $("#filter_section").after( data );          
        });
    });
    
    $(".update_button").click(function(){
        $("#search_term").val("");
        $("#start_value").val("");
        $("#end_value").val("");
        

        if ($("#selected_shifting_id").val() == ""){
            $("#save_msg #message_container").html("Please select decease name");
            $("#save_msg").modal("show");
        }
        else if (( $(this).attr("id") == "check_clothing" || 
                   $(this).attr("id") == "check_photo" || 
                   $(this).attr("id") == "check_bs" ||
                   $(this).attr("id") == "check_br"
                  ) 
                  && 
                  (
                    ($("#embalmer_users").val() == "" || $("#embalmer_users").val() == null) 
                    && 
                    ($("#other_staff_users").val() == "" || $("#other_staff_users").val() == null)
                  )
                ){
            $("#save_msg #message_container").html("Please select an embalmer or someone from other staff");
            $("#save_msg").modal("show");
        }
        else{
            var bttnAction = $(this).attr("id");
            $.ajax({
                method: "GET",
                url: "/embalming/timelog/today",
                data: {action: bttnAction, sid: $("#selected_shifting_id").val(), other_staff_users: $("#other_staff_users").val(), embalmer_users: $("#embalmer_users").val()}  
            })
            .done(function( data ) {
                $(".added_tr").remove();
                $("#tbl_header").after( data );
            });
        }
    });
});