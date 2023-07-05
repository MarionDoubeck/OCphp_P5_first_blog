<?php include 'header.php'; ?>
<div class="container">
<h2>Login</h2>

<?php generateCsrfToken();?>
<form method="post" action="login.php">
    <label for="username">Username</label>
    <input type="text" name="username" id="username" required>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required>

    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
    <button type="submit">Login</button>
</form>
</div>
<?php include 'footer.php'; ?>
