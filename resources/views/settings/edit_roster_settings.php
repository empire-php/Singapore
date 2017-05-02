<div class="table table_container" id="edit_roster_settings_content">
   <?php echo csrf_field() ?>
   <input type="hidden" name="id" id="id" value="<?php echo $roster->id;?>" />


    <div class="section_title" style="width: 30%; margin-bottom: 0px; margin-top: 60px">
       <?php if ( $roster->id > 0) { ?>
        Edit Team
	   <?php } else { ?>
        Add more teams
	   <?php } ?>
    </div>
    <table>
        <tr><td colspan="2">
             <?php if ( $roster->id > 0) { ?>
                <strong>Currently editing: <?php echo $roster->team_name; ?></strong>
            <?php } ?>
            </td></tr>
        <tr>
            <td>
                Team:
            </td>
            <td>
                <input type="text" class="form-control" name="team_name" id="team_name" value="<?php echo $roster->team_name; ?>" />
            </td>
        </tr>
        <tr>
            <td>
                Team Leader:
            </td>
            <td>
                <input type="text" class="form-control" name="team_leader" id="team_leader" value="<?php echo $roster->team_leader; ?>" />
			</td>
        </tr>
        <tr>
            <td>
                Embalmers:
            </td>
            <td>
                <input type="text" class="form-control" name="embalmers" id="embalmers" value="<?php echo $roster->embalmers; ?>" />
            </td>
        </tr>
        <tr>
             <td>
                Others:
            </td>
            <td>
                <input type="text" class="form-control" name="others" id="others" value="<?php echo $roster->others; ?>" />
            </td>
        </tr>
		<tr>
             <td>
                Add to Roster:
            </td>
            <td>
				<select class="form-control" id="add_to_roster" name="add_to_roster">
                <option <?php echo $roster->add_to_roster; ?> value="1">Yes</option>
                <option value="<?php echo $roster->add_to_roster; ?>">No</option>
				</select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button class="btn btn-primary" type="button" id="roster_save_bttn">
                    <i class="fa fa-save"></i> Save
                </button>
            </td>
        </tr>
    </table>
    <br />
    <br />
</div>

<script type="text/javascript">
$(document).ready(function(){
    $("#roster_save_bttn").click(function(e){
       e.preventDefault();
        
        $.ajax({
            url: "/settings/update_roster_setting",
            method: "POST",
            dataType: "html",
            data: { _token: $("#edit_roster_settings_content [name=_token]").val(),
                    id: $("#edit_roster_settings_content #id").val(),
                    team_name: $("#edit_roster_settings_content #team_name").val(),
                    team_leader: $("#edit_roster_settings_content #team_leader").val(),
                    embalmers: $("#edit_roster_settings_content #embalmers").val(),
                    others: $("#edit_roster_settings_content #others").val(),
                    add_to_roster: $("#edit_roster_settings_content #add_to_roster").val(),
                  },
        
            statusCode: {
                401: function() {
                  alert( "Login expired. Please sign in again." );
                }
            }
        }).done(function(html) {
            $("#edit_roster_container").html(html);
            $("#edit_roster_container").show();
            
            $.ajax({
                url: "/settings/list_roster_setting",
                method: "GET",
                dataType: "html",

                statusCode: {
                    401: function() {
                      alert( "Login expired. Please sign in again." );
                    }
                }
            }).done(function(html) {
                $("#tbl_list_roster").html(html);
            });
        });
    });
});
</script>