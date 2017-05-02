<table class="table-bordered" id="tbl_listing_roster">
    <thead>
        <tr>
            <th>Team</th>
            <th>Team Leader</th>
            <th>Embalmers</th>
            <th>Others</th>
            <th>Add to Roster</th>
        </tr>
    </thead>
   <tbody>
<?php foreach($rosters as $roster){ ?>
<tr>
	<td><?php echo $roster->team_name;?></td>
	<td><?php echo $roster->team_leader;?></td>
	<td><?php echo $roster->embalmers;?></td>
	<td><?php echo $roster->others;?></td>
	<?php if($roster->add_to_roster == "1") {?>
	<td>Yes</td>
	<?php } else { ?>
	<td>No</td>
	<?php } ?>
	<td>
		<a href="#" id="roster_edit_<?php echo$roster->id;?>"><i class="fa fa-pencil"></i> edit</a>
		<a href="#" id="roster_delete_<?php echo $roster->id;?>"><i class="fa fa-remove"></i> delete</a>
	</td>
</tr>
<?php } ?>
</tbody>
</table>



<script type="text/javascript">
$(document).ready(function(){
	$("#tbl_listing_roster [id^=roster_edit]").click(function(e){
        e.preventDefault();
        
        $.ajax({
            url: "{{ url('')}}/settings/edit_roster_setting",
            method: "GET",
            dataType: "html",
            data: {id: $(this).attr("id").replace("roster_edit_","")},
        
            statusCode: {
                401: function() {
                  alert( "Login expired. Please sign in again." );
                }
            }
        }).done(function(html) {
            
            
            $("#edit_roster_container").html(html);
            $("#edit_roster_container").show();
            
            
        });
    });
    
    $("#tbl_listing_roster [id^=roster_delete]").click(function(e){
        e.preventDefault();
        
        if (confirm("Are you sure?")){
            $.ajax({
                url: "{{ url('')}}/settings/delete_roster_setting",
                method: "GET",
                data: { id: $(this).attr("id").replace("roster_delete_","") },
                statusCode: {
                    401: function() {
                      alert( "Login expired. Please sign in again." );
                    }
                }
            }).done(function(html) {

                $.ajax({
                    url: "{{ url('')}}/settings/list_roster_setting",
                    method: "GET",
                    dataType: "html",

                    statusCode: {
                        401: function() {
                          alert( "Login expired. Please sign in again." );
                        }
                    }
                }).done(function(html) {
					alert(html);
					$("#tbl_list_roster").html(html);
                });
            });
        }
    });
})
</script>