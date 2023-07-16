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

    private int $post;

    //Connect to the data base
    public DatabaseConnection $connection;

    /**
     * Method to retrieve comments associated with post id
     *
     * @param string $post
     *
     * @return array
     */


    public function getComments(string $post): array
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT comments.*, users.username FROM comments 
            INNER JOIN users ON comments.author_id = users.id 
            WHERE post_id = ? AND comments.status = 'approved' 
            ORDER BY comments.creation_date DESC"
        );

        $statement->execute([$post]);

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
     * Method to retrieve unvalidated comments
     *
     * @return array
     */


    public function getUnvalidatedComments()
    {
        $statement= $this->connection->getConnection()->prepare(
            "SELECT comment, comment_id, post_id, DATE_FORMAT(commentDate, '%d-%m-%Y à %Hh%imin%ss') AS 
            french_creation_date FROM comments WHERE validation='n' "
        );
        $statement->execute();

        $comments = [];
        while (($row = $statement->fetch())) {
            $comment = new Comment();
            $comment->getFrenchCreationDate = $row['french_creation_date'];
            $comment->getComment = $row['comment'];
            $comment->getIdentifier = $row['comment_id'];
            $comment->getPost = $row['post_id'];

                $comments[] = $comment;
        }
        
            return $comments;
    }


    /**
     * Method to validate a comment
     *
     * @param int $identifier
     *
     * @return boolean
     */


    public function validatedComment(int $identifier)
    {
        $statement = $this->connection->getConnection()->prepare(
            "UPDATE comments SET  validation='y' WHERE comment_id=?"
        );
        $affectedLines = $statement->execute([$identifier]);

        return($affectedLines > 0);
    }


    /**
     * Method to delete a comment
     *
     * @param int $identifier
     *
     * @return boolean
     */


    public function deleteComment(int $identifier)
    {
        $statement = $this->connection->getConnection()->prepare(
            'DELETE FROM comments WHERE comment_id=?'
        );
        $affectedLines = $statement->execute([$identifier]);
        return($affectedLines > 0);
    }


    /**
     * Method to retrieve a single comment based on its id
     *
     * @param int $identifier
     *
     * @return Comment|null
     */


    public function getOneComment(int $identifier): ?Comment
    {
        $query = "SELECT c.*, u.username FROM comments c INNER JOIN users u ON c.author_id = u.id WHERE c.id = ?";
        /* $statement = $this->connection->getConnection()->prepare(
            "SELECT comments.comment_id, comments.comment, 
            DATE_FORMAT(comments.commentDate, '%d-%m-%Y à %Hh%imin%ss') AS 
            french_creation_date, comments.post_id, users.username FROM comments 
            INNER JOIN users ON comments.user_id = users.user_id 
            WHERE comments.comment_id = ?"
        ); */
        $statement = $this->connection->getConnection()->prepare($query);
        $statement->execute([$identifier]);

        $row = $statement->fetch();
        if ($row === false) {
            return null;
        }

        $comment = new Comment();
        $comment->getIdentifier = $row['id'];
        $comment->getUsername = $row['author_id'];
        $comment->getFrenchCreationDate = $row['creation_date'];
        $comment->getComment = $row['content'];
        $comment->getPost = $row['post_id'];

        return $comment;
    }


    /**
     * Method to add a new comment
     *
     * @param string $post
     * @param int    $user_id
     * @param string $comment
     *
     * @return boolean
     */


    public function createComment(string $post, int $user_id, string $comment): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'INSERT INTO comments(post_id, user_id, comment, commentDate) 
            VALUES(?, ?, ?, NOW())'
        );
        $affectedLines = $statement->execute([$post, $user_id, $comment]);

        return($affectedLines > 0);
    }


 


    /**
     * Get the value of frenchCreationDate
     */
    public function getFrenchCreationDate()
    {
        return $this->frenchCreationDate;
    }


    /**
     * Set the value of frenchCreationDate
     *
     * @return self
     */
    public function setFrenchCreationDate($frenchCreationDate)
    {
        $this->frenchCreationDate = $frenchCreationDate;

        return $this;
    }

    /**
     * Get the value of comment
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
     * Get the value of identifier
     */ 
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set the value of identifier
     *
     * @return self
     */ 
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get the value of post
     */ 
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set the value of post
     *
     * @return self
     */ 
    public function setPost($post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get the value of username
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
