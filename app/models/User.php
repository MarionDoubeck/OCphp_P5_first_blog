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
     * @var integer
     */
    private int $user_id;

    /**
     * email of user
     *
     * @var integer
     */
    private string $email;

    /**
     * nb of comments user wrote
     *
     * @var integer
     */
    private int $commentCount;

    /**
     * Connexion to database
     *
     * @var DatabaseConnection
     */
    public DatabaseConnection $connection;


    /**
     * Method to retrieve data from  all users
     *
     * @return array
     */
    public function getUsers() : array
    {
        // Query to retrieve all users.
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
            $commentCount = ($row['comment_count'] ?? 0);
            $user->setCommentCount($commentCount);

            $users[] = $user;
        }

        return $users;

    }//end getUsers()


    /**
     * Method to check user username and get this user data
     *
     * @param string $username Username
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

    }//end checkUserUsername()


    /**
     * Method to check user email
     *
     * @param string $email Email
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

    }//end checkUserEmail()


    /**
     * Method to add data of a new user
     *
     * @param string $username Username
     * @param string $password Password
     * @param string $email    Email
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

    }//end addUser()


    /**
     * Get the value of role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;

    }//end getRole()


    /**
     * Set the value of role
     *
     * @param string $role Role
     *
     * @return self
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;

    }//end setRole()


    /**
     * Get the value of password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;

    }//end getPassword()


    /**
     * Set the value of password
     *
     * @param string $password Password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;

    }//end setPassword()


    /**
     * Get the value of user_id
     *
     * @return int
     */
    public function getUser_id()
    {
        return $this->user_id;

    }//end getUser_id()


    /**
     * Set the value of user_id
     *
     * @param int $user_id User Id
     * @return self
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;

    }//end setUser_id()


    /**
     * Get the value of email
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;

    }//end getEmail()


    /**
     * Get the value of user's nb of comments
     * 
     * @return string
     */ 
    public function getCommentCount()
    {
        return $this->commentCount;

    }//end getCommentCount()


    /**
     * Set the value of email
     *
     * @return self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;

    }//end setEmail()


    /**
     * Set the user's number of comments
     *
     * @return self
     */ 
    public function setCommentCount($commentCount)
    {
        if ($commentCount === null) {
            $this->commentCount = 0;
        } else {
            $this->commentCount = $commentCount;
        }

        return $this;

    }//end setCommentCount()


    /**
     * Get the value of username
     * 
     * @return string
     */ 
    public function getUsername()
    {
        return $this->username;

    }//end getUsername()


    /**
     * Set the value of username
     *
     * @return self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;

    }//end setUsername()


}//end class
