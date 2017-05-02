
$(".generate-invoice").click(function(){
    
    var id="";var wsc="";var receiption_num ="";
    $("[id^=check_]").each(function(){
        
        if($(this).prop("checked")){
            id +=","+($(this).attr("id").replace("check_",""));
             wsc +=","+ $(this).parent().next().find("input[type='hidden']").val();
            receiption_num +=","+ $(this).parent().next().next().find("input[type='hidden']").val();
        }
    });
   
        if($("#invoice_date").val()==""){
            alert("Please select date to make invoice.");
            return false;
        }
        if(id == ""){
            alert("Please select invoices to make.");
            return false;
        }
             $.ajax({
                        url: "/invoice/generate_invoice",
                        method: "get",
                        data: { 
                                id:id,
                                invoice_date:$("#invoice_date").val()
                              }
                    }).done(function(data) {
                  
                     
                          
                          var removeid = id.split(",");
                          var wsc_split = wsc.split(",");
                          var receiption =receiption_num.split(",");
                          
                          for(var i=1;i<removeid.length;i++){
                              $("#check_"+removeid[i]).parent().parent().remove();
                               var win = window.open('invoice/genpdf/'+removeid[i]+"/"+wsc_split[i]+"/"+"I"+wsc_split[i], '_blank');
                          }
                    
                          location.reload();
                    });
   
});

$("#invoice_date").datepicker(
        
        {
            format:'dd/mm/yyyy'
        }        
        
);
$("#invoice_date_u").datepicker(
        
        {
            format:'dd/mm/yyyy'
        }        
        
);


$(".ungenerate-invoice").click(function(){
    
    var id="";var wsc="";var receiption_num ="";
    $("[id^=check_u_]").each(function(){
        
        if($(this).prop("checked")){
            id +=","+($(this).attr("id").replace("check_u_",""));
            wsc +=","+ $(this).parent().next().text();
            receiption_num +=","+ $(this).parent().next().next().find("input[type='hidden']").val();
        }
    });
   
  
        if($("#invoice_date_u").val()==""){
            alert("Please select date to make invoice.");
            return false;
        }
        if(id == ""){
            alert("Please select invoices to make.");
            return false;
        }
             $.ajax({
                        url: "/invoice/generate_invoice",
                        method: "get",
                        data: { 
                                id:id,
                                invoice_date:$("#invoice_date_u").val()
                              }
                    }).done(function(data) {
                  
                     
                         
                          var removeid = id.split(",");
                          var wsc_split = wsc.split(",");
                          var receiption =receiption_num.split(",");
                          for(var i=1;i<removeid.length;i++){
                              $("#check_u_"+removeid[i]).parent().parent().remove();
                              
                              var wins = window.open('invoice/genpdf/'+removeid[i]+"/"+wsc_split[i]+"/"+"I"+wsc_split[i], '_blank');
                          }
                          
//                          generate Pdf 
                           location.reload();  
                     
    
                    });
   
});


$("#from_date").datepicker({
    format:'dd/mm/yyyy'
});
$("#to_date").datepicker({
    format:'dd/mm/yyyy'
});

$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
      
        var from_date = $('#from_date').val().split("/");
        var to_date = $('#to_date').val().split("/");
        $date =  data[1]  || 0; // use data for the age column
        $date = $date.split("/");
       
        $new_from_date = Date.parse(from_date[1]+"-"+from_date[0]+"-"+from_date[2]);
        $new_to_date   = Date.parse(to_date[1]+"-"+to_date[0]+"-"+to_date[2]);
        $new_date = Date.parse($date[1]+"-"+$date[0]+"-"+$date[2]);
       
        if ( ( isNaN(  $new_from_date ) && isNaN( $new_to_date ) ) ||
             ( isNaN( $new_from_date ) && $new_date <= $new_to_date ) ||
             ( $new_from_date  <= $new_date   && isNaN($new_to_date ) ) ||
             ( $new_from_date <= $new_date   &&  $new_date <= $new_to_date  ) )
        {
            return true;
        }
        return false;
    }
);

function viewPayment(e){
   
    var wsc = $(e).attr("data-id");
    var id = $(e).attr("class");
    $("#wsc_id").val(id);
    $(e).parents("form").attr("action",$(e).parents("form").attr("action")+"/"+wsc).submit();
    
}