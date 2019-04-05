<html>
<title> HW4 </title>
<body>
<h1> HW4 </h1>
<hr>

<form>
<input type="button" value="Go To Main Page" onclick="window.location.href='index.php'" />
</form>

<?php
require 'vendor/autoload.php'; // include Composer's autoloader

$conn = new MongoDB\Client('mongodb://localhost');
$db = $conn->HW4;

$players = $db->players;
$result = null;

if (isset($_GET['name']) && $_GET['name']!="") {
    $name = $_GET["name"];
    $result = $players->find(["name"=>$name]);
}

?>
<table>
<thead>
    <tr>
      <th>Player Name</th>
      <th>Height</th>
      <th>Dominant hand</th>
      <th>Country/th>
    </tr>
  </thead>
  <tbody>
    <?php
    if ($result!=null){
        foreach ($result as $row){
            echo "<tr>";
            echo "<td> $row[name] </td> <td> $row[height] </td>  <td>$row[hand] </td> <td>$row[country] </td>";
            echo "</tr>";
        }
    }
    ?>
  </tbody>
</table>

<form>
<input type="button" value="View All Players" onclick="window.location.href='player.php'" />
</form>

</body>
</html>