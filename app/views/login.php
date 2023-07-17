<?php
use App\services\Session;
use App\helpers\Helpers;

$helper = new Helpers;
$helper->renderView('app/views/header.php',[]);
?>

<div class="container">
<h2>Login</h2>

<?php $helper->generateCsrfToken();?>

<form method="post">
    <label for="username">Username</label>
    <input type="text" name="username" id="username" required>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required>

    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Session::get('csrf_token')) ?>">
    <button type="submit">Login</button>
</form>
</div>
<?php $helper->renderView('app/views/footer.php',[]); ?>
