<html>
 <head>
   <title>Hello World</title>
 </head>
 <body>
<?php

// load class file
require_once('SQLiteConnection.php');

// build own structure
class person{
private $name;
private $age;

private function __construct(string $name, int $age){
	$this->name = $name;
	$this->age = $age;
}
private function get_name(){
	return $this->name;
}
private function get_age(){
	return $this->age;
}
}

// main routine, get db connection
// $person = new person('achim', 45);
// $person = new person('paula', 30);
$pdo = new SQLiteConnection();
$pdo_connect = $pdo->connect();
if ($pdo != null){
	// echo 'Connected to the SQLite database successfully!';
	// $pdo->insertData();
	// (new SQLiteConnection())->insertData();
	// $pdo->getdata();
	$results = $pdo->query(''
	. 'select '
	. 'name, '
	. 'age '
	. 'from person;');
	echo("<br>".$sql);
	// while ($row = $results->fetchArray()) {
	// 	var_dump($row);
	// }
	echo '<head>';
	echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>';
	echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">';
	echo '</head>';
	echo '<body>';
	echo '<div class="container">';
	echo '<table class="table">';
	echo '<tr>';
	echo '<th scope="col">name</th>';
	echo '<th scope="col">age</th>';
	echo '</tr>';
	while($row=$results->fetchArray(SQLITE3_ASSOC)){
		echo '<tr>';
		echo "<td>$row[name]</td><td>$row[age]</td>";
		echo '</tr>';
	}
	// echo '<tr>';
	// echo "<td>".$person1->get_name()."</td><td>".$person1->get_age()."</td>";
	// echo '</tr>';
	for($count=0; $count<10; $count++){
		echo '<tr>';
		echo "<td>".makeRandomString()."</td><td>".rand(10,100)."</td>";
		echo '</tr>';
	}
	echo '</table>';
	echo '</div>';
	echo '</body>';
}
else
{
	echo('Whoops, could not connect to the SQLite database!');
	// (new SQLiteConnection())->insertData();
}

// get random string
function makeRandomString($max=6)
{
	$i = 0;
	$possible_keys = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$keys_length = strlen($possible_keys);
	$str = "";
	while($i<$max) {
		$rand = mt_rand(1,$keys_length-1);
		$str.= $possible_keys[$rand];
		$i++;
	}
	$str = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
	return $str;
}

?>
 </body>
</html>
