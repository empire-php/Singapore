$(document).ready(function(){

    $("#shiftingDetails").find('#shifting_date_left, #shifting_date_return, #sending_date_left, #sending_date_return')
    .datepicker({
        singleDatePicker: true,
        timePicker: false,
        changeMonth: true,
        changeYear: true,
        format: 'dd/mm/yyyy'

    });
    
    $("#sendingDetails").find('#sending_date_left, #sending_date_return')
    .datepicker({
        singleDatePicker: true,
        timePicker: false,
        changeMonth: true,
        changeYear: true,
        format: 'dd/mm/yyyy'

    });
});
