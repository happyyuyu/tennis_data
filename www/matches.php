<html>
<title> HW4 </title>
<body>
<h1> HW4 </h1>
<hr>


<form>
<input type="button" value="Go back" onclick="window.location.href='index.php'" />
</form>
<!-- <form>
    <select name="search_fields" size="3">
        <option value="player">Players</option>
        <option value="tournaments">Tournaments</option>
        <option value="matches">Matches</option>
    </select>
    <input type="submit">
</form> -->
<form>
  Player name:<br>
  <input type="text" name="player_name" method="get"><br>
  Tournament name:<br>
  <input type="text" name="tourn_name" method="get"><br>
  Tournament date (yyyymmdd):<br>
  <input type="text" name="date" method="get">
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
        if (isset($_GET['player_name']) && $_GET['player_name']!=""){
            $player_name = $_GET['player_name'];
            // $nested = $matches->find(["tourn_name" => $tourn_name, "date"=> $date]);
            $result = $matches->find(
                array(
                    "tourn_name" => $tourn_name, "date"=> $date,
                    '$or' => array(
                        array("loser" => $player_name), 
                        array("winner" => $player_name)
                    )
                )
            );
        } else{
            $result = $matches->find(["tourn_name" => $tourn_name, "date"=> $date]);
        }
        
    } else{
        if (isset($_GET['player_name']) && $_GET['player_name']!=""){
            $player_name = $_GET['player_name'];
            $result = $matches->find(
                array(
                    "tourn_name" => $tourn_name,
                    '$or' => array(
                        array("loser" => $player_name), 
                        array("winner" => $player_name)
                    )
                )
            );
        } else{
            $result = $matches->find(["tourn_name" => $tourn_name]);
        }
    }
} elseif (isset($_GET['date']) && $_GET['date']!=""){
    $date = $_GET['date'];
    if (isset($_GET['player_name']) && $_GET['player_name']!=""){
        $player_name = $_GET['player_name'];
        $result = $matches->find(
            array(
                "date" => $date,
                '$or' => array(
                    array("loser" => $player_name), 
                    array("winner" => $player_name)
                )
            )
        );
    } else {
        $result = $matches->find(["date"=> $date]);
    }
} elseif (isset($_GET['player_name']) && $_GET['player_name']!=""){
    $player_name = $_GET['player_name'];
    $result = $matches->find(
        array(
            '$or' => array(
                array("loser" => $player_name), 
                array("winner" => $player_name)
            )
        )
    );
} else{
    $result = null;
}

if ($result!=null){
    foreach ($result as $row){
        echo "<p> Tournament: $row[tourn_name] <br> Date: $row[date] <br> Winner: $row[winner] <br>
        Loser: $row[loser] <br> Score: $row[score]<br> 
        <p>";
    }
}

?>
</body>
</html>