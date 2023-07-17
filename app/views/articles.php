<?php
/* use App\controllers\PostController;

$postController = new PostController();
$posts = $postController->getAllPosts(); */

include 'header.php'; ?>

<div class="container">
    <h2>Liste des articles</h2>
    <?php foreach ($posts as $post){
        $str = htmlspecialchars($post->getTitle());
        // Supprimez les accents
        $str = preg_replace('/[\p{M}]/u', '', Normalizer::normalize($str, Normalizer::FORM_D));
        $created_at = htmlspecialchars($post->getFrenchCreationDate());
        $chapo = htmlspecialchars($post->getChapo());
        $imageData = $post->getImageData();
        $imageType = $post->getImageType();
        require 'post-frame.php';
    }?>
</div>

<?php include 'footer.php'; ?>
