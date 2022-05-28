<?php
$data = "SELECT * FROM   users_data WHERE ac_no = " . $_SESSION['user_id'] . " GROUP BY dates ";
if ($row = mysqli_query($conn, $data)) {
  if (mysqli_num_rows($row) > 0) {
    $name = $row->fetch_assoc();
  }
}
?>
<header class="main-header">
  <a href="home.php" class="logo">
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>GridsHub</b></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <div class="row" style="margin-top: 10px; font-size: 30px; color:white; font-weight: bold; text-align: center;">
      <div class="col-lg-9" style="margin-left:105px">
        <p><?php echo $name['name'] . '-' . $name['ac_no']; ?></p>
      </div>
      <div class="col-lg-3" style="margin-left:-128px ; margin-top:5px;">
        <a href="logout.php" class="btn btn-danger btn-flat pull-right ">Sign out</a>
      </div>
    </div>
  </nav>
</header>
mation - headers already sent by (output started at E:\xampp1\htdocs\Gridhub\Attendence _Record\Users\admin\includes\navbar.php:19) in E:\xampp1\htdocs\Gridhub\Attendence _Record\Users\admin\home.php on line 11