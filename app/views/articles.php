<?php
use App\helpers\Helpers;
$helper = new Helpers;
$helper->renderView('app/views/header.php',[]);
?>

<div class="container">
    <h2>Liste des articles</h2>
    <?php foreach ($posts as $post){
        $title = htmlspecialchars($post->getTitle());
        // Supprimez les accents
        $title = preg_replace('/[\p{M}]/u', '', Normalizer::normalize($title, Normalizer::FORM_D));
        $created_at = htmlspecialchars($post->getFrenchCreationDate());
        $chapo = htmlspecialchars($post->getChapo());
        $imageData = $post->getImageData();
        $imageType = $post->getImageType();
        $helper->renderView('app/views/post-frame.php',array(
            'post'=>$post,
            'title'=>$title,
            'created_at'=>$created_at,
            'chapo'=>$chapo,
            'imageData'=>$imageData,
            'imageType'=>$imageType
        ));
    }?>
</div>

<?php $helper->renderView('app/views/footer.php',[]); ?>
