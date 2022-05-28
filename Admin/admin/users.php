<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/menubar.php'; ?>
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
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
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

                            <div class="box-body">
                                <?php
                                $first_day_this_month = date('Y-m-01');
                                $last_day_this_month  = date('Y-m-t');
                                $data =  "SELECT * FROM users_data d  where d.dates BETWEEN '$first_day_this_month' AND '$last_day_this_month' ORDER BY d.ac_no ASC, d.dates ASC";

                                if ($row = mysqli_query($conn, $data)) {
                                    if (mysqli_num_rows($row) > 0) {
                                        echo "	<table class='table table-bordered'>
                									<thead>
														<tr>
															<th>S-No</th>
															<th>Acc_No</th>
															<th>Name</th>
															<th>Date</th>
															<th>Clock In</th>
															<th>Clock Out</th>
															<th>Late</th>
															<th>Early</th>
															<th>Absent</th>
															<th>Total_Time</th>
														</tr>
													</thead>
													<tbody>";

                                        $sNo = 1;
                                        $data = [];
                                        while ($res = $row->fetch_assoc()) {
                                            $data[] = $res;
                                        }
                                        $count = 0;
                                        $newdate = '';
                                        foreach ($data as $key => $users) {
                                            // count lates only for current month
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
                            <td>" . $users['ac_no'] . "</td>
                            <td>" . $users['name'] . "</td>
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
                            <td>" . $users['ac_no'] . "</td>
                            <td>" . $users['name'] . "</td>
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
                                    }
                                    echo "		</tbody>
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
    </div <?php include 'includes/footer.php'; ?> </body>

    </html>