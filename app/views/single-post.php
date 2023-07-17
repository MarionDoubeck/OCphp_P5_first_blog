<?php 
use App\services\Session;
include 'header.php'; ?>

<div class="container">
    <!-- Article details -->
    <h2><?= esc_html($str) ?></h2>
    <p>Auteur: <?= esc_html($author) ?></p>
    <p>Dernière mise à jour: <?= esc_html($created_at) ?></p>
    <?php if (!empty($imageData) && !empty($imageType)): ?>
        <img src="data:<?= esc_html(esc_html($imageType)) ?>;base64,<?= esc_html(esc_html($imageData)) ?>" style="max-width: 600px;" alt="Image de l'article">
    <?php endif ;?>
    <p><?= esc_html($chapo) ?></p>
    <p><?= esc_html($content) ?></p>
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
                <strong><?= esc_html($commentAuthor) ?>:</strong>
                <?= esc_html($commentContent) ?>
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
        <?php generateCsrfToken();?>
        <form method="post" action="index.php?action=addComment&id=<?= esc_html($post->getIdentifier())?>" class="d-flex row gap-3" style="max-width:400px;">
            <label>Commentaire</label>
            <textarea name="commentContent" rows="6"></textarea>
            <input type="hidden" name="csrf_token" value="<?= esc_html(Session::get('csrf_token')) ?>">
            <button type="submit">Soumettre</button>
        </form>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
