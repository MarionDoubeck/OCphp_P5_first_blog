<div class="container px-4 px-lg-5 mt-5 mb-5 border p-3">
    <div class="d-flex mb-4">
        <h3 class="text-left">
            <?php 
                $str = htmlspecialchars($post['title']) ;
                //remove accents
                $str = preg_replace('/[\p{M}]/u', '', Normalizer::normalize($str, Normalizer::FORM_D));
                echo $str;
            ?>
            <span class="font-weight-light" style="padding-left:30px; margin-top:20px; font-size: .85rem">Cree le : <?= htmlspecialchars($post['created_at']) ?></span>
        </h3>
    </div>
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="d-flex gap-3">
            <?php if (!empty($post['image_data']) && !empty($post['image_type'])): ?>
                <img src="data:<?= $post['image_type']?>;base64,<?= base64_encode($post['image_data']) ?>" style="max-width: 200px;" alt="Image de l'article">
            <?php endif ;?>
            <p><?= htmlspecialchars($post['chapo']) ?></p>
        </div>
        <button style="width:fit-content;"><a href="/index.php?controller=post&action=show&id=<?= urlencode($post['id']) ?>">Lire plus...</a></button>
    </div>
</div>