<html>
<title> Testing your connection </title>
<body>
<h1> My 90's webpage </h1>
<hr>
<?php
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "Activity4";

$conn = new mysqli($servername, $username, $password);

mysqli_select_db($conn, $dbname) or die("Could not open the '$dbname'");

$test_query = "SELECT * FROM instructor";
$result = mysqli_query($conn, $test_query);

$tuple_count = 0;
while($row = mysqli_fetch_array($result)) {
  $tuple_count++;
  echo "<p> You have this instructor: $row[1] with ID $row[0]";
}

echo "<p> There are $tuple_count instructors";


?>
</body>
</html>
