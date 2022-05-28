<!-- Edit -->
<div class="modal fade" id="edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b><span class="user_id"></span></b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="employee_edit.php">
          <input type="hidden" class="id" name="id">
          <div class="form-group">
            <label for="edit_name"class="col-sm-3 control-label">User Name</label>

            <div class="col-sm-9">
              <input type="text" placeholder="Username" class="form-control" id="edit_name" name="username" >
            </div>
          </div>
          <div class="form-group">
            <label for="edit_email" class="col-sm-3 control-label">Email</label>

            <div class="col-sm-9">
              <input type="email" placeholder="Email" class="form-control" id="edit_email" name="email">
            </div>
          </div>
          <div class="form-group">
            <label for="edit_id" class="col-sm-3 control-label">User Id</label>

            <div class="col-sm-9">
              <input type="text" placeholder="User_Id" class="form-control" id="edit_id" name="user_id">
            </div>
          </div>
          <div class="form-group">
            <label for="edit_schedule" class="col-sm-3 control-label">Schedule</label>

            <div class="col-sm-9">
              <select class="form-control" id="edit_schedule" name="schedule">
                <option selected id="schedule_val"></option>
                <?php
                $sql = "SELECT * FROM schedules";
                $query = $conn->query($sql);
                while ($srow = $query->fetch_assoc()) {
                  echo "<option value='" . $srow['id'] . "'>" . $srow['time_in'] . ' - ' . $srow['time_out'] . "</option> ";
                }
                ?>
              </select>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b><span class="user_id"></span></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="employee_delete.php">
            		<input type="hidden" class="id" name="id">
            		<div class="text-center">
	                	<p>DELETE EMPLOYEE</p>
	                	<h2 class="bold del_employee_name"></h2>
	            	</div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Delete</button>
            	</form>
          	</div>
        </div>
    </div>
</div>
