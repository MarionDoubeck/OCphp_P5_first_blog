<?php
use App\services\Session;
use App\services\Helpers;

$helper = new Helpers;
$helper->renderView('app/views/admin/dashboard-header-and-menu.php',[]);
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
                    <?php foreach ($comments as $comment) :
                        $commentPost = $comment->getPost();
                        $commentPostTitle = $comment->getPostTitle();
                        $commentDate = $comment->getFrenchCreationDate();
                        $commentAuthor = $comment->getUsername();
                        $commentContent = $comment->getComment();
                        $commentId = $comment->getIdentifier();
                        ?>
                    <tr>
                        <td><?= htmlspecialchars($commentPost.' : '.$commentPostTitle) ?></td>
                        <td><?= htmlspecialchars($commentDate)?></td>
                        <td><?= htmlspecialchars($commentAuthor) ?></td>
                        <td><?= htmlspecialchars($commentContent)?></td>
                        <td>
                          <?php $helper->generateCsrfToken();?>
                            <form  method="post" action="index.php?action=deleteComment&id=<?= htmlspecialchars($commentId)?>" style="display: inline;">
                              <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Session::get('csrf_token')) ?>">
                              <button type="submit" class="btn btn-danger" onclick="confirmDelete(event)">Supprimer</button>
                            </form>
                        </td>
                  </tr>
                  <?php endforeach ; ?>
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

      <?php $helper->renderView('app/views/admin/dashboard-scripts.php',[]);?>

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
        // User confirmed the deletion, proceed with the form submission.
        document.getElementById('delete-form').submit();
    } else {
        // User canceled the deletion, prevent form submission.
        event.preventDefault();
    }
  }
</script>
</body>
</html>
