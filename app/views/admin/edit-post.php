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
                <h3 class="card-title">Nouvel article</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                    <!-- Form containing the editor textarea -->
                    <?php generateCsrfToken();?>
                    <form id="editor-form" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Titre</label>
                            <input class="form-control" type="text" name="title" id="title" value="<?= 'TITRE' ?>">
                        </div>

                        <!-- Image -->
                        <?php $ilyauneimage=false;?>
                        <?php if ($ilyauneimage): ?>
                          <div class="form-group">
                            <label>Image actuelle :</label>
                            <img src="data:<?= $post['image_type']?>;base64,<?= base64_encode($post['image_data']) ?>" style="max-width: 200px;" alt="Image de l'article">
                          </div>
                          <div class="form-group">
                            <label for="delete_image">Supprimer l'image actuelle</label>
                            <input type="checkbox" name="delete_image" id="delete_image" value="1">
                          </div>
                          <div class="form-group">
                                    <label for="image">Remplacer l'image de l'article (Max 2Mo)</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/gif" maxlength="500000">
                                        </div>
                                    </div>
                                </div>
                          <?php else : ?>
                            <div class="form-group">
                                <label for="image">Définir l'image de l'article (Max 2Mo)</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/gif" maxlength="500000">
                                    </div>
                                </div>
                            </div>
                          <?php endif; ?>

                        
                        <div class="form-group">
                            <label for="chapo">Chapo (Max 255 caractères)</label>
                            <textarea class="form-control" name="chapo" id="chapo" maxlength="255"><?= 'chapo' ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="content">Contenu de l'article</label>
                            <textarea class="form-control" name="content" id="content"><?= 'content'?></textarea>
                        </div>
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="submit" value="Publier">
                    </form>
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
<!-- AdminLTE App -->
<script src="../admin/dist/js/adminlte.min.js"></script>
<!-- Page specific script -->
<script src="../admin/plugins/add-post/add-post.js"></script>


</body>
</html>