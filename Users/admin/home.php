<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<?php
    if (isset($_SESSION['username'])) { 
    }
    if (isset($_POST['submit'])) {
      $email = $_POST['email'];
      $password = md5($_POST['password']);
      $_SESSION['user_id'];
      $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
      $result = mysqli_query($conn, $sql);
      if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_id'] = $row['user_id'];    
      } else {
        echo "<script>alert('Woops! Email or Password is Wrong.')</script>";
      }
    }
    ?>


<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Dashboard
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Dashboard</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <?php
        if (isset($_SESSION['error'])) {
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              " . $_SESSION['error'] . "
            </div>
          ";
          unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              " . $_SESSION['success'] . "
            </div>
          ";
          unset($_SESSION['success']);
        }
        ?>
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <?php
                $first_day_this_month = date('Y-m-01');
                $last_day_this_month  = date('Y-m-t');
                $data = "  SELECT * FROM users_data WHERE ac_no = " . $_SESSION['user_id'] . " AND absent !='TRUE'  and  dates BETWEEN '$first_day_this_month' AND '$last_day_this_month'   ";
                $query = $conn->query($data);
                echo "<h3>" . $query->num_rows . "</h3>";
                ?>

                <p>Total Days Of Working</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-stalker"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <?php
                $first_day_this_month = date('Y-m-01');
                $last_day_this_month  = date('Y-m-t');
                $result = mysqli_query($conn, 'SELECT SUM(total_time) AS value_sum  FROM users_data WHERE ac_no = "' . $_SESSION['user_id'] . '" AND dates BETWEEN "' . $first_day_this_month . '" AND "' . $last_day_this_month . '" ');
                $rowcounnt = mysqli_fetch_array($result);

                echo "<h3>" .  $rowcounnt['value_sum'] . "</h3>";
                ?>

                <p>Working Hours</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <?php
                $first_day_this_month = date('Y-m-01');
                $last_day_this_month  = date('Y-m-t');
                $data = "  SELECT * FROM users_data WHERE ac_no = " . $_SESSION['user_id'] . " AND late !='-'  and  dates BETWEEN '$first_day_this_month' AND '$last_day_this_month'   ";
                $query = $conn->query($data);
                $query = $conn->query($data);
                echo "<h3>" . $query->num_rows  . "</h3>"
                ?>

                <p>Lates</p>
              </div>
              <div class="icon">
                <i class="ion ion-clock"></i>
              </div>
            </div>
          </div>
          <!-- col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <?php
                $first_day_this_month = date('Y-m-01');
                $last_day_this_month  = date('Y-m-t');
                $data = "  SELECT * FROM users_data WHERE ac_no = " . $_SESSION['user_id'] . " AND absent ='TRUE' and  dates BETWEEN '$first_day_this_month' AND '$last_day_this_month'   ";
                $query = $conn->query($data);
                echo "<h3>" . $query->num_rows . "</h3>"
                ?>

                <p>Total Absent</p>
              </div>
              <div class="icon">
                <i class="ion ion-alert-circled"></i>
              </div>
            </div>
          </div>
          <!-- col -->
        </div>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header with-border">
                  <form method="POST" autocomplete="off" action="./filter.php">
                    <div class="container">
                      <div class="row">
                        <div class="col-md-3">
                          <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" />
                        </div>
                        <div class="col-md-3">
                          <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" />
                        </div>
                        <div class="col-md-5">
                          <input type="submit" name="filter" id="filter" value="Filter" class="btn btn-info" required="true" />
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="box-body">
                  <?php
                  $first_day_this_month = date('Y-m-01');
                  $last_day_this_month  = date('Y-m-t');
                  $data = "SELECT * FROM users_data WHERE ac_no = " . $_SESSION['user_id'] . " And  dates BETWEEN '$first_day_this_month' AND '$last_day_this_month'order by dates ASC";
                  $row = mysqli_query($conn, $data);
                  if (mysqli_num_rows($row) > 0) {
                    echo "<table class='tables table-bordered' id='order_table'>
                                    <thead>
                                      <tr>
                                      <th>S-NO</th>
                                      <th>Date</th>
                                      <th>Clock In</th>
                                      <th>Clock Out</th>
                                      <th>Late</th>
                                      <th>Early</th>
                                      <th>Absent</th>
                                      <th>Total-Time</th>
                                      </tr>
                                    </thead>
                                    <tbody>";
                    $count = 1;
                    while ($users = mysqli_fetch_array($row)) {
                      $status = '<span class="label label-danger pull-right">Late</span>';
                      $early_status = '<span class="label label-danger pull-right">Early</span>';

                      //lates                 

                      $lates = $users['late'];
                      $min = ' Mins';
                      if ($users['late'] != '-') {
                        $late = $lates . $min . $status;
                      } else {
                        $late = ' - ';
                      }

                      // Early
                      $early = $users['early'];
                      $hr = ' Hr';
                      if (($early != ' - ') && ($users['clock_out'] == ' 01:00 AM ')) {
                        $early_time = $early . $hr . $early_status;
                      } else {
                        $early_time = ' - ';
                      }

                      // Absent
                      if ($users['absent'] == 'TRUE') {
                        $absent = $users['absent'];
                      } else {
                        $absent = ' - ';
                      }

                      // clock_out
                      if ($users['clock_out'] != '01:00 AM') {
                        $clock_out = $users['clock_out'];
                      } else {
                        $clock_out = ' - ';
                      }

                      // totaltime
                      if ($users['clock_out'] != '01:00 AM') {
                        $total_time = $users['total_time'];
                      } else {
                        $total_time = ' - ';
                      }

                      if ($users['absent'] == 'TRUE') {
                        echo "	<tr style = 'background-color: #FF7377;'>
                            <td>" . $count++ . "</td>
                            <td>" . date("d-m-Y", strtotime($users['dates'])) . "</td>
                            <td>" . $users['clock_in'] . "</td>
                            <td>" . $clock_out . "</td>
                            <td>" . $late . "</td>
                            <td>" . $early_time . "</td>
                           <td>" . $absent . "</td>
                            <td>" . $total_time . "</td>
                            </tr>";
                      } else {
                        echo "	<tr>
                            <td>" . $count++ . "</td>
                            <td>" . date("d-m-Y", strtotime($users['dates'])) . "</td>
                            <td>" . $users['clock_in'] . "</td>
                            <td>" . $clock_out . "</td>
                            <td>" . $late . "</td>
                            <td>" . $early_time . "</td>
                            <td>" . $absent . "</td>
                            <td>" . $total_time . "</td>
                            </tr>";
                      }
                    }
                    echo "</tbody>
                                </table>";
                  } else {
                    echo "ERROR: Could not able to execute $data. " . mysqli_error($conn);
                  }
                  mysqli_close($conn);
                  ?>
                </div>
              </div>
            </div>
          </div>
        </section>
    </div>
  </div>
  <?php include 'includes/footer.php'; ?>
</body>

</html>