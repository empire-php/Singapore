@extends('layouts.app')

@section('content')

<div class="page-header">
    <h3>Duty Roster</h3>
</div>

@if(!isset($is_view))
<form action="/duty/savedutyroster" method="post"  id="info_frm" enctype="multipart/form-data" class="master_form">
{!! csrf_field() !!}
<input type="hidden" id="token" value="{{ csrf_token() }}">
<div class="section" style="width:150%">   
    <div id="calendar_div">
        <div id="calender_section">            
            <h2 style="text-align:center; margin-left:-1411px">
        	<a href="javascript:void(0);" onclick="getCalendar('calendar_div','<?php echo date("Y",strtotime($date.' - 1 Month')); ?>','<?php echo date("m",strtotime($date.' - 1 Month')); ?>');">&lt;&lt;</a>
                {{ App::make("App\Http\Controllers\DutyrosterController")->getAllMonths($dateMonth) }}
                {{ App::make("App\Http\Controllers\DutyrosterController")->getYearList($dateYear) }}
                <input type="hidden" name="month_number" value="{{ $dateMonth }}" />
                <input type="hidden" name="year_number" value="{{ $dateYear }}" />
                <a href="javascript:void(0);" onclick="getCalendar('calendar_div','<?php echo date("Y",strtotime($date.' + 1 Month')); ?>','<?php echo date("m",strtotime($date.' + 1 Month')); ?>');">&gt;&gt;</a>
                <img style="display:none" src="/images/loading.gif" id="loadingimg" />
            </h2>
            <div id="event_list" class="none"></div>
            <table style="background-color: #FFF;" id="calender_section_top" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover">
                <tr>
                    <td rowspan="2" colspan="2">&nbsp;</td>
                    <?php 
                    $dayCount = 1; 
                    for($cb=1;$cb<=$boxDisplay;$cb++){
                        if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                            $currentDate = $dateYear.'-'.$dateMonth.'-'.$dayCount;

                            $timestamp = strtotime($currentDate);

                            $day = date('D', $timestamp);
                            echo "<td style='background:#FFFF02;'>".$day."</td>";
                            $dayCount++;
                        }
                    }
                    ?>
                </tr>
                <tr>
                    <?php 
                    $dayCount = 1; 
                    for($cb=1;$cb<=$boxDisplay;$cb++){
                        if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                            //Current date
                            $currentDate = $dateYear.'-'.$dateMonth.'-'.$dayCount;

                            $timestamp = strtotime($currentDate);

                            $day = date('D', $timestamp);
                            //var_dump($day);
                            //die();
                            $eventNum = 0;
                            //Include db configuration file
                            //include 'dbConfig.php';
                            //Get number of events based on the current date
                            
                            //Define date cell color
                            if(strtotime($currentDate) == strtotime(date("Y-m-d"))){
                                    echo '<td style="background:#FFFF02" date="'.$currentDate.'" class="grey date_cell">';
                            }else{
                                    echo '<td style="background:#FFFF02" date="'.$currentDate.'" class="date_cell">';
                            }
                            //Date cell
                            echo '<span>';
                            echo $dayCount;
                            echo '</span>';
                            echo '</td>';
                            $dayCount++;
                        }
                    } ?>
                </tr>
                <?php 
                $dayCount = 1; 
                $calendarrow = 0;
                $firstselectArr = array();
                $monthDataValArr = array();
                for($rw=1,$ui=0;$rw<=6;$rw++,$ui++){
                    $firstselectArr = array();
                    if( isset($monthDataVal[$calendarrow]) ){
                        $monthDataValArr = (array) $monthDataVal[$calendarrow];
                        $firstselectArr = explode(",",$monthDataValArr['column_2']);     
                    }
                    echo "<tr>
                            <td>".$rosterdata[$ui]->team_name."</td>
                            <td><span style='color:#f00;'>".$rosterdata[$ui]->team_leader."</span> <span style='color:#0000ff;'>".$rosterdata[$ui]->embalmers."</span> <span style='color:#000;'>".$rosterdata[$ui]->others."</td>";

                            $dayCount = 1; 
                            for($cb=1;$cb<=$boxDisplay;$cb++){
                                $styleinputDates = "";
                                if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                                    if( isset($monthDataValArr['date_column_'.$dayCount]) && $monthDataValArr['date_column_'.$dayCount] == "D" ){
                                        $styleinputDates = "text-align : center; color : #2379C0; font-weight : 700";
                                    } else if( isset($monthDataValArr['date_column_'.$dayCount]) && $monthDataValArr['date_column_'.$dayCount] == "B" ){
                                        $styleinputDates = "text-align : center; color : #7034A2; font-weight : 700";
                                    } else if( isset($monthDataValArr['date_column_'.$dayCount]) && $monthDataValArr['date_column_'.$dayCount] == "A" ){
                                        $styleinputDates = "text-align : center; color : #080806; font-weight : 700";
                                    } else if( isset($monthDataValArr['date_column_'.$dayCount]) && $monthDataValArr['date_column_'.$dayCount] == "N" ){
                                        $styleinputDates = "text-align : center; color : #FE0735; font-weight : 800; font-size : 11px";
                                    } else if( isset($monthDataValArr['date_column_'.$dayCount]) && $monthDataValArr['date_column_'.$dayCount] == "OFF" ){
                                        $styleinputDates = "text-align : center; color : #54B65A; font-weight : 800; font-size : 11px; width: 52px";
                                    }
                                    echo "<td><input style=\"".$styleinputDates."\" class=\"form-control charvalidate\" type=\"text\" name=\"month_dates_".$rw."_".$dayCount."\" id=\"month_dates_".$rw."_".$dayCount."\" value=\"".(isset($monthDataValArr['date_column_'.$dayCount])?$monthDataValArr['date_column_'.$dayCount]:"")."\" /></td>";
                                    $dayCount++;
                                }
                            }
                    echo "</tr>";
                    $calendarrow++;
                }
                ?>
                <?php
                if( isset($monthDataVal[$calendarrow]) ){
                    $monthDataValArr = (array) $monthDataVal[$calendarrow];
                }
                
                $calendarrow++;
                ?>
                <tr>
                    <td colspan="2" style='text-align: center; vertical-align: middle'><input class="form-control" type="text" name="seventh_input" id="seventh_input" value="{{ (isset($monthDataValArr['column_1'])?$monthDataValArr['column_1']:"") }}" /></td>
                    <?php                     
                    $dayCount = 1; 
                    for($cb=1;$cb<=$boxDisplay;$cb++){
                        
                        if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                            $secondselectArr = array();
                            if( isset($monthDataValArr['date_column_'.$dayCount]) ){
                                $secondselectArr = explode(",",$monthDataValArr['date_column_'.$dayCount]);
                            } else {
                                $secondselectArr = array();
                            }
                            echo "<td>";
                                if( $usersdata )
                                    echo "<select class=\"form-control\" name=\"users_ids_sev_".$dayCount."[]\"  id=\"users_ids_sev_".$dayCount."\" data-toggle=\"select2\" multiple=\"\">";
                                        foreach( $usersdata as $usersdataVal )
                                            echo "<option value=\"".$usersdataVal->id."\" ".(in_array($usersdataVal->id, $secondselectArr)?"selected":"").">".$usersdataVal->nickname."</option>";
                                    echo "</select> ";
                            echo "</td>"; 
                            $dayCount++;
                        }
                    }
                    ?>
                </tr>
                <?php 
                $dayCount = 1; 
                $thirdselectArr = array();
                for($rw=1;$rw<=2;$rw++){
                    if( isset($monthDataVal[$calendarrow]) ){
                        $monthDataValArr = (array) $monthDataVal[$calendarrow];
                        $thirdselectArr = array();
                        $thirdselectArr = explode(",",$monthDataValArr['column_1']);
                    }
                    
                    echo "<tr>
                            <td>";
                                if( $usersdata )
                                    echo "<select class=\"form-control\" name=\"users_ids_egt_".$rw."[]\"  id=\"users_ids_egt_".$rw."\" data-toggle=\"select2\" multiple=\"\">";
                                        foreach( $usersdata as $usersdataVal )
                                            echo "<option value=\"".$usersdataVal->id."\" ".(in_array($usersdataVal->id, $thirdselectArr)?"selected":"").">".$usersdataVal->nickname."</option>";
                                    echo "</select> ";
                            echo "</td>
                            <td><input class=\"form-control\" type=\"text\" name=\"text_input_".$rw."\" id=\"text_input_".$rw."\" value=\"".(isset($monthDataValArr['column_2'])?$monthDataValArr['column_2']:"")."\" /></td>";

                            $dayCount = 1; 
                            for($cb=1;$cb<=$boxDisplay;$cb++){
                                $styleinputDates = "";
                                if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                                    if( isset($monthDataValArr['date_column_'.$dayCount]) && $monthDataValArr['date_column_'.$dayCount] == "D" ){
                                        $styleinputDates = "text-align : center; color : #2379C0; font-weight : 700";
                                    } else if( isset($monthDataValArr['date_column_'.$dayCount]) && $monthDataValArr['date_column_'.$dayCount] == "B" ){
                                        $styleinputDates = "text-align : center; color : #7034A2; font-weight : 700";
                                    } else if( isset($monthDataValArr['date_column_'.$dayCount]) && $monthDataValArr['date_column_'.$dayCount] == "A" ){
                                        $styleinputDates = "text-align : center; color : #080806; font-weight : 700";
                                    } else if( isset($monthDataValArr['date_column_'.$dayCount]) && $monthDataValArr['date_column_'.$dayCount] == "N" ){
                                        $styleinputDates = "text-align : center; color : #FE0735; font-weight : 800; font-size : 11px";
                                    } else if( isset($monthDataValArr['date_column_'.$dayCount]) && $monthDataValArr['date_column_'.$dayCount] == "OFF" ){
                                        $styleinputDates = "text-align : center; color : #54B65A; font-weight : 800; font-size : 11px; width: 52px";
                                    }
                                    echo "<td><input style=\"".$styleinputDates."\" class=\"form-control charvalidate\" type=\"text\" name=\"month_dates_egt_".$rw."_".$dayCount."\" id=\"month_dates_egt_".$rw."_".$dayCount."\" value=\"".(isset($monthDataValArr['date_column_'.$dayCount])?$monthDataValArr['date_column_'.$dayCount]:"")."\" /></td>";
                                    $dayCount++;
                                }
                            }
                    echo "</tr>";
                    $calendarrow++;
                }
                ?>
                <tr>
                    <td rowspan="2" colspan="2" style='background:#70AD47; text-align: center; vertical-align: middle'>Night Shift</td>
                    <?php 
                    $dayCount = 1; 
                    for($cb=1;$cb<=$boxDisplay;$cb++){
                        if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                            $currentDate = $dateYear.'-'.$dateMonth.'-'.$dayCount;

                            $timestamp = strtotime($currentDate);

                            $day = date('D', $timestamp);
                            echo "<td style='background:#FFFF02'>".$day."</td>";
                            $dayCount++;
                        }
                    }
                    ?>
                </tr>
                <tr>
                    <?php 
                    $dayCount = 1; 
                    for($cb=1;$cb<=$boxDisplay;$cb++){
                        if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                            //Current date
                            $currentDate = $dateYear.'-'.$dateMonth.'-'.$dayCount;

                            $timestamp = strtotime($currentDate);

                            $day = date('D', $timestamp);
                            //var_dump($day);
                            //die();
                            $eventNum = 0;
                            //Include db configuration file
                            //include 'dbConfig.php';
                            //Get number of events based on the current date
                            
                            //Define date cell color
                            if(strtotime($currentDate) == strtotime(date("Y-m-d"))){
                                    echo '<td style="background:#FFFF02" date="'.$currentDate.'" class="grey date_cell">';
                            }else{
                                    echo '<td style="background:#FFFF02" date="'.$currentDate.'" class="date_cell">';
                            }
                            //Date cell
                            echo '<span>';
                            echo $dayCount;
                            echo '</span>';

                            

                            echo '</td>';
                            $dayCount++;
                        }  
                    } 
                    ?>
                </tr>
                <?php 
                $dayCount = 1; 
                for($rw=1;$rw<=3;$rw++){
                    $monthDataValArr = (array) $monthDataVal[$calendarrow];
                    $firstColumnTitle = "";
                    switch($rw){
                        case 1:
                            $firstColumnTitle = "<input class=\"form-control\" type=\"text\" name=\"nine_text_".$rw."\" id=\"nine_text_".$rw."\" value=\"".(isset($monthDataValArr['column_1'])?$monthDataValArr['column_1']:"")."\" />";
                            break;
                        case 2:
                            $fourthselectArr = array();
                            if(isset($monthDataValArr['column_1'])){
                                $fourthselectArr = explode(",",$monthDataValArr['column_1']);
                            }
                            if( $usersdata )
                                    $firstColumnTitle.="<select class=\"form-control\" name=\"users_ids_nine_".$rw."[]\"  id=\"users_ids_nine_".$rw."\" data-toggle=\"select2\" multiple=\"\">";
                                        foreach( $usersdata as $usersdataVal )
                                            $firstColumnTitle.="<option value=\"".$usersdataVal->id."\" ".(in_array($usersdataVal->id, $fourthselectArr)?"selected":"").">".$usersdataVal->name."</option>";
                                    $firstColumnTitle.="</select> ";
                            break;
                        case 3:
                            $fourthselectArr = array();
                            if(isset($monthDataValArr['column_1'])){
                                $fourthselectArr = explode(",",$monthDataValArr['column_1']);
                            }
                            if( $usersdata )
                                    $firstColumnTitle.="<select class=\"form-control\" name=\"users_ids_nine_".$rw."[]\"  id=\"users_ids23_nine_".$rw."\" data-toggle=\"select2\" multiple=\"\">";
                                        foreach( $usersdata as $usersdataVal )
                                            $firstColumnTitle.="<option value=\"".$usersdataVal->id."\" ".(in_array($usersdataVal->id, $fourthselectArr)?"selected":"").">".$usersdataVal->name."</option>";
                                    $firstColumnTitle.="</select> ";
                            break;
                        default:
                            break;
                    }
        
                    echo "<tr>
                            <td colspan=\"2\" align=\"center\">".$firstColumnTitle."</td>";

                            $dayCount = 1; 
                            for($cb=1;$cb<=$boxDisplay;$cb++){
                                $styleinputDates = "";
                                if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                                    if( isset($monthDataValArr['date_column_'.$dayCount]) && $rw!=1 && $monthDataValArr['date_column_'.$dayCount] == "D" ){
                                        $styleinputDates = "text-align : center; color : #2379C0; font-weight : 700";
                                    } else if( isset($monthDataValArr['date_column_'.$dayCount]) && $rw!=1 && $monthDataValArr['date_column_'.$dayCount] == "B" ){
                                        $styleinputDates = "text-align : center; color : #7034A2; font-weight : 700";
                                    } else if( isset($monthDataValArr['date_column_'.$dayCount]) && $rw!=1 && $monthDataValArr['date_column_'.$dayCount] == "A" ){
                                        $styleinputDates = "text-align : center; color : #080806; font-weight : 700";
                                    } else if( isset($monthDataValArr['date_column_'.$dayCount]) && $rw!=1 && $monthDataValArr['date_column_'.$dayCount] == "N" ){
                                        $styleinputDates = "text-align : center; color : #FE0735; font-weight : 800; font-size : 11px";
                                    } else if( isset($monthDataValArr['date_column_'.$dayCount]) && $rw!=1 && $monthDataValArr['date_column_'.$dayCount] == "OFF" ){
                                        $styleinputDates = "text-align : center; color : #54B65A; font-weight : 800; font-size : 11px; width: 52px";
                                    }
                                    
                                    if( $rw != 1 ){
                                        $classvalidate = "charvalidate";
                                    } else {
                                        $classvalidate = "";
                                    }
                                    echo "<td><input style=\"".$styleinputDates."\" class=\"form-control ".$classvalidate."\" type=\"text\" name=\"month_dates_nine_".$rw."_".$dayCount."\" id=\"month_dates_nine_".$rw."_".$dayCount."\" value=\"".(isset($monthDataValArr['date_column_'.$dayCount])?$monthDataValArr['date_column_'.$dayCount]:"")."\" /></td>";
                                    $dayCount++;
                                }
                            }
                    echo "</tr>";
                    $calendarrow++;
                }
                ?>
                <tr>
                    <td colspan="2" style='text-align: center; vertical-align: middle'>&nbsp;</td>
                    <?php 
                    $monthDataValArr = (array) $monthDataVal[$calendarrow];
                    
                    $calendarrow++;
                    $dayCount = 1; 
                    for($cb=1;$cb<=$boxDisplay;$cb++){
                        if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                            $fifthselectArr = array();
                            if(isset($monthDataValArr['date_column_'.$dayCount])){
                                $fifthselectArr = explode(",",$monthDataValArr['date_column_'.$dayCount]);
                            }
                            echo "<td>";
                                if( $usersdata )
                                    echo "<select class=\"form-control\" name=\"users_ids_ten_".$dayCount."[]\"  id=\"users_ids_ten_".$dayCount."\" data-toggle=\"select2\" multiple=\"\">";
                                        foreach( $usersdata as $usersdataVal )
                                            echo "<option value=\"".$usersdataVal->id."\" ".(in_array($usersdataVal->id, $fifthselectArr)?"selected":"").">".$usersdataVal->name."</option>";
                                    echo "</select> ";
                            echo "</td>"; 
                            $dayCount++;
                        }
                    }
                    ?>
                </tr>
            </table>
            <script>
                
            $(document).ready(function(){
                $(".charvalidate").bind("keyup change", function(el) {
                    var enteredVal = this.value;
                    var enteredVal = enteredVal.toString().toLowerCase();
                    if( enteredVal == "o" ){
                        this.value = "OFF";
                        if( enteredVal == "o" ){
                            $(this).css({
                                'text-align' : 'center',
                                'color' : '#54B65A',
                                'font-size' : '11px',
                                'width' : '52px',
                                'font-weight' : '800'
                            });
                        }
                        this.value = "OFF";
                    }else if( enteredVal == "d" || enteredVal == "a" || enteredVal == "b" || enteredVal == "n" || enteredVal == "off" ){
                        this.value = enteredVal.toString().toUpperCase();
                        if( enteredVal == "d" ){
                            $(this).css({
                                'text-align' : 'center',
                                'color' : '#2379C0',
                                'font-size' : '14px',
                                'font-weight' : '700'
                            });
                        } else if( enteredVal == "b" ){
                            $(this).css({
                                'text-align' : 'center',
                                'color' : '#7034A2',
                                'font-size' : '14px',
                                'font-weight' : '700'
                            });
                        } else if( enteredVal == "a" ){
                            $(this).css({
                                'text-align' : 'center',
                                'color' : '#080806',
                                'font-size' : '14px',
                                'font-weight' : '700'
                            });
                        } else if( enteredVal == "n" ){
                            $(this).css({
                                'text-align' : 'center',
                                'color' : '#FE0735',
                                'font-size' : '11px',
                                'font-weight' : '800'
                            });
                        }

                    } else {
                        this.value = "";
                    }
                    // do stuff!
                })

                $('.date_cell').mouseenter(function(){
                    date = $(this).attr('date');
                    $(".date_popup_wrap").fadeOut();
                    $("#date_popup_"+date).fadeIn();	
                });
                $('.date_cell').mouseleave(function(){
                    $(".date_popup_wrap").fadeOut();		
                });
                $('.month_dropdown').on('change',function(){
                    getCalendar('calendar_div',$('.year_dropdown').val(),$('.month_dropdown').val());
                });
                $('.year_dropdown').on('change',function(){
                    getCalendar('calendar_div',$('.year_dropdown').val(),$('.month_dropdown').val());
                });
                $(document).click(function(){
                    $('#event_list').slideUp('slow');
                });
            });
            </script>
	</div>
        
    </div>
    <div class="section_content customer_details_content">
        <table class="operaton_form_tbl" cellpadding='10' cellspacing='10' border='0' width="50%">
            <tr>
                <td width="50px"><img src="/images/dutyrosterlegend.png" title="Legend" /></td>
                <td class="text-center"><input class="btn btn-blue-500" type="submit" name="savebutton" value="Save" id="click_to_print" /></td>
            </tr>
        </table>
    </div>
</div>
</form>

@endif;
@endsection


@push('css')
    <link href="/css/app/hearse.css" rel="stylesheet">
    <style>
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        padding: 3px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #e0e7e8;
    }
	
</style>
@endpush

 @push('scripts')
<script type="text/javascript">
function getCsrfToken() {
    if ($('#token').length) {
        return $('#token').val();
    }
    return false;
}
function getCalendar(target_div,year,month){
    $("#loadingimg").show();
    $.ajax({
        type:'POST',
        url:'/duty/ajaxcalendar',
        data:'func=getCalender&year='+year+'&month='+month+'&_token='+getCsrfToken(),
        success:function(html){
            $('#'+target_div).html(html);
            //$("#users_ids23").select2();
            $('#calender_section').find('select').select2();
            $("#loadingimg").hide();
        }
    });
}

function getEvents(date){
    $.ajax({
        type:'POST',
        url:'/duty/ajaxcalendar',
        data:'func=getEvents&date='+date,
        success:function(html){
            $('#event_list').html(html);
            $('#event_list').slideDown('slow');
        }
    });
}

function addEvent(date){
    $.ajax({
        type:'POST',
        url:'/duty/ajaxcalendar',
        data:'func=addEvent&date='+date,
        success:function(html){
            $('#event_list').html(html);
            $('#event_list').slideDown('slow');
        }
    });
}
</script>
    <script src="/js/vendor/jquery.signfield-master/js/sketch.min.js"></script>
    <script src="/js/vendor/jquery.signfield-master/js/jquery.signfield.min.js"></script>
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>   
@endpush