<html>
<title> HW4 </title>
<body>
<h1> HW4 </h1>
<hr>


<form>
<input type="button" value="Go back" onclick="window.location.href='index.php'" />
</form>

<!-- <form>
  Player name:<br>
  <input type="text" name="player_name" method="get"><br>
  Tournament name:<br>
  <input type="text" name="tourn_name" method="get"><br>
  Tournament date (yyyymmdd):<br>
  <input type="text" name="date" method="get">
  <br>
  <input type="submit">
</form> -->

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

$tourn_name = $_GET["tourn_name"];
$tourn_id = $tourneys->findOne(["tourn_name" => $tourn_name])["_id"];
// $tourn_id = $tourn["_id"];

echo $tourn_id;
$result = null;
$result = $matches->find(["tourn_id" => $tourn_id]);

// if (isset($_GET['tourn_name']) && $_GET['tourn_name']!="") {
//     $tourn_name = $_GET["tourn_name"];
//     $tourn_id = $tourneys->find(["tourn_name" => $tourn_name]);
//     if (isset($_GET['date']) && $_GET['date']!=""){
//         $date = $_GET['date'];
//         if (isset($_GET['player_name']) && $_GET['player_name']!=""){
//             $player_name = $_GET['player_name'];
//             // $nested = $matches->find(["tourn_name" => $tourn_name, "date"=> $date]);
//             $result = $matches->find(
//                 array(
//                     "tourn_id" => $tourn_id, "date"=> $date,
//                     '$or' => array(
//                         array("loser" => $player_name), 
//                         array("winner" => $player_name)
//                     )
//                 )
//             );
//         } else{
//             $result = $matches->find(["tourn_id" => $tourn_id, "date"=> $date]);
//         }
        
//     } else{
//         if (isset($_GET['player_name']) && $_GET['player_name']!=""){
//             $player_name = $_GET['player_name'];
//             $player_id = $tourneys->find(["name" => $player_name]);
//             $result = $matches->find(
//                 array(
//                     "tourn_name" => $tourn_name,
//                     '$or' => array(
//                         array("loser" => $player_name), 
//                         array("winner" => $player_name)
//                     )
//                 )
//             );
//         } else{
//             $result = $matches->find(["tourn_name" => $tourn_name]);
//         }
//     }
// } elseif (isset($_GET['date']) && $_GET['date']!=""){
//     $date = $_GET['date'];
//     if (isset($_GET['player_name']) && $_GET['player_name']!=""){
//         $player_name = $_GET['player_name'];
//         $result = $matches->find(
//             array(
//                 "date" => $date,
//                 '$or' => array(
//                     array("loser" => $player_name), 
//                     array("winner" => $player_name)
//                 )
//             )
//         );
//     } else {
//         $result = $matches->find(["date"=> $date]);
//     }
// } elseif (isset($_GET['player_name']) && $_GET['player_name']!=""){
//     $player_name = $_GET['player_name'];
//     $result = $matches->find(
//         array(
//             '$or' => array(
//                 array("loser" => $player_name), 
//                 array("winner" => $player_name)
//             )
//         )
//     );
// } else{
//     $result = null;
// }

// if ($result!=null){
//     foreach ($result as $row){
//         $winner_name = $players->findOne(["_id"=>$row["winner"]])["name"];
//         $loser_name = $players->findOne(["_id"=>$row["loser"]])["name"];
//         echo "<tr> <td> Tournament: $tourn_name </td> <td> Date: $row[date] </td> <td> Winner: $winner_name </td> 
//         <td> Loser: $loser_name </td> <td> Score: $row[score]</td> 
//         </tr>";
//     }
// }

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