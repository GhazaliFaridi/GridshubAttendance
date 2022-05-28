<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <?php
    $data = "SELECT MIN(ac_no) As  ac_no, name FROM  users_data WHERE ac_no = " . $_SESSION['user_id'] . " GROUP BY dates ";
    if ($row = mysqli_query($conn, $data)) {
      if (mysqli_num_rows($row) > 0) {
        $name = $row->fetch_assoc();
      }
    }
    ?>
    <div class="user-panel">
        <div class="pull-left image">
          <img src="../images/icon-2.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $name['name']; ?></p>
          <a><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">REPORTS</li>
        <li class=""><a href="home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>