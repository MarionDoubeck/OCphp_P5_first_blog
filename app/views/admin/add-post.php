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
            <h3 class="card-title">Nouvel article</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
                <!-- Form containing the editor textarea -->
                <?php $helper->generateCsrfToken(); ?>
                <form id="editor-form" method="post" enctype="multipart/form-data" action="index.php?action=adminAddPost">
                    <div class="form-group">
                        <label for="title">Titre</label>
                        <input class="form-control" type="text" name="title" id="title">
                    </div>
                    <div class="form-group">
                        <label for="image">Image de l'article (Max 2Mo)</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/gif" maxlength="500000">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="chapo">Chapo (Max 255 caractères)</label>
                        <textarea class="form-control" name="chapo" id="chapo" maxlength="255"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="content">Contenu de l'article</label>
                        <textarea class="form-control" name="content" id="content"></textarea>
                    </div>
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Session::get('csrf_token')) ?>">
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

<?php $helper->renderView('app/views/admin/dashboard-scripts.php',[]);?>

</body>
</html>
