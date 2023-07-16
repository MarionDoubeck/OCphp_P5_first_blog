<?php include 'header.php'; ?>

<div class="container">
    <!-- Article details -->
    <h2><?= $str ?></h2>
    <p>Auteur: <?= $author ?></p>
    <p>Dernière mise à jour: <?= $created_at ?></p>
    <?php if (!empty($imageData) && !empty($imageType)): ?>
        <img src="data:<?= $imageType ?>;base64,<?= $imageData ?>" style="max-width: 600px;" alt="Image de l'article">
    <?php endif ;?>
    <p><?= $chapo ?></p>
    <p><?= $content ?></p>
</div>

<div class="container">
    <!-- Comments -->
    <h3>Commentaires</h3>

    
</div>

<?php include 'footer.php'; ?>
