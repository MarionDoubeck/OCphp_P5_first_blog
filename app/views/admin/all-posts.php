<?php
use App\Models\Post;
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
                    <?php foreach ($posts as $post) : 
                      $title = htmlspecialchars($post->getTitle());
                      //No accents in title with this font
                      $title = preg_replace('/[\p{M}]/u', '', \Normalizer::normalize($title, \Normalizer::FORM_D));
                      $created_at = htmlspecialchars($post->getFrenchCreationDate());
                      $modified_at = htmlspecialchars($post->getFrenchModificationDate());
                      $id = $post->getIdentifier();
                      $nbOfComments=$newPost->retrieveNumberOfComments($id);
                    ?>
                    <tr>
                        <td><?= $title ?></td>
                        <td><?= $created_at ?></td>
                        <td><?= $modified_at ?></td>
                        <td><?= $nbOfComments ?></td>
                        <td>
                            <div style="width:100%; display:flex; justify-content: space-around;">
                              <a href=# class="btn btn-success" target="_blank">Voir</a>
                              <a href=# class="btn btn-primary" >Modifier</a>
                              <?php generateCsrfToken();?>
                              <form  method="post" style="display: inline;">
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
