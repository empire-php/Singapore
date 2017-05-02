<table class="table-bordered" id="tbl_listing_pkg">
    <thead>
        <tr>
            <th>Package Category</th>
            <th>Package Name</th>
            <th>Original Price</th>
            <th>Promo Price</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
                                    
        @foreach($packages as $pack)
        <tr>
            <td>{{$pack->category}}</td>
            <td>{{$pack->name}}</td>
            <td>{{$pack->original_price}}</td>
            <td>{{$pack->promo_price}}</td>
            <td>
                <a href="#" id="package_edit_{{$pack->id}}"><i class="fa fa-pencil"></i> edit</a>
                <a href="#" id="package_delete_{{$pack->id}}"><i class="fa fa-remove"></i> delete</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>



<script type="text/javascript">
$(document).ready(function(){
    $("#tbl_listing_pkg [id^=package_edit]").click(function(e){
        e.preventDefault();
        
        $.ajax({
            url: "/settings/edit_fa_package",
            method: "GET",
            dataType: "html",
            data: {id: $(this).attr("id").replace("package_edit_","")},
        
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
    
    $("#tbl_listing_pkg [id^=package_delete]").click(function(e){
        e.preventDefault();
        
        if (confirm("Are you sure?")){
            $.ajax({
                url: "/settings/delete_fa_package",
                method: "GET",
                data: { id: $(this).attr("id").replace("package_delete_","") },
                statusCode: {
                    401: function() {
                      alert( "Login expired. Please sign in again." );
                    }
                }
            }).done(function(html) {

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
        }
    });
})
</script>