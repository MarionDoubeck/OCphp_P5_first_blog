<?php 
use App\services\Session;
use App\helpers\Helpers;
include 'header.php'; ?>

<div class="container">
    <!-- Article details -->
    <h2><?= htmlspecialchars($str) ?></h2>
    <p>Auteur: <?= htmlspecialchars($author) ?></p>
    <p>Dernière mise à jour: <?= htmlspecialchars($created_at) ?></p>
    <?php if (!empty($imageData) && !empty($imageType)): ?>
        <img src="data:<?= htmlspecialchars(htmlspecialchars($imageType)) ?>;base64,<?= htmlspecialchars(htmlspecialchars($imageData)) ?>" style="max-width: 600px;" alt="Image de l'article">
    <?php endif ;?>
    <p><?= htmlspecialchars($chapo) ?></p>
    <p><?= htmlspecialchars($content) ?></p>
</div>

<div class="container">
    <!-- Comments -->
    <h3>Commentaires</h3>
    <ul>
        <?php 
        foreach ($comments as $comment): 
            $commentAuthor=$comment->getUsername();
            $commentContent=$comment->getComment();
            ?>
            <li>
                <strong><?= htmlspecialchars($commentAuthor) ?>:</strong>
                <?= htmlspecialchars($commentContent) ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php if (session_status() === PHP_SESSION_DISABLED || !Session::isParamSet('csrf_token')): ?>
        <!-- User not logged in -->
        <p>Veuillez vous connecter pour poster un commentaire.</p>
        <a href="index.php?action=login" class="btn">Se connecter</a>
    <?php else: ?>
        <!-- User logged in -->
        <h5>Ajouter un commentaire</h4>
        <?php 
        $helper = new Helpers;
        $helper->generateCsrfToken();
        ?>
        <form method="post" action="index.php?action=addComment&id=<?= htmlspecialchars($post->getIdentifier())?>" class="d-flex row gap-3" style="max-width:400px;">
            <label>Commentaire</label>
            <textarea name="commentContent" rows="6"></textarea>
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Session::get('csrf_token')) ?>">
            <button type="submit">Soumettre</button>
        </form>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
