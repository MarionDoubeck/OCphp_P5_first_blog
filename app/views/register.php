<?php
use App\controllers\UserController;

$userController = new UserController();

// Process the registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userController->register();
}
?>

<?php include 'header.php'; ?>

<div class="container">
<h2>S'enregistrer</h2>

<?php generateCsrfToken();?>
<form method="post" action="register.php">
    <label for="last_name">Nom</label>
    <input type="text" name="last_name" id="last_name" required>

    <label for="firt_name">Prénom</label>
    <input type="text" name="first_name" id="first_name" required>

    <label for="email">Email</label>
    <input type="email" name="email" id="email" required>

    <label for="username">Nom d'utilisateur</label>
    <input type="text" name="username" id="username" required>

    <label for="password">Mot de passe</label>
    <input type="password" name="password" id="password" required>

    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
    <button type="submit">S'enregistrer</button>
</form>
</div>
<?php include 'footer.php'; ?>

