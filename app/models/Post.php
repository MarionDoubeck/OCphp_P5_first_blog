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
     * @var string
     */
    private $FrenchModificationDate;

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

    /**
     * Image data
     *
     * @var string
     */
    private $imageData;

    /**
     * Image type
     *
     * @var string
     */
    private $imageType;

    /**
     * Connexion to database
     *
     * @var DatabaseConnection
     */
    public DatabaseConnection $connection;


    /**
     * Method to retrieve data from a single article according to its id
     *
     * @param int $postId Post ID
     *
     * @return Post
     */
    public function getPost(int $postId) : Post
    {
        // Prepare the SQL query.
        $query = "SELECT p.*, u.username FROM posts p INNER JOIN users u ON p.author_id = u.id WHERE p.id = :postId";
        $statement = $this->connection->getConnection()->prepare($query);
        $statement->bindParam(':postId', $postId);
        $statement->execute();
        // Fetch the post record.
        $row = $statement->fetch();

        $post = new Post();
        if (empty($row) === FALSE) {
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

    }//end getPost()


    /**
     * Method to retrieve data from a single article according to its id
     *
     * @param int $postId PostId
     *
     * @return int
     */
    public function retrieveNumberOfComments(int $postId)
    {
        $query = "SELECT COUNT(*) as total_comments FROM comments WHERE post_id = :postId";
        $statement = $this->connection->getConnection()->prepare($query);
        $statement->bindParam(':postId', $postId);
        $statement->execute();
        // Fetch the post record.
        $row = $statement->fetch();
        $total = ($row['total_comments'] ?? 0);

        return $total;

    }//end retrieveNumberOfComments()


    /**
     * Method to retrieve data from  all articles
     *
     * @return array
     */
    public function getPosts() : array
    {
        // Query to retrieve all posts.
        $query = "SELECT p.*, u.username FROM posts p INNER JOIN users u ON p.author_id = u.id ORDER BY updated_at DESC";
        $statement = $this->connection->getConnection()->query($query);

        $posts = [];

        while (($row = $statement->fetch()) === TRUE) {
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

    }//end getPosts()


    /**
     * Method to retrieve data from last 3 articles
     *
     * @return array
     */
    public function getRecentPosts() : array
    {
        // Query to retrieve all posts.
        $query = "SELECT p.*, u.username FROM posts p INNER JOIN users u ON p.author_id = u.id ORDER BY created_at DESC LIMIT 3";
        $statement = $this->connection->getConnection()->query($query);

        $posts = [];

        while (($row = $statement->fetch()) === TRUE) {
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

    }//end getRecentPosts()


    /**
     * Method to add data of a new post
     *
     * @param string      $title      Title
     * @param string      $content    Content
     * @param string      $chapo      Chapo
     * @param int         $user_id    Author ID
     * @param string|null $image_data Image data
     * @param string|null $image_type Image type
     *
     * @return boolean
     */
    public function addPost(string $title, string $content, string $chapo, int $user_id, ?string $image_data, ?string $image_type)
    {
        $query = 'INSERT INTO posts (title, content, chapo, author_id, created_at, updated_at, image_data, image_type, comment_count) 
        VALUES (:title, :content, :chapo, :authorId, NOW(), NOW(), :imageData, :imageType, 0)';
        $statement = $this->connection->getConnection()->prepare($query);
        $statement->bindParam(':title', $title);
        $statement->bindParam(':content', $content);
        $statement->bindParam(':chapo', $chapo);
        $statement->bindParam(':authorId', $user_id);
        $statement->bindParam(':imageData', $image_data);
        $statement->bindParam(':imageType', $image_type);
        $affectedLines = $statement->execute();

        return($affectedLines > 0);

    }//end addPost()


    /**
     * Method to edit data of a new post
     *
     * @param int         $postId     PostID
     * @param string      $title      Title
     * @param string      $content    Content
     * @param string      $chapo      Chapo
     * @param string|null $image_data Image Data
     * @param string|null $image_type Image Type
     *
     * @return boolean
     */
    public function editPost(int $postId, string $content, string $title, string $chapo, ?string $image_data, ?string $image_type)
    {
        $query = 'UPDATE posts SET title = :title, content = :content, chapo = :chapo, updated_at = NOW(), image_data = :imageData, image_type = :imageType WHERE id = :postId';
        $statement = $this->connection->getConnection()->prepare($query);
        $statement->bindParam(':title', $title);
        $statement->bindParam(':content', $content);
        $statement->bindParam(':chapo', $chapo);
        $statement->bindParam(':imageData', $image_data);
        $statement->bindParam(':imageType', $image_type);
        $statement->bindParam(':postId', $postId);
        $affectedLines = $statement->execute();

        return ($affectedLines > 0);

    }//end editPost()


    /**
     * Method to delete data of a post
     *
     * @param int $identifier PostId
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

    }//end deletePost()


    /**
     * Get post title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;

    }//end getTitle()


    /**
     * Set post title
     *
     * @param string $title Post title
     *
     * @return self
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;

    }//end setTitle()


    /**
     * Get post date
     *
     * @return string
     */
    public function getFrenchCreationDate()
    {
        return $this->frenchCreationDate;

    }//end getFrenchCreationDate()


    /**
     * Get post modification date
     *
     * @return string
     */
    public function getFrenchModificationDate()
    {
        return $this->FrenchModificationDate;

    }//end getFrenchModificationDate()


    /**
     * Get image data
     *
     * @return string
     */
    public function getImageData()
    {
        return $this->imageData;

    }//end getImageData()


    /**
     * Set image data
     *
     * @param  $imageData post image data
     *
     * @return self
     */
    public function setImageData($imageData)
    {
        if ($imageData !== null) {
            $this->imageData = base64_encode($imageData);
        } else {
            $this->imageData = null;
        }

        return $this;

    }//end setImageData()


    /**
     * Get image type
     *
     * @return string
     */
    public function getImageType()
    {
        return $this->imageType;

    }//end getImageType()


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

    }//end setImageType()


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

    }//end setFrenchCreationDate()
    

    /**
     * Set post modification date
     *
     * @param string $FrenchModificationDate post date
     *
     * @return self
     */
    public function setFrenchModificationDate(string $FrenchModificationDate)
    {
        $this->FrenchModificationDate = $FrenchModificationDate;

        return $this;

    }//end setFrenchModificationDate()


    /**
     * Get post content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;

    }//end getContent()


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

    }//end setContent()


    /**
     * Get post chapo
     *
     * @return string
     */ 
    public function getChapo()
    {
        return $this->chapo;

    }//end getChapo()


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

    }//end setChapo()


    /**
     * Get post id
     *
     * @return int
     */ 
    public function getIdentifier()
    {
        return $this->identifier;

    }//end getIdentifier()


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

    }//end setIdentifier()


    /**
     * Get the value of firstname
     *
     * @return string
     */ 
    public function getFirstname()
    {
        return $this->firstname;

    }//end getFirstname()


    /**
     * Get user's nickname
     *
     * @return string
     */ 
    public function getUsername()
    {
        return $this->username;

    }//end getUsername()


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

    }//end setUsername()

  
}//end class
