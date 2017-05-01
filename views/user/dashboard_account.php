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
            <h3>Overview</h3>
            <div class="well"> 
              <h3>Account details</h3>
              <table class="table">
                <tr>
                  <th width="20%">Name</th>
                  <td>: Ujang</td>
                </tr>
                <tr>
                  <th>Email</th>
                  <td>: Ujang@gmail.com</td>
                </tr>
                <tr>
                  <th>Phone</th>
                  <td>: 08241231232</td>
                </tr>
                <tr>
                  <th>Type Account</th>
                  <td>: Free</td>
                </tr>
              </table>
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
<?php include 'footer.php';