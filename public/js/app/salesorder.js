//When user click the Make payment button
function popup(){
    $("#make_payment_popup").modal("show");
}
//End binding button event 



//Search by WSC number or Deceased name 

$("#search_button").click(function(){
    
    $(".search-details tbody").html("");
    $wscNumber = $("#wscnumber").val().trim();
    $deceasedName = $("#deceasedname").val().trim();
    
    if( !$wscNumber && !$deceasedName){
        alert("Please select either WSC number or Deceased Name !");
        return false;
    }else if($wscNumber && !$deceasedName){
        $wsc = $wscNumber;
        $decese = '';
    }else if(!$wscNumber && $deceasedName){
        $wsc = '';
        $decese = $deceasedName;
    }else {
        $wsc = $wscNumber;
        $decese = $deceasedName;
    }
  
                    $.ajax({
                        url: "/salesorder/search",
                        dataType :"json",
                        method: "GET",
                        data: { 
                                wsc: $wsc,
                                decease : $decese
                              }
                    }).done(function(data) {
                     
                       if(data != "error"){
                       
                           for($i=0;$i<data.length;$i++){
                               
                               $html ='';
                               $html +="<tr><td ><a href='javascript:void(0)' class='fill-wsc-number' id="+data[$i].id+" onclick='viewSalesOrder(this)'>"+data[$i].wsc+"</a></td>";
                               $html +="<td class='fill-deceased-name'>";
                               $html +=data[$i].deceased_name ? "<span style='font-weight:bold'>"+data[$i].deceased_name+"</span>" : "<span style='color:red'>Undefined</span>";
                               $html +="</td></tr>";
                               
                               $(".search-details tbody").append($html);
//                            $(".fill-wsc-number").text(data[$i].wsc);
//                                data[$i].deceased_name ? $(".fill-deceased-name").html("<span style='font-weight:bold'>"+data[$i].deceased_name+"</span"):$(".fill-deceased-name").html("<span style='color:red'>Undefined</span>");
//                                $("#ordersalesId").val(data[$i].id);
//                                $(".fill-wsc-number").attr("id",data[$i].id);
//                                $("#wsc_id").val(data[$i].id);
                           }
                        }else{
                            alert("There is no result.");
                        }
                    });  
});
//End search

//get detail info to show data which get from db 

function viewSalesOrder(e){
    
    $(".section-two").remove();
    var id = $(e).attr("id");
    var wsc = $(e).text();
    var url =$(e).parents("form").attr("action");
    $("#wsc_id").val(id);
    $(e).parents("form").attr("action",url+"/"+wsc);
    $(e).parents("form").submit();
//    return;
//                    $.ajax({
//                        url: "/salesorder/get_details_data",
//                      
//                        method: "GET",
//                        data: { 
//                                id: id,
//                                wsc:wsc
//                              }
//                    }).done(function(data) {
//                           
//                            $(".section").append(data);
//                            //    Calculate GTS and Total Amount 
////                            $total_outstanding = 0;
//                            $(".gts-amount").each(function(){
//
//                                $stotal = $(this).prev().text().split("$");
//                                $subtotal = Math.round(parseFloat($stotal[1].trim())*100)/100;
//                                $me = Math.round($subtotal * 7 /100*100)/100 ;
//                                $total = Math.round(($subtotal + $me)*100)/100 ;
////                                $total_outstanding += $subtotal + $me;
//                                $(this).text("$"+$me);
//                                $(this).next().text("$"+$total);
//                            });
//                            
//                            $(".sub-total-for-table").each(function(){
//                                $subtotal = 0;
//                               
//                                $(this).parent().parent().find(".amount").each(function(){
//                                    $split = $(this).text().split("$");
//                                    $subtotal += Math.round(parseFloat($split[1].trim())*100)/100;
//                                });
//                                
//                                $gts = Math.round($subtotal * 7 / 100*100)/100 ;
//                                $total = Math.round(($subtotal + $gts)*100)/100 ;
//                               
//                                $(this).text('$'+$subtotal);
//                                $(this).parent().parent().find(".gts-for-table").text("$"+$gts);
//                                $(this).parent().parent().find(".total-for-table").text("$"+$total);
//                            }); 
//                                $sum = 0;
//                                $(".total-with-gst").each(function(){
//                                  
//                                    $val = $(this).text().replace("$","").trim();
//                                    $sum = $sum + parseFloat($val);
//                                    $sum = Math.round($sum*100)/100;
//                                });
//                                
//                                $paid_amount = 0;
//                                $("[id^=paid_amount_]").each(function(key){
//                                 
//                                   $previous_balance = $sum - $paid_amount ;
//                                   $previous_balance = Math.round($previous_balance*100)/100;
//                                   
//                                   $paid = $("#paid_amount_"+key).text().replace("$","").trim();                                 
//                                   $paid_amount += parseFloat($paid);
//                                   $paid_amount = Math.round($paid_amount*100)/100;
//                                   
//                                   $(".privious_balance_"+key).text("$"+$previous_balance);
//                                   $current_balance = Math.round(($previous_balance-$paid)*100)/100;
//                                   $("#current_balance_"+key).text("$"+$current_balance);
//                                });
//                                   $(".total-outstanding").text("$"+Math.round(($sum-$paid_amount)*100)/100);
////                                $(".total-outstanding").text("$"+$total_outstanding);
//                       });  
}              
//End
//Function for +/- button 

    function collapseTable(e){
            var iteration=$(e).data('iteration')||1 ;
            switch ( iteration) {
                    case 1:
                            $(e).parents("tr").next("tr").show();
                            $(e).addClass("fa-minus").removeClass("fa-plus");

                            break;

                    case 2:
                            $(e).parents("tr").next("tr").hide();
                            $(e).addClass("fa-plus").removeClass("fa-minus");
                            break;
            }
            iteration++;
            if (iteration>2) iteration=1
            $(e).data('iteration',iteration)
    }
    
//End for +/- button 
function submit_payment(){
    
    if($("#payment_amount").val() =="" || !$.isNumeric($("#payment_amount").val())){
        alert("Please enter payment amount");
        return false;
    }else {
        $user_id = $("#payment_user_id").val().trim();
        
        $sum = 0;
            $(".total-with-gst").each(function(){

                $val = $(this).text().replace(",","").replace("$","").trim();
                $sum = $sum + parseFloat($val);
                $sum = Math.round($sum*100)/100;
            });
            $paid_amount = 0;
                
                $("[id^=paid_amount_]").each(function(key){
                   $paid = $("#paid_amount_"+key).text().replace(",","").replace("(","").replace(")","").replace("$","").trim();                                 
                   $paid_amount += parseFloat($paid);
                });
                
                 $previous_balance = Math.round($sum*100)/100 - Math.round($paid_amount*100)/100 ;
                 $previous_balance = Math.round($previous_balance*100)/100;
              
                    $.ajax({
                        url: "/salesorder/payment_save",
                        method: "get",
                        data: { 
                                user_id: $user_id,
                                amount: $("#payment_amount").val(),
                                description:$("#payment_description").val(),
                                pay_mode : $("#payment_mode_popup").val(),
                                wsc:$(".section-two .wsc-number-payment").attr("id"),
                                previous_balance:$previous_balance
                              }
                    }).done(function(data) {
                
//                        Send data  for pdf
                        var id = $(".row").attr("id");
                       
                        var wsc = $(".section-two .wsc-number-payment").attr("id");

                        var win = window.open('genpdf/'+id+"/"+wsc+"/"+data, '_blank');
                        
                        var wina = window.open('customer/'+id+"/"+wsc+"/"+data+"", '_blank');
        //                        Send data  for pdf
        //              Put here code to append tr element to table
                             location.reload();  
                    });
                    
    }
}


$(function(){

                            $(".gts-amount").each(function(){

                                $stotal = $(this).prev().text().replace(",","").split("$");
                                $subtotal = Math.round(parseFloat($stotal[1].trim())*100)/100;
                                $me = Math.round($subtotal * 7 /100*100)/100 ;
                                $total = Math.round(($subtotal + $me)*100)/100 ;
                                $(this).text("$"+number_format($me,2));
                                $(this).next().text("$"+number_format($total,2));
                            });
                            
                            $(".sub-total-for-table").each(function(){
                                $subtotal = 0;
                               
                                $(this).parent().parent().find(".amount").each(function(){
                                    $split = $(this).text().replace(",","").split("$");
                                    $subtotal += Math.round(parseFloat($split[1].trim())*100)/100;
                                });
                                
                                $gts = Math.round($subtotal * 7 / 100*100)/100 ;
                                $total = Math.round(($subtotal + $gts)*100)/100 ;
                               
                                $(this).text('$'+number_format($subtotal,2));
                                $(this).parent().parent().find(".gts-for-table").text("$"+number_format($gts,2));
                                $(this).parent().parent().find(".total-for-table").text("$"+number_format($total,2));
                            }); 
                                $sum = 0;
                                $(".total-with-gst").each(function(){
                                  
                                    $val = $(this).text().replace(",","").replace("$","").trim();
                                    $sum = $sum + parseFloat($val);
                                    $sum = Math.round($sum*100)/100;
                                });
                                
                                $paid_amount = 0;
                                $("[id^=paid_amount_]").each(function(key){
                                 
                                //   $previous_balance = $sum - $paid_amount ;
                                //   $previous_balance = Math.round($previous_balance*100)/100;
                                   
                                   $paid = $("#paid_amount_"+key).text().replace(",","").replace("(","").replace(")","").replace("$","").trim();                                 
                                   $paid_amount += parseFloat($paid);
                                   $paid_amount = Math.round($paid_amount*100)/100;
                                   
                                  // $(".privious_balance_"+key).text("$"+number_format($previous_balance,2));
                                 
                                     $previous_balance = $(".privious_balance_"+key).text().replace(",","").replace("$","").replace("(","").replace(")","").trim();
                                    
                                    $previous_balance = Math.round( parseFloat($previous_balance)*100)/100;
                                    
                                    $current_balance = Math.round(($previous_balance-$paid)*100)/100;
                                   $("#current_balance_"+key).text("$"+number_format($current_balance,2));
                                });
                                   $(".total-outstanding").text("$"+number_format($sum-$paid_amount,2));
//                                $(".total-outstanding").text("$"+$total_outstanding);
});

function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}


