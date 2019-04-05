<html>
<title> HW4 </title>
<body>
<h1> HW4 </h1>
<h2> Authors: Ethan Steinbacher and Harry Zhou </h2>
<hr>

<form>
<input type="button" value="Go back to main page" onclick="window.location.href='index.php'" />
</form>

<form>
  Search one tournament:<br>
  Tournament name:<br>
  <input type="text" name="tourn_name" method="get"><br>
  <br>
  Date (yyyymmdd):
  <input type="text" name="date" method="get"><br>
  <br>
  <input type="submit">
</form>

<?php
require 'vendor/autoload.php'; // include Composer's autoloader

$conn = new MongoDB\Client('mongodb://localhost');
$db = $conn->HW4;

$tourneys = $db->tourneys;
$matches = $db->matches;
$players = $db->players;

if (isset($_GET['tourn_name']) && $_GET['tourn_name']!="") {
    $tourn_name = $_GET["tourn_name"];
    if (isset($_GET['date']) && $_GET['date']!=""){
        $date = $_GET['date'];
        $result = $tourneys->find(["tourn_name" => $tourn_name, "date"=> $date]);
    } else{
        $result = $tourneys->find(["tourn_name" => $tourn_name]);
    }
} elseif (isset($_GET['date']) && $_GET['date']!=""){
    $date = $_GET['date'];
    $result = $tourneys->find(["date" => $date]);
} else{
    $result = null;
}
?>
<table>
<thead>
    <tr>
      <th>Tournament Name</th>
      <th>Date</th>
      <th>Surface</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if ($result!=null){
        foreach ($result as $row){
            echo "<tr>";
            echo "<td> $row[tourn_name] </td> <td> $row[date] </td>  <td>$row[surface] </td>";
            echo "</tr>";
        }
    }
    ?>
  </tbody>
</table>
</body>
</html>