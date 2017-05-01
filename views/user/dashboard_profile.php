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
            <h3>Profile</h3>
            <div class="well"> 
              <form action="">
                  <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="name" class="form-control" id="name" placeholder="Enter Name" name="name" value="Ujang">
                  </div>
                  <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="****">
                  </div>
                  <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="phone" class="form-control" id="phone" placeholder="Enter phone" name="phone" value="02321323">
                  </div>
                  <button type="submit" class="btn btn-default">Update</button>
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
