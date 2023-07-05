<?php
use App\controllers\PostController;
$postController = new PostController();
$posts = $postController->getAllPosts();

include 'header.php'; ?>

<div class="container">
    <h2>Liste des articles</h2>
    <?php foreach ($posts as $post){
        require 'post-frame.php';
    }?>
</div>

<?php include 'footer.php'; ?>
