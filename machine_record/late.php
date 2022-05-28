<?php
// Load the database configuration file
error_reporting(E_ERROR | E_PARSE);
include('conn.php');
header("Refresh:3");
$sql = "SELECT * FROM users ORDER BY user_id ASC";
$users = [];

if ($row = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($row) > 0) {
        while ($user = $row->fetch_assoc()) {
            $users[] = $user;
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

        foreach ($users as $k => $val) {

            $count = 0;
            $newdate = '';
            foreach ($data as $key => $value) {
                $chkdate = explode("-", $value['dates'])[1];
                if ($newdate != $chkdate) {
                    $count = 0;
                    $newdate = $chkdate;
                }
                if ($val['user_id'] == $value['ac_no']) {
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
