<html>
 <head>
	<title>Get some data</title>
	<script
	src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
	integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
	crossorigin="anonymous"></script>
	<link
	href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
	rel="stylesheet"
	integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
	crossorigin="anonymous">
 	</head>
 	<body>
		<div class="container">
		<?php

			// function connect() {
			// 	// if (file_exists($PATH_TO_SQLITE_FILE)){
			// 		echo "<br>".'Load file: '.$PATH_TO_SQLITE_FILE;
			// 		echo "<br>".'Load file: '.$file;
			// 	if (file_exists($PATH_TO_SQLITE_FILE)){
			// 		// fopen($PATH_TO_SQLITE_FILE, "w");
			// 		fopen($PATH_TO_SQLITE_FILE, "w");
			// 	} else {
			// 		echo "<br>".'File does not exist: '.$PATH_TO_SQLITE_FILE;
			// 	}
			// }
			// load class file
			require_once('SQLiteConnection.php');
			require_once 'vendor/autoload.php';

			// website

			// main routine, get db connection
			getDataIntern();
			getDataFromDB();
			// getDataRandom();
			// end html code
			echo '</table>';

			// data

			// build own structure
			class person
			{
				private $name;
				private $surname;
				private $age;
				private $pw;
				private $city;

				// public function __construct(string $name, string $surname, int $age)
				// {
				// 	$this->name = $name;
				// 	$this->surname = $surname;
				// 	$this->age = $age;
				// }
				public function __construct(string $name, string $surname, int $age, string $pw, string $city)
				{
					$this->name = $name;
					$this->surname = $surname;
					$this->age = $age;
					$this->pw = $pw;
					$this->city = $city;
				}
				public function get_name()
				{
					return $this->name;
				}
				public function get_surname()
				{
					return $this->surname;
				}
				public function get_age()
				{
					return $this->age;
				}
				public function get_pw()
				{
					return $this->pw;
				}
				public function get_city()
				{
					return $this->city;
				}
			}
			
			// get random string
			function getRandomString($max=6)
			{
				// $i = 0;
				// $possible_keys = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
				// $keys_length = strlen($possible_keys);
				// $str = "";
				// while($i<$max) {
				// 	$rand = mt_rand(1,$keys_length-1);
				// 	$str.= $possible_keys[$rand];
				// 	$i++;
				// }
				$str = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
				return $str;
			}
			// get data
			function getDataIntern()
			{
				// begin html code
				echo "<br><h1>src: internal class</h1>";
				echo '<table class="table">';
				echo '<tr>';
				echo '<th scope="col">1st name</th>';
				echo '<th scope="col">last name</th>';
				echo '<th scope="col">age</th>';
				echo '<th scope="col">pw</th>';
				echo '<th scope="col">city</th>';
				echo '</tr>';
				// end html code
				$array = array();
				for($count=0; $count<SQLiteConnection::countOfDataPerTable; $count++)
				{
					$faker = Faker\Factory::create();
					// $person = new person($faker->firstName, $faker->lastName, $count*10, rand());
					$person = new person($faker->firstName, $faker->lastName, rand(0, 100), getRandomString(), $faker->state);
					array_push($array, $person);
				}
				// for($count=0; $count<SQLiteConnection::countOfDataPerTable; $count++)
				for($count=0; $count<sizeof($array); $count++)
				{
					echo '<tr>';
					echo "<td>".$array[$count]->get_name()."</td>";
					echo "<td>".$array[$count]->get_surname()."</td>";
					echo "<td>".$array[$count]->get_age()."</td>";
					echo "<td>".$array[$count]->get_pw()."</td>";
					echo "<td>".$array[$count]->get_city()."</td>";
					echo '</tr>';
				}
				// end html code
				echo '</table>';
			}
			function getDataFromDB()
			{
				// begin html code
				echo "<br><h1>src: db (".SQLite3::version()[versionString].")</h1>";
				echo '<table class="table">';
				echo '<tr>';
				echo '<th scope="col">1st name</th>';
				echo '<th scope="col">last name</th>';
				echo '<th scope="col">age</th>';
				echo '<th scope="col">pw</th>';
				echo '<th scope="col">city</th>';
				echo '</tr>';
				// end html code
				// db connection. -> sqlite
				$pdo = new SQLiteConnection();
				$pdo_connect = $pdo->connect();
				insertData($pdo);
				if ($pdo != null)
				{
					// echo 'Connected to the SQLite database successfully!';
					// $pdo->insertData();
					// (new SQLiteConnection())->insertData();
					// $pdo->getdata();
					$sql = ''
					. 'select '
					. 'firstname, '
					. 'lastname, '
					. 'age, '
					. 'pw, '
					. 'city '
					. 'from person';
					$results = $pdo->query($sql);
					// echo("<br>".$sql);
					while($row = $results->fetchArray(SQLITE3_ASSOC)){
						echo '<tr>';
						echo "<td>$row[firstname]</td>";
						echo "<td>$row[lastname]</td>";
						echo "<td>$row[age]</td>";
						echo "<td>$row[pw]</td>";
						echo "<td>$row[city]</td>";
						// echo "<td>".makeRandomString()."</td>";
						echo '</tr>';
					}
					echo '<tr>';
					echo "<td>"
					.'<input placeholder="Put some shit here">'
					.'<br>'
					.'<div style="font-size:12px;">No effect so far :(</div>'
					."</td>";
					echo "<td>"
					.'<input placeholder="Put some shit here">'
					.'<br>'
					.'<div style="font-size:12px;">No effect so far :(</div>'
					."</td>";
					echo "<td>"
					.'<input placeholder="Put some shit here">'
					.'<br>'
					.'<div style="font-size:12px;">No effect so far :(</div>'
					."</td>";
					echo "<td>"
					.'<input placeholder="Put some shit here">'
					.'<br>'
					.'<div style="font-size:12px;">No effect so far :(</div>'
					."</td>";
					echo "<td>"
					.'<input placeholder="Put some shit here">'
					.'<br>'
					.'<div style="font-size:12px;">No effect so far :(</div>'
					."</td>";
					echo '</tr>';
				}
				else
				{
					echo("<br>".'Whoops, could not connect to the SQLite database!');
				}
				// end html code
				echo '</table>';
			}
			// function getDataRandom()
			// {
			// 	// get random data with library
			// 	for($count=0; $count<10; $count++)
			// 	{
			// 		$faker = Faker\Factory::create();
			// 		echo '<tr>';
			// 		echo "<td>".$faker->firstName."</td>";
			// 		echo "<td>".$faker->lastName."</td>";
			// 		echo "<td>".rand()."</td>";
			// 		echo "<td>".makeRandomString()."</td>";
			// 		echo '</tr>';
			// 	}
			// }
			function insertData($pdo)
			{
				// create?
				// $stmt = $pdo->prepare('drop table if exists person;');
				// $stmt->execute();
				// $stmt = $pdo->prepare('create table if not exists person '
				// .'(id integer primary key autoincrement, '
				// .'firstname text unique, '
				// .'lastname text, '
				// .'age integer, '
				// .'pw text, '
				// .'city text);');
				// $stmt->execute();
				// or just remove
				$stmt = $pdo->prepare('delete from person');
				$stmt->execute();
				for($count=0; $count<SQLiteConnection::countOfDataPerTable; $count++)
				{
					$faker = Faker\Factory::create();
					$sql = 'INSERT INTO person ('
					.'firstname, lastname, age, pw, city'
					.') VALUES ('
					."'".$faker->firstName."', '".$faker->firstName."', ".(rand(0, 100)).", '".getRandomString()."', '".$faker->state."'"
					.')'
					.'';
					// $stmt = $this->pdo->prepare($sql);
					// echo '<br>'.$sql;
					$stmt = $pdo->prepare($sql);
					// $stmt->bindValue(':project_name', $projectName);
					$stmt->execute();
				}

				// return $this->pdo->lastInsertId();
				// return $pdo->lastInsertId();
			}
		?>
	</table>
	</div>
	</body>
</body>
</html>
