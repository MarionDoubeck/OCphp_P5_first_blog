<?php

namespace App\Models;

use App\db\DatabaseConnection;
use Exception;

/**
 * Post class
 */
class Post
{
    /**
     * Post title
     *
     * @var string
     */
    private string $title;

    /**
     * Post date 
     *
     * @var string
     */
    private string $frenchCreationDate;

    /**
     * Post modification date 
     *
     */
    private $frenchModificationDate;


    /**
     * Post content
     *
     * @var string
     */
    private string $content;

    /**
     * Post chapo
     *
     * @var string
     */
    private string $chapo;

    /**
     * Post indentifier
     *
     * @var string
     */
    private int $identifier;
    
    /**
     * User's nickname
     *
     * @var string
     */
    private string $username;

    
    private $imageData;
    private $imageType;


    //Connect to the database
    public DatabaseConnection $connection;

    /**
     * Method to retrieve data from a single article according to its id
     *
     * @param int $identifier
     *
     * @return Post
     */
    
    public function getPost(int $postId) : Post
    {
        // Prepare the SQL query
        $query = "SELECT p.*, u.username FROM posts p INNER JOIN users u ON p.author_id = u.id WHERE p.id = :postId";
        $statement = $this->connection->getConnection()->prepare($query);
        $statement->bindParam(':postId', $postId);
        $statement->execute();
        // Fetch the post record
        $row = $statement->fetch();

        $post = new Post();
        if ($row) {
            $post->setTitle($row['title']);
            $post->setFrenchCreationDate($row['created_at']);
            $post->setFrenchModificationDate($row['updated_at']);
            $post->setContent($row['content']);
            $post->setIdentifier($row['id']);
            $post->setChapo($row['chapo']);
            $post->setUsername($row['username']);
            $post->setImageData($row['image_data']);
            $post->setImageType($row['image_type']);
            return $post;
        } else {
            throw new Exception('Cette page n\'existe pas');
        }
            
    }

    /**
     * Method to retrieve data from a single article according to its id
     *
     * @param int $identifier
     *
     * @return int
     */
    public function retrieveNumberOfComments(int $postId)
    {
        $query = "SELECT COUNT(*) as total_comments FROM comments WHERE post_id = :postId";
        $statement = $this->connection->getConnection()->prepare($query);
        $statement->bindParam(':postId', $postId);
        $statement->execute();
        // Fetch the post record
        $row = $statement->fetch();
        $total = $row['total_comments'] ?? 0;

        return $total;
    }





    /**
     * Method to retrieve data from  all articles
     *
     * @return array
     */
    public function getPosts() : array
    {
        // Query to retrieve all posts
        $query = "SELECT p.*, u.username FROM posts p INNER JOIN users u ON p.author_id = u.id ORDER BY updated_at DESC";
        $statement = $this->connection->getConnection()->query($query);

        $posts = [];

        while (($row = $statement->fetch())) {
            $post = new Post();
            $post->setTitle($row['title']);
            $post->setFrenchCreationDate($row['created_at']);
            $post->setFrenchModificationDate($row['updated_at']);
            $post->setIdentifier($row['id']);
            $post->setChapo($row['chapo']);
            $post->setUsername($row['username']);
            $post->setImageData($row['image_data']);
            $post->setImageType($row['image_type']);

            $posts[] = $post;
        }
        
        return $posts;
    }



    /**
     * Method to retrieve data from last 3 articles
     * 
     * @return array
     */
    public function getRecentPosts() : array
    {
        // Query to retrieve all posts
        $query = "SELECT p.*, u.username FROM posts p INNER JOIN users u ON p.author_id = u.id ORDER BY created_at DESC LIMIT 3";
        $statement = $this->connection->getConnection()->query($query);

        $posts = [];

        while (($row = $statement->fetch())) {
            $post = new Post();
            $post->setTitle($row['title']);
            $post->setFrenchCreationDate($row['created_at']);
            $post->setFrenchModificationDate($row['updated_at']);
            $post->setIdentifier($row['id']);
            $post->setChapo($row['chapo']);
            $post->setUsername($row['username']);
            $post->setImageData($row['image_data']);
            $post->setImageType($row['image_type']);

            $posts[] = $post;
        }
        
        return $posts;
    }

    /**
     * Method to add data of a new post
     *
     * @param string $title
     * @param string $content
     * @param string $chapo
     * @param int    $user_id
     *
     * @return boolean
     */


    public function addPost(string $title, string $content, string $chapo,
        int $user_id
    ) {
       
            $statement = $this->connection->getConnection()->prepare(
                'INSERT INTO posts( title, content, chapo, author_id, created_at) 
                VALUES(?, ?, ?, ?, NOW())'
            );
            $affectedLines = $statement->execute(
                [$title, $content, $chapo,
                $user_id]
            );
    
            return($affectedLines > 0);
        
    }


    /**
     * Method to update data of a post
     *
     * @param int    $identifier
     * @param string $content
     * @param string $title
     * @param string $chapo
     * 
     * @return void
     */


    public function updatePost(int $identifier, string $content, string $title,
        string $chapo
    ) {
        $statement = $this->connection->getConnection()->prepare(
            'UPDATE posts SET  content=?, title=?, chapo=?, created_at=NOW() 
            WHERE id=?'
        );
       
        $affectedLines = $statement->execute(
            [$content, $title, $chapo,
            $identifier]
        );
       
        return($affectedLines > 0);
        
    }


    /**
     * Method to delete data of a post
     *
     * @param int $identifier
     * 
     * @return void
     */


    public function deletePost(int $identifier)
    {
        $statement = $this->connection->getConnection()->prepare(
            'DELETE FROM posts WHERE id=?'
        );
        $affectedLines = $statement->execute([$identifier]);
        return($affectedLines > 0);
    }
    

    /**
     * Get post title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set post title
     *
     * @param string $title post title
     *
     * @return self
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get post date
     *
     * @return string
     */
    public function getFrenchCreationDate()
    {
        return $this->frenchCreationDate;
    }

        /**
     * Get post modification date
     *
     * @return string
     */
    public function getFrenchModificationDate()
    {
        return $this->frenchModificationDate;
    }


    /**
     * Get image data
     *
     * @return string
     */
    public function getImageData()
    {
        return $this->imageData;
    }
    /**
     * Set image data
     *
     * @param  $imageData post image data
     *
     * @return self
     */ 
    public function setImageData( $imageData)
    {
        if ($imageData !== null) {
            $this->imageData = base64_encode($imageData);
        } else{
            $this->imageData = null;
        }
        return $this;
    }
    /**
     * Get image type
     *
     * @return string
     */
    public function getImageType()
    {
        return $this->imageType;
    }
    /**
     * Set image type
     *
     * @param $imageType post image type
     *
     * @return self
     */ 
    public function setImageType($imageType)
    {
        $this->imageType = $imageType;

        return $this;
    }
    /**
     * Set post date
     *
     * @param string $frenchCreationDate post date
     *
     * @return self
     */ 
    public function setFrenchCreationDate(string $frenchCreationDate)
    {
        $this->frenchCreationDate = $frenchCreationDate;

        return $this;
    }
    /**
     * Set post modification date
     *
     * @param string $frenchModificationDate post date
     *
     * @return self
     */ 
    public function setFrenchModificationDate(string $frenchModificationDate)
    {
        $this->frenchModificationDate = $frenchModificationDate;

        return $this;
    }

    /**
     * Get post content
     *
     * @return string
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set post content
     *
     * @param string $content post content
     *
     * @return self
     */ 
    public function setContent(string $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get post chapo
     *
     * @return string
     */ 
    public function getChapo()
    {
        return $this->chapo;
    }

    /**
     * Set post chapo
     *
     * @param string $chapo post chapo
     *
     * @return self
     */ 
    public function setChapo(string $chapo)
    {
        $this->chapo = $chapo;

        return $this;
    }

    /**
     * Get post id
     *
     * @return int
     */ 
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set post id
     *
     * @param int $identifier post id
     *
     * @return self
     */ 
    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get the value of firstname
     * 
     * @return string
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Get user's nickname
     *
     * @return string
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set user's nickname
     *
     * @param string $username user's nickname
     *
     * @return self
     */ 
    public function setUsername(string $username)
    {
        $this->username = $username;

        return $this;
    }
}
