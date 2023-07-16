<?php
require_once __DIR__ .'../../../helpers/csrf.php';

include 'dashboard-header-and-menu.php';
?>


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Tous les commentaires publiés sur le blog</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <!-- <th>Id</th> -->
                    <th>Post concerné</th>
                    <th>Date de création</th>
                    <th>Auteur</th>
                    <th>Contenu</th>
                    <th class="th-vide"></th>
                  </tr>
                  </thead>
                  <tbody>
                    <!-- Loop through posts data and display each post in a row -->
                    <?php foreach ([1,2,3,4] as $comment) : ?>
                    <tr>
                        <td><?= 'TITRE'?></td>
                        <td><?= 'CREE LE'?></td>
                        <td><?= 'AUTEUR' ?></td>
                        <td><?= 'CONTENU' ?></td>
                        <td>
                            <?php generateCsrfToken();?>
                            <form  method="post" style="display: inline;">
                              <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                              <button type="submit" class="btn btn-danger" onclick="confirmDelete(event)">Supprimer</button>
                            </form>
                        </td>
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
