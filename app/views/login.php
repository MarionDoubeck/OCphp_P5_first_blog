<?php
use App\services\Session;
include 'header.php'; ?>

<div class="container">
<h2>Login</h2>

<?php generateCsrfToken();?>
<form method="post">
    <label for="username">Username</label>
    <input type="text" name="username" id="username" required>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required>

    <input type="hidden" name="csrf_token" value="<?= esc_html(Session::get('csrf_token')) ?>">
    <button type="submit">Login</button>
</form>
</div>
<?php include 'footer.php'; ?>
