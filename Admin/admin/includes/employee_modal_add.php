<div class="modal fade" id="addnew">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b>Add Employee</b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="employee_add.php" enctype="multipart/form-data" id="Form">
          <div class="form-group">
            <label for="username" class="col-sm-3 control-label">User Name</label>

            <div class="col-sm-9">
            <input type="text" id="username" placeholder="Username" name="username"  required>
            </div>
          </div>
          <div class="form-group">
            <label for="email" class="col-sm-3 control-label">Email</label>

            <div class="col-sm-9">
            <input type="email" class="email" placeholder="Email" name="email" required>
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="col-sm-3 control-label">Password</label>

            <div class="col-sm-9">
            <input type="password" class="password" placeholder="Password" name="password" required>
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="col-sm-3 control-label">Confirm Password</label>

            <div class="col-sm-9">
              <div class="date">
              <input type="password" class="cpassword" placeholder="Confirm Password" name="cpassword"  required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="user_id" class="col-sm-3 control-label">User Id</label>

            <div class="col-sm-9">
            <input type="text" class="user_id" placeholder="user_id" name="user_id" required>
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
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Save</button>
        </form>
      </div>
    </div>
  </div>
</div>