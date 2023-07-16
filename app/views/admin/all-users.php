<?php
include 'dashboard-header-and-menu.php';
?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Tous les utilisateurs du blog</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <!-- <th>Id</th> -->
                    <th>Nom d'utilisateur</th>
                    <th>Nombre de commentaires</th>
                    <th>Email</th>
                  </tr>
                  </thead>
                  <tbody>
                    <!-- Loop through posts data and display each post in a row -->
                    <?php foreach ($users as $user) : 
                        $username = $user->getUsername();
                        $email = $user->getEmail();
                        $commentCount = $user->getCommentCount();
                    ?>
                    <tr>
                        <td><?= $username ?></td>
                        <td><?= $commentCount?></td>
                        <td><?= $email ?></td>
                  </tr>
                  <?php endforeach ;?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
      
<?php include 'dashboard-scripts.php'; ?>

<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
