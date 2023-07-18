<?php
namespace App\Models;

use App\db\DatabaseConnection;

/**
 * Comment class
 */
class Comment
{
    /**
     * Username of the editor of the comment
     *
     * @var string
     */
    private string $username;

    /**
     * Comment date modification
     *
     * @var string
     */
    private string $frenchCreationDate;

    /**
     * Detail of the comment
     *
     * @var string
     */
    private string $comment;

    /**
     * Comment id
     *
     * @var int
     */
    private int $identifier;

    /**
     * Post id
     *
     * @var int
     */
    private int $postId;

    /**
     * Post title
     *
     * @var string
     */
    private string $postTitle;

    // Connect to the data base.
    public DatabaseConnection $connection;

    /**
     * Method to retrieve comments associated with post id
     *
     * @param int $postId The post we want the comments of
     *
     * @return array
     */
    public function getComments(int $postId) : array
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT comments.*, users.username FROM comments 
            INNER JOIN users ON comments.author_id = users.id 
            WHERE post_id = ? AND comments.status = 'approved' 
            ORDER BY comments.creation_date DESC"
        );

        $statement->execute([$postId]);

        $comments = [];
        while (($row = $statement->fetch())) {
            $comment = new Comment();
            $comment->setUsername($row['username']);
            $comment->setFrenchCreationDate($row['creation_date']);
            $comment->setComment($row['content']);
            $comment->setIdentifier($row['id']);
            $comment->setPost($row['post_id']);

            $comments[] = $comment;
        }

        return $comments;
    }


    /**
     * Method to add a new comment
     *
     * @param int    $postId The post to comment 
     * @param int    $user_id The author's user Id
     * @param string $comment The content of the comment
     *
     * @return boolean
     */
    public function createComment(int $postId, int $user_id, string $comment) : bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'INSERT INTO comments(post_id, author_id, content, creation_date, status) 
            VALUES(?, ?, ?, NOW(), ?)'
        );
        $affectedLines = $statement->execute([$postId, $user_id, $comment, 'pending']);

        return($affectedLines > 0);
    }

    /**
     * Method to delete a comment
     *
     * @param int $identifier Comment's Id
     *
     * @return boolean
     */
    public function deleteComment(int $identifier)
    {
        $statement = $this->connection->getConnection()->prepare(
            'DELETE FROM comments WHERE id=?'
        );
        $affectedLines = $statement->execute([$identifier]);
        return($affectedLines > 0);
    }

    /**
     * Method to delete all  comments of a post
     *
     * @param int $postId PostID
     *
     * @return boolean
     */
    public function deleteAllComments(int $postId)
    {
        $query = 'DELETE FROM comments WHERE post_id= :postId';
        $statement = $this->connection->getConnection()->prepare($query);
        $statement->bindParam(':postId', $postId);
        $affectedLines = $statement->execute();
        return($affectedLines > 0);
    }

    /**
     * Method to validate a comment
     *
     * @param int $identifier CommentId
     *
     * @return boolean
     */
    public function validateComment(int $identifier)
    {
        $statement = $this->connection->getConnection()->prepare(
            "UPDATE comments SET status = 'approved' WHERE id = :identifier"
        );
        $statement->bindParam(':identifier', $identifier);
        $affectedLines = $statement->execute();
        return($affectedLines > 0);
     }


    /**
     * Method to retrieve unvalidated comments
     *
     * @return array
     */
    public function getCommentsStatus($status)
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT c.*, u.username, p.title
            FROM comments c
            JOIN users u ON c.author_id = u.id
            JOIN posts p ON c.post_id = p.id
            WHERE c.status = :status"
        );
        $statement->bindParam(':status', $status);
        $statement->execute();

        $comments = [];
        while (($row = $statement->fetch())) {
            $comment = new Comment();
            $comment->setFrenchCreationDate($row['creation_date']);
            $comment->setComment($row['content']);
            $comment->setIdentifier($row['id']);
            $comment->setPost($row['post_id']);
            $comment->setPostTitle($row['title']);
            $comment->setUserName($row['username']);
            $comment->setIdentifier($row['id']);

            $comments[] = $comment;
        }
        return $comments;
    }

    /**
     * Get the value of frenchCreationDate
     * 
     * @return string
     */
    public function getFrenchCreationDate()
    {
        return $this->frenchCreationDate;
    }


    /**
     * Set the value of frenchCreationDate
     * 
     * @param string $frenchCreationDate CreationDate
     *
     * @return self
     */
    public function setFrenchCreationDate($frenchCreationDate)
    {
        $this->frenchCreationDate = $frenchCreationDate;

        return $this;
    }


    /**
     * Get the content of comment
     * 
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }


    /**
     * Set the value of comment
     *
     * @return self
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }


    /**
     * Get the value of comment Id
     * 
     * @return int
     */ 
    public function getIdentifier()
    {
        return $this->identifier;
    }


    /**
     * Set the value of comment Id
     *
     * @return self
     */ 
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }


    /**
     * Get the value of postId
     * 
     * @return int
     */ 
    public function getPost()
    {
        return $this->postId;
    }


    /**
     * Set the id of post
     *
     * @return self
     */ 
    public function setPost($postId)
    {
        $this->postId = $postId;

        return $this;
    }


    /**
     * Get the value of post title
     * 
     * @return string
     */ 
    public function getPostTitle()
    {
        return $this->postTitle;
    }


    /**
     * Set the value of post title
     *
     * @return self
     */ 
    public function setPostTitle($postTitle)
    {
        $this->postTitle = $postTitle;

        return $this;
    }


    /**
     * Get the value of username
     * 
     * @return string
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }
}