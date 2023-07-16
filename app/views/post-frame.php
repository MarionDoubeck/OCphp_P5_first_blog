<div class="container px-4 px-lg-5 mt-5 mb-5 border p-3">
    <div class="d-flex mb-4">
        <h3 class="text-left">
            <?= $str ?>
            <span class="font-weight-light" style="padding-left:30px; margin-top:20px; font-size: .85rem">Cree le : <?= $created_at ?></span>
        </h3>
    </div>
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="d-flex gap-3">
            <?php if (!empty($imageData) && !empty($imageType)): ?>
                <img src="data:<?= $imageType ?>;base64,<?= $imageData ?>" style="max-width: 200px;" alt="Image de l'article">
            <?php endif ;?>
            <p><?= htmlspecialchars($chapo) ?></p>
        </div>
        <button style="width:fit-content;"><a href="index.php?action=article&id=<?= $post->getIdentifier() ?>">Lire plus...</a></button>
    </div>
</div>