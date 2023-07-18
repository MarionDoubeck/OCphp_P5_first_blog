<?php
use App\services\Session;
use App\services\Helpers;
use App\services\PostGlobal;

$helper = new Helpers;
$helper->renderView('app/views/header.php',[]);
?>

<div class="container">
    <h2>S'enregistrer</h2>

    <?php
    if (empty($data['errors']) === FALSE) { ?>
        <div class="alert alert-danger" role="alert">
        <?php
        foreach ($data['errors'] as $error) { ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php } ?>
        </div>
    <?php } ?>

    <?php $helper->generateCsrfToken();?>
    <form method="post">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= PostGlobal::isParamSet('email') === TRUE ? htmlspecialchars(PostGlobal::get('email')) : '' ?>" required>

        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" id="username" value="<?= PostGlobal::isParamSet('username') === TRUE ? htmlspecialchars(PostGlobal::get('username')) : '' ?>" required>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>

        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Session::get('csrf_token')) ?>">
        <button type="submit">S'enregistrer</button>
    </form>
</div>

<?php $helper->renderView('app/views/footer.php',[]);
