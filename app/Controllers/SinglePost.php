<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\db\DatabaseConnection;
use App\services\Helpers;

/**
 * SinglePost class
 * To display a post on the blog page
 */
class SinglePost
{


     /**
      * Method in charge of displaying one post and its comments
      *
      * @param int $identifier Post Id
      *
      * @return void
      */
    public function execute(int $identifier)
    {
        $connection = new DatabaseConnection();

        $postRepository = new Post();
        $commentRepository = new Comment();
        $postRepository->connection = $connection;
        $commentRepository->connection = $connection;
        $post = $postRepository->getPost($identifier);
        $comments = $commentRepository->getComments($identifier);

        // Prepare post's data for display.
        $title = htmlspecialchars($post->getTitle());
        // No accents in title with this font.
        $title = preg_replace('/[\p{M}]/u', '', \Normalizer::normalize($title, \Normalizer::FORM_D));
        $author = htmlspecialchars($post->getUsername());
        $created_at = htmlspecialchars($post->getFrenchCreationDate());
        $chapo = htmlspecialchars($post->getChapo());
        $content = htmlspecialchars($post->getContent());
        $imageData = $post->getImageData();
        $imageType = $post->getImageType();

        $helper = new Helpers;
        $helper->renderView('app/views/single-post.php',
        [
            'comments' => $comments,
            'post' => $post,
            'title' => $title,
            'author' => $author,
            'created_at' => $created_at,
            'chapo' => $chapo,
            'content' => $content,
            'imageData' => $imageData,
            'imageType' => $imageType,
        ]
        );

    }//end execute()


}//end class
