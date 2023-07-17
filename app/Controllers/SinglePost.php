<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\db\DatabaseConnection;
require_once 'app/helpers/csrf.php';

/**
 * SinglePost class
 * To display a post on the blog page
 */
class SinglePost
{
     /**
      * Method in charge of displaying one post and its comments
      *
      * @param int $identifier
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

        //Prepare post's data for display
        $str = esc_html($post->getTitle());
        //No accents in title with this font
        $str = preg_replace('/[\p{M}]/u', '', \Normalizer::normalize($str, \Normalizer::FORM_D));
        $author = esc_html($post->getUsername());
        $created_at = esc_html($post->getFrenchCreationDate());
        $chapo = esc_html($post->getChapo());
        $content = esc_html($post->getContent());
        $imageData = $post->getImageData();
        $imageType = $post->getImageType();

        include 'app/views/single-post.php';
    }


}
