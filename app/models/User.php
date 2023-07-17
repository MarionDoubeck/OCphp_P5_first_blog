<?php

namespace App\Models;

use App\db\DatabaseConnection;

/**
 * User class
 */
class User
{
    /**
     * Role of user
     *
     * @var string
     */

    private string $role;
    /**
     * Username of user
     *
     * @var string
     */

    private string $username;
    /**
     * Password of user
     *
     * @var string
     */

    private string $password;
    /**
     * Id of user
     *
     * @var int
     */

    private int $user_id;
    /**
     * email of user
     *
     * @var int
     */

    private string $email;

    private int $commentCount;

    //Connect to database
    public DatabaseConnection $connection;

    /**
     * Method to retrieve data from  all users 
     *
     * @return array
     */
    public function getUsers() : array
    {
        // Query to retrieve all users
        $query = "SELECT u.*, COUNT(c.id) AS comment_count
        FROM users u
        LEFT JOIN comments c ON u.id = c.author_id
        GROUP BY u.id";
        $statement = $this->connection->getConnection()->query($query);

        $users = [];

        while (($row = $statement->fetch())) {
            $user = new User();
            $user->setUsername($row['username']);
            $user->setEmail($row['email']);
            $commentCount = $row['comment_count'] ?? 0;
            $user->setCommentCount($commentCount);

            $users[] = $user;
        }
        
        return $users;
    }

    /**
     * Method to check user username and get this user data
     *
     * @param string $username
     *
     * @return user|null
     */


    public function checkUserUsername(string $username)
    {
        $statement = $this->connection->getConnection()->prepare(
            'SELECT * FROM users WHERE username=? '
        );

            $statement->execute([$username]);

        $row = $statement->fetch();
        if ($row === false) {
            return null;
        }
        $user = new User();
            $user->setUsername($row['username']);
            $user->setPassword($row['password']);
            $user->setUser_id($row['id']);
            $user->setRole($row['role']);
            $user->setEmail($row['email']);
        return $user;
    }


    /**
     * Method to check user email
     *
     * @param string $email
     *
     * @return void
     */


    public function checkUserEmail(string $email)
    {
        $statement = $this->connection->getConnection()->prepare(
            'SELECT * FROM users WHERE email=? '
        );

            $statement->execute([$email]);

        $row = $statement->fetch();
        if ($row === false) {
            return null;
        }
        return $row;
    }


    /**
     * Method to add data of a new user
     *
     * @param string $username
     * @param string $password
     * @param string $email
     * 
     * @return boolean
     */


    public function addUser(string $username, string $password, string $email) : bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'INSERT INTO users( username, password, email, role) VALUES(?, ?, ?, ?)'
        );
        $affectedLines = $statement->execute([$username, $password, $email, 'user']);

        return($affectedLines > 0);
    }


    /**
     * Get the value of role
     * 
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return self
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of password
     * 
     * @return string
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of user_id
     * 
     * @return int
     */ 
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return self
     */ 
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of email
     * 
     * @return string
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of user's nb of comments
     * 
     * @return string
     */ 
    public function getCommentCount()
    {
        return $this->commentCount;
    }

    /**
     * Set the value of email
     *
     * @return self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set the user's number of comments
     *
     * @return self
     */ 
    public function setCommentCount($commentCount)
    {
        if ($commentCount === null) {
            $this->commentCount = 0;
        } else{
            $this->commentCount = $commentCount;
        }

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
