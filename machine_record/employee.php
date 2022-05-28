<?php
error_reporting(E_ERROR | E_PARSE);
include('conn.php');
header("Refresh:3"); 
?>
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
    <thead>
        <tr>
            <td>ID</td>
            <td>User_ID</td>
            <td> Name </td>
            <td>Date</td>
            <td>Checkin</td>
            <td>Checkout</td>
            <td> Absent </td>
            <td>Early</td>
            <td>Total Hours</td>
        </tr>
    </thead>
    <tbody>
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
    </tbody>
</table>