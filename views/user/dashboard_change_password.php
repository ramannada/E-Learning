<?php include 'header_dashboard.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="container">
        <div class="row">
          <div class="col-lg-3">
            <ul class="list-group">
              <li class="list-group-item"><a href="dashboard_account.php">Overview</a></li>
              <li class="list-group-item"><a href="dashboard_profile.php">Profile</a></li>
              <li class="list-group-item"><a href="dashboard_change_password.php">Change password</a></li>
            </ul>
          </div>
          <div class="col-lg-9">
            <h3>Change Your Password</h3>
            <div class="well"> 
              <form action="">
                  <div class="form-group">
                    <label for="pwd">Current Password:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" va>
                  </div>
                  <div class="form-group">
                    <label for="pwd">New Password:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" va>
                  </div>
                  <div class="form-group">
                    <label for="pwd">Retype New Password:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" va>
                  </div>
                  <button type="submit" class="btn btn-default">Change</button>
                </form>

            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include 'footer.php';