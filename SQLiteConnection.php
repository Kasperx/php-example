<?php

// require_once(__DIR__.'/Database.php');

/**
 * SQLite connnection
 */
class SQLiteConnection extends SQLite3{
    
    const PATH_TO_SQLITE_FILE = 'database.db';
    const countOfDataPerTable = 10;

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
    public function findAll()
    {
        $statement = "
            SELECT 
                id, firstname, lastname, firstparent_id, secondparent_id
            FROM
                person;
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
    public function find($id)
    {
        $statement = "
            SELECT 
                id, firstname, lastname, age
            FROM
                person
            WHERE id = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function insert(Array $input)
    {
        $statement = "
            INSERT INTO person 
                (firstname, lastname, age, pw)
            VALUES
                (:firstname, :lastname, :age, :pw);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'firstname' => $input['firstname'],
                'lastname'  => $input['lastname'],
                'age'  => $input['age'],
                'pw'  => $input['pw'],
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function update($id, Array $input)
    {
        $statement = "
            UPDATE person
            SET 
                firstname = :firstname,
                lastname  = :lastname,
                age  = :age,
                pw  = :pw
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'firstname' => $input['firstname'],
                'lastname'  => $input['lastname'],
                'age'  => $input['age'],
                'pw'  => $input['pw']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function delete($id)
    {
        $statement = "
            DELETE FROM person
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('id' => $id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }
}

?>