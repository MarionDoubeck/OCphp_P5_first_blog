<?php
namespace App\db;

use App\services\Env;

/**
 * DatabaseConnection class
 * To connect to the data base
 */
class DatabaseConnection
{

    /**
     * PHP Data Object
     *
     * @var \PDO|null $database Description de la variable de base de données PDO.
     */
    public ?\PDO $database = null;


    /**
     * Function to connect to the data base
     *
     * @return \PDO
     */
    public function getConnection() : \PDO
    {
        if ($this->database === null) {
            $this->database = new \PDO(
                "mysql:host=".Env::get('DB_HOST').";dbname=".Env::get('DB_NAME').";charset=UTF8",
                Env::get('DB_USER'), Env::get('DB_PASSWORD')
            );
        }

        return $this->database;

    }//end getConnection()


}//end class
