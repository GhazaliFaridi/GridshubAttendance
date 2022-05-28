<!-- checkin and chkout data loads here  -->
<?php

//include 'conn.php';
include 'includes/conn.php';
require 'zklibrary.php';
// header("Refresh:3");

$zk = new ZKLibrary('192.168.0.4', 4370);
$zk->connect();
$zk->disableDevice();
$users = $zk->getAttendance();


$no = 0;
    foreach ($users as $key => $user) {
      $no++;
  
  
    
      $user_id = $user[1];
      $date = date("d-m-Y", strtotime($user[3]));
      $time = date("H:i:s", strtotime($user[3]));
      $chk = mysqli_query($conn,"select * from check_in where user_id='$user_id' and date='$date'");
      if(mysqli_num_rows($chk)==0) {
        $conn->query("INSERT INTO check_in (user_id,status, date, check_in) VALUES ('" . $user_id . "', 'check_in', '" . $date . "', '" . $time . "')");
      }

      echo mysqli_error($conn);
    }



    $zk2 = new ZKLibrary('192.168.0.5', 4370);
$zk2->connect();
$zk2->disableDevice();
$users2 = $zk2->getAttendance();
$no = 0;
foreach ($users2 as $key => $user) {
    $no++;

    $user_id = $user[1];
    $date = date("d-m-Y", strtotime($user[3]));
    $time = date("H:i:s", strtotime($user[3]));
    $chk = mysqli_query($conn, "select * from check_out where user_id='$user_id' and date='$date' ");

    if (mysqli_num_rows($chk) == 0) {
        $conn->query("INSERT INTO check_out (user_id,status, date, check_out) VALUES ('" . $user_id . "', 'check_out', '" . $date . "', '" . $time . "')");
    }else{
        $conn->query("delete from check_out where user_id='$user_id' and date='$date' ");
        $conn->query("INSERT INTO check_out (user_id,status, date, check_out) VALUES ('" . $user_id . "', 'check_out', '" . $date . "', '" . $time . "')");
    }
    echo mysqli_error($conn);
}


$zk->enableDevice();
$zk->disconnect();

$zk2->enableDevice();
$zk2->disconnect();


    ?>
<!-- employee.php data loads here  -->

<?php
        $sql1 = mysqli_query($conn, "select * from check_in");
        while ($row = mysqli_fetch_array($sql1)) {

            $sql2 = mysqli_query($conn, "select * from check_out where date='" . $row['date'] . "' and user_id='" . $row['user_id'] . "' ");
            $row2 = mysqli_fetch_array($sql2);

            $time1 = new DateTime($row['check_in']);
            $time2 = new DateTime($row2['check_out']);
            $interval = $time1->diff($time2);

            $data =  mysqli_query($conn, "SELECT * FROM users u LEFT JOIN schedules s ON s.id=u.schedule_id");
           
            while ($row3 = mysqli_fetch_array($data)) {
                if ($row3['user_id'] == $row['user_id']) {
                    $name = $row3['username'];
                    $check_out = date('H:i', strtotime($row2['check_out']));
                    $shift_time_out = date('H:i', strtotime($row3['time_out']));

                    // For Early Leaves
                    if ($shift_time_out  == date('H:i', mktime(18, 00))) {
                        if ($check_out >= $shift_time_out) {
                            $early_time =  ' - ';
                        } else if ($check_out != $shift_time_out) {
                            $early_time = '1';
                        }
                    }
                    if ($shift_time_out  == date('H:i', mktime(19, 00))) {
                        if ($check_out >= $shift_time_out) {
                            $early_time =  ' - ';
                        } else if ($check_out != $shift_time_out) {
                            $early_time = '1';
                        }
                    }
                    if ($shift_time_out  == date('H:i', mktime(20, 00))) {
                        if ($check_out >= $shift_time_out) {
                            $early_time =  ' - ';
                        } else if ($check_out != $shift_time_out) {
                            $early_time = '1';
                        }
                    }
                }
            }
        ?>
           
        <?php
            $ac_no = $row['user_id'];
            $Date = date("y-m-d", strtotime($row['date']));
            if (!empty($Date)) {
                $date = $Date;
            } else if ((empty($Date))) {
                $date = ' - ';
            }
            $clock_in =  $row['check_in'];
            $clock_out = $row2['check_out'];
            $total_times = $interval->format('%H Hrs');


            

            $chk = mysqli_query($conn, "select * from employees_data where ac_no='$ac_no' and dates='$date'");
            if (mysqli_num_rows($chk) == 0) {
                $conn->query("INSERT INTO employees_data (ac_no, name, dates, clock_in, clock_out, early,total_time) VALUES ('" . $ac_no . "', '" . $name . "', '" . $date . "', '" . $clock_in . "', '" . $clock_out . "', '" . $early_time . "','" . $total_times . "')");
            } else {
                $conn->query("delete from employees_data where ac_no='$ac_no' and dates='$date' ");
                $conn->query("INSERT INTO employees_data (ac_no, name, dates, clock_in, clock_out, early,total_time) VALUES ('" . $ac_no . "', '" . $name . "', '" . $date . "', '" . $clock_in . "', '" . $clock_out . "', '" . $early_time . "','" . $total_times . "')");
            }
            echo mysqli_error($conn);
        }
        ?>

<!-- late.php data loads here  -->


<?php 
$sql = "SELECT * FROM users ORDER BY user_id ASC";
$usersa = [];

if ($row = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($row) > 0) {
        while ($user = $row->fetch_assoc()) {
            $usersa[] = $user;
        }
    }
}

$data = "SELECT d.*, s.time_in FROM employees_data d LEFT JOIN users u ON u.user_id = d.ac_no LEFT JOIN schedules s ON s.id=u.schedule_id ORDER BY d.ac_no ASC, d.dates ASC";

if ($row = mysqli_query($conn, $data)) {
    if (mysqli_num_rows($row) > 0) {
        $data = [];
        while ($res = $row->fetch_assoc()) {
            $data[] = $res;
        }

        
        // get time interval from joining till current month
        
        $period = new DatePeriod(
            new DateTime('23-11-2021'),
            new DateInterval('P1D'),
            new DateTime($date_now)
        );
        $day = [];
        foreach ($period as $key => $value) {
            $val = $value->format('Y-m-d');

            if ($value->format('D') != 'Sat' && $value->format('D') != 'Sun') {
                $day[] = $val;
            }
        }

        foreach ($usersa as $k => $val) {

            $count = 0;
            $newdate = '';
            foreach ($data as $key => $value) {
                $chkdate = explode("-", $value['dates'])[1];
                if ($newdate != $chkdate) {
                    $count = 0;
                    $newdate = $chkdate;
                }
               // echo "<pre>";
               
                if($val['user_id']==$value['ac_no']) {
                    
                    $clock_in = strtotime($value['clock_in']);
                    $shift_time = date('H:i', strtotime($value['time_in']));
                    if ($shift_time == date('H:i', mktime(10, 00))) {
                        if ($clock_in > strtotime('10:16 AM')) {
                            $count++;
                            $lates = date('i', strtotime($value['clock_in']));
                        } else if ($clock_in > strtotime('10:11 AM') && $count >= 2) {
                            $count++;
                            $lates = date('i', strtotime($value['clock_in']));
                        } else if ($clock_in > strtotime('10:06 AM') && $count >= 4) {
                            $count++;
                            $lates = date('i', strtotime($value['clock_in']));
                        } else if ($clock_in > strtotime('10:01 AM') && $count >= 6) {
                            $count++;
                            $lates = date('i', strtotime($value['clock_in']));
                        } else {
                            $lates = '-';
                        }
                    }
                    if ($shift_time == date('H:i', mktime(11, 00))) {
                        if ($clock_in > strtotime('11:16 AM')) {
                            $count++;
                            $lates = date('i', strtotime($value['clock_in']));
                        } else if ($clock_in > strtotime('11:11 AM') && $count >= 2) {
                            $count++;
                            $lates = date('i', strtotime($value['clock_in']));
                        } else if ($clock_in > strtotime('11:06 AM') && $count >= 4) {
                            $count++;
                            $lates = date('i', strtotime($value['clock_in']));
                        } else if ($clock_in > strtotime('11:01 AM') && $count >= 6) {
                            $count++;
                            $lates = date('i', strtotime($value['clock_in']));
                        } else {
                            $lates = '-';
                        }
                    }

                    $ac_no = $value['ac_no'];
                    $name= $value['name'];
                    $date = date("y-m-d", strtotime($value['dates']));
                    $clock_in = date('H:i A', strtotime($value['clock_in']));
                    $clock_out = date('H:i A', strtotime($value['clock_out']));
                    $early_time = $value['early'];
                    $absent = $value['absent'];
                    $total_times = $value['total_time'];
                   

                    $chk = mysqli_query($conn, "select * from users_data where ac_no='$ac_no' and dates='$date'");
                    if (mysqli_num_rows($chk) == 0) {
                        $conn->query("INSERT INTO users_data (ac_no, name, dates, clock_in, clock_out, late, early,total_time) VALUES ('" . $ac_no . "', '" . $name . "', '" . $date . "', '" . $clock_in . "', '" . $clock_out . "', '" . $lates . "' ,'" . $early_time . "','" . $total_times . "')");
                    } else {
                        $conn->query("delete from users_data where ac_no='$ac_no' and dates='$date' ");
                        $conn->query("INSERT INTO users_data (ac_no, name, dates, clock_in, clock_out, late, early,total_time) VALUES ('" . $ac_no . "', '" . $name . "', '" . $date . "', '" . $clock_in . "', '" . $clock_out . "', '" . $lates . "' , '" . $early_time . "','" . $total_times . "')");
                    }

                }
            };

            $sqlchk = mysqli_query($conn, "select * from employees_data where ac_no='" . $val['user_id'] . "' order by id Asc");
            
            $rowchk2 = mysqli_fetch_array($sqlchk);
            for ($i = 0; $i < sizeof($day); $i++) {

                if ($day[$i] >= $rowchk2['dates']) {
                    $sql4 = mysqli_query($conn, "select * from employees_data where dates='" . $day[$i] . "' and ac_no='" . $val['user_id'] . "' ");
                    if (mysqli_num_rows($sql4) == 0) {

                        $sqlk=mysqli_query($conn,"select * from users_data where ac_no='".$val['user_id'] ."' and  dates='".$day[$i]."' and absent='TRUE' ");

                        if(mysqli_num_rows($sqlk)==0){
                            $conn->query("INSERT INTO users_data (ac_no, name, dates, clock_in, clock_out, late, early,absent,total_time) VALUES ('" . $val['user_id'] . "', '" . $val['username'] . "', '" . $day[$i] . "',' - ', ' - ', '-', ' - ', 'TRUE',' - ')");
                        }
                        

                        echo mysqli_error($conn);
                    }
                }
            }
        };
    } 
} 
mysqli_close($conn);

echo '	<meta http-equiv="refresh" content="0;url=home.php " />';

?>

