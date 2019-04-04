<html>
<title> HW4 </title>
<body>
<h1> HW4 </h1>
<hr>

<form>
<input type="button" value="Go back" onclick="window.location.href='index.php'" />
</form>

<form>
  Search one player:<br>
  Player name:<br>
  <input type="text" name="player_name" method="get"><br>
  <br>
  <input type="submit">
</form>

<form>
  See all players sorted by:<br>
  <select name="search_fields" size="4">
        <option value="height">Height</option>
        <option value="name">Name</option>
        <option value="dominant_hand">Dominant Hand</option>
        <option value="country">Country</option>
  </select>
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

if (isset($_GET['player_name'])) {
    $player_name = $_GET["player_name"];
    $result = $players->find(["name" => $player_name]);
    foreach ($result as $row){
        echo "<p> Name: $player_name <br> Height: $row[height] <br> Dominant hand: $row[hand] <br> Country: $row[country] <p>";
    }
}

?>

</body>
</html>