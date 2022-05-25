<?php

require_once(__DIR__.'/Database.php');

/**
 * SQLite connnection
 */
class SQLiteConnection extends SQLite3{
    /**
     * PDO instance
     * @var type 
     */
    private $pdo;
    private $db;
    private bool $delete_db_file = false;

    function __construct() {
        if ($this->delete_db_file) {
            //echo ("Allowed to delete file"."<br>");
            if (file_exists(Config::PATH_TO_SQLITE_FILE)){
                if ($this->delete_db_file && !unlink(Config::PATH_TO_SQLITE_FILE)) {
                    echo (Config::PATH_TO_SQLITE_FILE." cannot be deleted due to an error"."<br>");
                }
                else {
                    //echo (Config::PATH_TO_SQLITE_FILE." has been deleted"."<br>");
                }
                //echo('Reading db file "'.Config::PATH_TO_SQLITE_FILE.'"'."<br>");
            } else {
            //echo('Creating file '.Config::PATH_TO_SQLITE_FILE."<br>");
                fopen(Config::PATH_TO_SQLITE_FILE, "w");
            }
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
        $this->open(Config::PATH_TO_SQLITE_FILE);
        if(!$this->db){
            echo $this->db->lastErrorMsg();
        } else {
            //echo "Opened database successfully"."<br>";
        }
        // return $this->pdo;
    }

    public function insertData() {
    $sql = 'drop table if exists person;';
    $this->insert($sql);
    $sql = 'drop table if exists login;';
    $this->insert($sql);
    //////////////////////////////
    $sql = 'create table if not exists person ('
    . 'id integer primary key autoincrement,'
    . 'name text unique,'
    . 'lastname text'
    . ');';
    $this->insert($sql);
    $sql = 'create table if not exists login ('
    . 'id integer primary key autoincrement,'
    . 'p_id integer,'
    . 'p_name text,'
    . 'p_lastname text,'
    . 'p_password text unique,'
    . 'p_admin default "false",'
    . 'foreign key (p_id) references person(id)'
    . ');';
    $this->insert($sql);
    //$sql = "insert into person (name, age) values ('bla', 34);";
    //$this->insert($sql);
    // $this->insert('.tables');
    }

    public function insert($sql)
    {
        echo "<br>"."$sql";
        $ret = $this->db->exec($sql);
        if(!$ret){
            echo $this->db->lastErrorMsg();
        }
        $this->db->close();
    }

    public function getdata() {
        // $stmt = $this->pdo->query('SELECT project_id, project_name '
        //         . 'FROM projects');
        // $stmt = $this->pdo->query('SELECT '
        // + 'person.id, '
        // + 'person.name, '
        // + 'person.lastname, '
        // + 'login.p_password, '
        // + 'login.p_admin '
        // + 'FROM person '
        // + 'join login on person.id = login.p_id');
        $persons = [];
        // while ($row = $stmt->fetchArray(SQLITE3_ASSOC))
        // {
            //     $persons[] =
            //     [
                //         'name' => $row['name'],
                //         'age' => $row['age']
                //     ];
                // }

        // $dbhandle = new SQLite3(Config::PATH_TO_SQLITE_FILE, 0666, $error);
        $db = new SQLite3(Config::PATH_TO_SQLITE_FILE);
        // if (!$dbhandle) die ($error);
        $sql = 'select '
        . 'name, '
        . 'age '
        . 'from person;';
        echo("<br>".$sql);
        $stmt = $this->pdo->query($sql);
        // $results = $db->query($sql);
        // echo("</p>");
        // var_dump($results);
        // while ($row = $results->fetchArray()) {
        //     $persons = var_dump($row);
        // }

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
            $persons = [
                'name' => $row['name'],
                'age' => $row['age']
            ];
        }
        // $result = $tmt->query($sql);
        // if (!$result) die("Cannot execute query: ".$stmt);
        // echo('call data row');
        // while ($row = $result->fetchArray()) {
        //     echo('call data row');
        //     var_dump($row);
        // }
        // $db->close();
        return $persons;
    }
}
