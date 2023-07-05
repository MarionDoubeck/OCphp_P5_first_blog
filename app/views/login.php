<?php
use App\controllers\UserController;

$userController = new UserController();

//check if user has just registered
if (session_status()!= PHP_SESSION_NONE && isset($_SESSION['registration_message'])) {
    echo "<script>alert('" . $_SESSION['registration_message'] . "');</script>";
    unset($_SESSION['registration_message']); //Remove the message from the session to prevent it from being displayed again upon page reload.
}

// Process the login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userController->login();
}
?>

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
