<html>
 <head>
   <title>Hello World</title>
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

			// build own structure
			class person
			{
				private $name;
				private $surname;
				private $age;

				public function __construct(string $name, string $surname, int $age){
					$this->name = $name;
					$this->surname = $surname;
					$this->age = $age;
				}
				public function get_name(){
					return $this->name;
				}
				public function get_surname(){
					return $this->surname;
				}
				public function get_age(){
					return $this->age;
				}
			}
			
			echo '<table class="table">';
			echo '<tr>';
			echo '<th scope="col">1st name</th>';
			echo '<th scope="col">last name</th>';
			echo '<th scope="col">age</th>';
			echo '<th scope="col">pw</th>';
			echo '</tr>';
			
			// main routine, get db connection
			getDataIntern();
			getDataFromDB();
			getDataRandom();
			
			// end html code
			echo '</table>';
			echo '</div>';
			echo '</body>';

			// get random string
			function makeRandomString($max=6)
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
				$person1 = new person('achim', 'bounty', 45);
				$person2 = new person('paula', 'ursula', 30);
				// get data from own class
				echo '<tr>';
				echo "<td>".$person1->get_name()."</td>";
				echo "<td>".$person1->get_surname()."</td>";
				echo "<td>".$person1->get_age()."</td>";
				echo '</tr>';
				echo '<tr>';
				echo "<td>".$person2->get_name()."</td>";
				echo "<td>".$person2->get_surname()."</td>";
				echo "<td>".$person2->get_age()."</td>";
				echo '</tr>';
				echo '<tr>';
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo '</tr>';
			}
			function getDataFromDB()
			{
				// db connection. -> sqlite
				$pdo = new SQLiteConnection();
				$pdo_connect = $pdo->connect();
				if ($pdo != null){
					// echo 'Connected to the SQLite database successfully!';
					// $pdo->insertData();
					// (new SQLiteConnection())->insertData();
					// $pdo->getdata();
					$sql = ''
					. 'select '
					. 'firstname, '
					. 'lastname, '
					. 'age '
					. 'from person';
					$results = $pdo->query($sql);
					echo("<br>".$sql);
					while($row = $results->fetchArray(SQLITE3_ASSOC)){
						echo '<tr>';
						echo "<td>$row[firstname]</td>";
						echo "<td>$row[lastname]</td>";
						echo "<td>$row[age]</td>";
						echo "<td>".makeRandomString()."</td>";
						echo '</tr>';
					}
				}
				else
				{
					echo("<br>".'Whoops, could not connect to the SQLite database!');
				}
				echo '<tr>';
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo '</tr>';
			}
			function getDataRandom()
			{
				// get random data with library
				for($count=0; $count<10; $count++)
				{
					$faker = Faker\Factory::create();
					echo '<tr>';
					echo "<td>".$faker->firstName."</td>";
					echo "<td>".$faker->lastName."</td>";
					echo "<td>".rand()."</td>";
					echo "<td>".makeRandomString()."</td>";
					echo '</tr>';
				}
			}
		?>
	</table>
</body>
</html>
