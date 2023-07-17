<?php
use App\helpers\Helpers;
$helper = new Helpers;
$helper->renderView('app/views/header.php',[]);
?>

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

<?php $helper->renderView('app/views/footer.php',[]); ?>
