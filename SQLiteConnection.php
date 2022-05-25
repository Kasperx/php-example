<?php

// require_once(__DIR__.'/Database.php');

/**
 * SQLite connnection
 */
class SQLiteConnection extends SQLite3{
    
    const PATH_TO_SQLITE_FILE = 'database.db';

    private $pdo;
    private $db;

    function __construct() {
        // if (file_exists($PATH_TO_SQLITE_FILE))
        if (!file_exists(SQLiteConnection::PATH_TO_SQLITE_FILE))
        {
            //echo('Reading db file "'.Config::PATH_TO_SQLITE_FILE.'"'."<br>");
            fopen(SQLiteConnection::PATH_TO_SQLITE_FILE, "w");
        }
     }

    /**
     * return in instance of the PDO object that connects to the SQLite database
     * @return \PDO
     */
    public function connect() {
        // if ($this->pdo == null) {
        //     $this->pdo = new \PDO("sqlite:" . Config::PATH_TO_SQLITE_FILE);
        //     $this->db = $this->open(Config::PATH_TO_SQLITE_FILE);
        // }
        $this->db = new SQLiteConnection();
        $this->open(SQLiteConnection::PATH_TO_SQLITE_FILE);
        if(!$this->db)
        {
            echo $this->db->lastErrorMsg();
        // } else {
            //echo "Opened database successfully"."<br>";
        }
        // return $this->pdo;
    }
    }

?>