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
  Type a tournament name to start with:<br>
  <input type="text" name="tourn_name" method="get"><br>
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
$tourn_name = null;
$tourn_id = null;
if (isset($_GET['tourn_name']) && $_GET['tourn_name']!=""){
    $tourn_name = $_GET["tourn_name"];
    $tourn_id = $tourneys->findOne(["tourn_name" => $tourn_name])["_id"];
}

$result = null;
$result = $matches->find(["tourn_id" => $tourn_id]);

?>

<table style = "width:80%">
<thead>
    <tr>
      <th>Tournament Name</th>
      <th>Date</th>
      <th>Winner</th>
      <th>Loser</th>
      <th>Score</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if ($result!=null){
        foreach ($result as $row){
            $winner_name = $players->findOne(["_id"=>$row["winner"]])["name"];
            $loser_name = $players->findOne(["_id"=>$row["loser"]])["name"];
            echo "<tr> <td onclick=\"window.location.href='tourns.php?tourn_name=$tourn_name'\" target='_blank'> $tourn_name </td>
            <td> $row[date] </td> 
            <td onclick=\"window.location.href='single_player.php?name=$winner_name'\" target=\"_blank\"> $winner_name </td> 
            <td onclick=\"window.location.href='single_player.php?name=$loser_name'\" target=\"_blank\"> $loser_name </td> 
            <td>$row[score]</td> 
            </tr>";
        }
    }
    ?>
  </tbody>
</table>

</body>
</html>