<?php

include 'conn.php';
require 'zklibrary.php';
header("Refresh:3");

$zk = new ZKLibrary('192.168.0.4', 4370);
$zk->connect();
$zk->disableDevice();
$users = $zk->getAttendance();

?>
<h1>Check-in</h1>
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
 
  <tbody>
    <?php
    $no = 0;
    foreach ($users as $key => $user) {
      $no++;
    ?>
  
    <?php
      $user_id = $user[1];
      $date = date("d-m-Y", strtotime($user[3]));
      $time = date("H:i:s", strtotime($user[3]));
      $chk = mysqli_query($conn,"select * from check_in where user_id='$user_id' and date='$date'");
      if(mysqli_num_rows($chk)==0) {
        $conn->query("INSERT INTO check_in (user_id,status, date, check_in) VALUES ('" . $user_id . "', 'check_in', '" . $date . "', '" . $time . "')");
      }

      echo mysqli_error($conn);
    }
    ?>
  </tbody>
</table>

<?php

$zk->enableDevice();
$zk->disconnect();

?>