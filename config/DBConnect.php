<?php
namespace Config;

require_once dirname(__DIR__).'/vendor/autoload.php';
use Dotenv\Dotenv;
use PDO;
use PDOException;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

class DBConnect {
    private static $instance = null;

    private function __construct() {}

    public static function getInstance() {
        if (!self::$instance) {
            try {
                // Database connection configuration
                $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'];

                $options = array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable error reporting
                    PDO::ATTR_EMULATE_PREPARES => false, // Disable prepared statement emulation
                );

                // Create PDO instance with configuration options
                self::$instance = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $options);
            } catch (PDOException $e) {
                // Handle database connection errors
                die('Database connection error: ' . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
