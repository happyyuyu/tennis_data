<html>
<title> Testing your connection </title>
<body>
<h1> My 90's webpage </h1>
<hr>
<?php
require 'vendor/autoload.php'; // include Composer's autoloader

$conn = new MongoDB\Client('mongodb://localhost');

$db = $conn->TestDB;

$collection = $db->students;

$cursor = $collection->find();
	 	
$tuple_count = 0;
foreach ($cursor as $row) {
  $tuple_count++;
	// Two ways to write the same thing. Note the single-quotes in the second form
  echo "<p> You have the student $row[name] with major $row[major]";
  echo "<p> You have the student " . $row['name'] . " with major " . $row['major'];
}

echo "<p> There are $tuple_count students";


?>
</body>
</html>

