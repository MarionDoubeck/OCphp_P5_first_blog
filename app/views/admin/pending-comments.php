<?php
use App\services\Session;
use App\models\Comment;
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
                <h3 class="card-title">Tous les commentaires en attente</h3>
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
                    <?php foreach ($comments as $comment) : 
                      $commentPost=$comment->getPost();
                      $commentPostTitle=$comment->getPostTitle();
                      $commentDate=$comment->getFrenchCreationDate();
                      $commentAuthor=$comment->getUsername();
                      $commentContent=$comment->getComment();
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($commentPost.' : '.$commentPostTitle) ?></td>
                        <td><?= htmlspecialchars($commentDate)?></td>
                        <td><?= htmlspecialchars($commentAuthor) ?></td>
                        <td><?= htmlspecialchars($commentContent)?></td>
                        <td>
                            <div style="width:100%; display:flex; justify-content: space-around;">
                              <?php generateCsrfToken();?>
                              <form method="post" style="display: inline;">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Session::get('csrf_token')) ?>">
                                <button type="submit" class="btn btn-success">Publier</button>
                              </form>
                              <?php generateCsrfToken();?>
                              <form  method="post" style="display: inline;">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Session::get('csrf_token')) ?>">
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
