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
                <h3 class="card-title">Tous les articles publiés sur le blog</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <!-- <th>Id</th> -->
                    <th>Titre</th>
                    <th>Date de création</th>
                    <th>Dernière modification</th>
                    <th>Nombre de commentaires</th>
                    <th class="th-vide"></th>
                  </tr>
                  </thead>
                  <tbody>
                    <!-- Loop through posts data and display each post in a row -->
                    <?php foreach ([1,2,3,4] as $post) : ?>
                    <tr>
                        <td><?= 'TITRE' ?></td>
                        <td><?= 'CREE LE' ?></td>
                        <td><?= 'MODIFIE LE' ?></td>
                        <td><?= 'NB DE COMMENTAIRES' ?></td>
                        <td>
                            <div style="width:100%; display:flex; justify-content: space-around;">
                              <a href=# class="btn btn-success" target="_blank">Voir</a>
                              <a href=# class="btn btn-primary" >Modifier</a>
                              <?php generateCsrfToken();?>
                              <form action="delete-post.php" method="post" style="display: inline;">
                                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                <button type="submit" class="btn btn-danger" onclick="confirmDelete(event)">Supprimer</button>
                              </form>
                            </div>
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
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="../admin/dist/js/adminlte.min.js"></script>

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

  function confirmDelete(event) {
      if (confirm('Êtes-vous sûr de vouloir supprimer cet article et tous ses commentaires ?')) {
          // User confirmed the deletion, proceed with the form submission
          document.getElementById('delete-form').submit();
      } else {
          // User canceled the deletion, prevent form submission
          event.preventDefault();
      }
  }
</script>
</body>
</html>
