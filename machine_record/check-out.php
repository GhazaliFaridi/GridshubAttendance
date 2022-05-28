<?php
include 'conn.php';
require 'zklibrary.php';
header("Refresh:3");
$zk = new ZKLibrary('192.168.0.5', 4370);
$zk->connect();
$zk->disableDevice();
$users = $zk->getAttendance();
?>
<h1>Check-out</h1>
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
    <thead>
        <tr>
            <td width="25">No</td>
            <td>UID</td>
            <td>ID</td>
            <td>status</td>
            <td>Date</td>
            <td>Time</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 0;
        foreach ($users as $key => $user) {
            $no++;
        ?>
            <tr>
                <td align="right"><?php echo $no; ?></td>
                <td><?php echo $key; ?></td>
                <td><?php echo $user[1]; ?></td>
                <td><?php echo 'Check-out'; ?></td>
                <td><?php echo date("d-m-Y", strtotime($user[3])); ?></td>
                <td><?php echo date("H:i:s", strtotime($user[3])); ?></td>
            </tr>
        <?php
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
        ?>
    </tbody>
</table>
<?php
$zk->enableDevice();
$zk->disconnect();
header("Location: ../late.php");
?>