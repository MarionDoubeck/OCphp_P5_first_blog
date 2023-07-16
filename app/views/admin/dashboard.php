<?php include 'dashboard-header-and-menu.php'; ?>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <p>Articles</p>
                </div>
                <ul class="card-body nav nav-sidebar flex-column">
                <li><a href="/app/views/admin/all-posts.php" class="nav-link">Tous les articles</a></li>
                <li><a href="/app/views/admin/add-post.php" class="nav-link">Nouvel article</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <p>Commentaires</p>
                </div>
                <ul class="card-body nav nav-sidebar flex-column">
                <li><a href="/app/views/admin/pending-comments.php" class="nav-link">Commentaires en attente de validation</a></li>
                <li><a href="/app/views/admin/validated-comments.php" class="nav-link">Tous les commentaires publiés</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <p>Utilisateurs</p>
                </div>
            <ul class="card-body nav nav-sidebar flex-column">
              <li><a href="/app/views/admin/all-users.php" class="nav-link">Tous les utilisateurs</a></li>
            </ul>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="app/views/admin/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="app/views/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="app/views/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- jQuery Knob Chart -->
<script src="app/views/admin/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="app/views/admin/plugins/moment/moment.min.js"></script>
<script src="app/views/admin/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="app/views/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="app/views/admin/plugins/summernote/summernote-bs4.min.js"></script>

<!-- AdminLTE App -->
<script src="app/views/admin/dist/js/adminlte.js"></script>


</body>
</html>
