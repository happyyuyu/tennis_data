<html>
<title> HW4 </title>
<body>
<h1> HW4 </h1>
<hr>

<form>
<input type="button" value="Go back" onclick="window.location.href='index.php'" />
</form>

<!-- <form>
  Search one player:<br>
  Player name:<br>
  <input type="text" name="player_name" method="get"><br>
  <br>
  <input type="submit">
</form> -->


<?php
require 'vendor/autoload.php'; // include Composer's autoloader

$conn = new MongoDB\Client('mongodb://localhost');
$db = $conn->HW4;

$tourneys = $db->tourneys;
$matches = $db->matches;
$players = $db->players;

// if (isset($_GET['player_name'])) {
//     $player_name = $_GET["player_name"];
//     $result = $players->find(["name" => $player_name]);
//     // foreach ($result as $row){
//     //     echo "<p> Name: $player_name <br> Height: $row[height] <br> Dominant hand: $row[hand] <br> Country: $row[country] <p>";
//     // }
// } else{
//   // $result = $players->find(
//   //   array(
//   //         '$or' => array(
//   //             array("name" => "Milos Raonic"),
//   //             array("name" => "Roger Federer"),
//   //             array("name" => "Dominic Thiem"),
//   //             array("name" => "Thomas Fabbiano")
//   //         )
//   //     )
//   // );
//   $result = $players->find();
// }
$result = $players->find();

?>

<form>
  See all players filtered by:<br>
  <select name="search_fields" size="4" id="selection">
        <option value="name">Name</option>
        <option value="height">Height</option>
        <option value="dominant_hand">Dominant Hand</option>
        <option value="country">Country</option>
  </select>
  <br>
  <!-- <input type="button" onclick="filter()" value="submit"> -->
</form>

<input type="text" id="myInput" onkeyup="filter()" placeholder="Type your search" title="Type in a name">

<!-- <p><button onclick="mergeSort()">Sort</button></p> -->
<p id="demo">Please click on the attribute to sort. Click again to change order</p>

<table style = "width:50%" id='myTable'>
    <tr>
      <th id="name">Name</th>
      <th id="height">Height</th>
      <th id="hand">Dominant hand</th>
      <th id="country">Country</th>
    </tr>

    <?php
    if ($result!=null){
        foreach ($result as $row){
            echo "<tr>";
            echo "<td> $row[name] </td> <td> $row[height] </td>  <td>$row[hand] </td> <td>$row[country] </td>";
            echo "</tr>";
        }
    }
    ?>

</table>

<script type="text/javascript">
// document.getElementById("demo").onclick = function() {doAll()}
document.getElementById("name").onclick = function() {sort(0)}
document.getElementById("height").onclick = function() {sort(1)}
document.getElementById("hand").onclick = function() {sort(2)}
document.getElementById("country").onclick = function() {sort(3)}
var table = document.getElementById("myTable");
var rows = table.rows
var ascend = true
window.test = function() {
  // table = document.getElementById("myTable");

  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("myTable");
  
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  // while (switching) {
  //   //start by saying: no switching is done:
  //   switching = false;
  //   rows = table.rows;
  //   /*Loop through all table rows (except the
  //   first, which contains table headers):*/
  //   for (i = 1; i < (rows.length - 1); i++) {
  //     //start by saying there should be no switching:
  //     shouldSwitch = false;
  //     /*Get the two elements you want to compare,
  //     one from current row and one from the next:*/
  //     x = rows[i].getElementsByTagName("TD")[3];
  //     y = rows[i + 1].getElementsByTagName("TD")[3];
  //     //check if the two rows should switch place:
  //     if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
  //       //if so, mark as a switch and break the loop:
  //       shouldSwitch = true;
  //       break;
  //     }
  //   }
  //   if (shouldSwitch) {
  //     /*If a switch has been marked, make the switch
  //     and mark that a switch has been done:*/
  //     rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
  //     switching = true;
  //   }
  // }
  rows = table.rows
  x = rows[4].getElementsByTagName("TD");
  console.log(x);
  y = rows[2].getElementsByTagName("TD");
  new_row = rows[3].cloneNode(true)
  console.log(new_row.getElementsByTagName("TD"));
  rows[2].parentNode.replaceChild(new_row, rows[2])
}

window.merge = function(rows, l, m, r, sortedBy, ascend){
  var i, j, k;
  let n1 = m - l + 1;
  let n2 =  r - m;
  var L = [];
  var R = [];
  for (i = 0; i < n1; i++){
    L[i] = rows[l+i].cloneNode(true)
  }
  for (j = 0; j < n2; j++){
    R[j] = rows[m + 1+ j].cloneNode(true)
  }

  i = 0; // Initial index of first subarray 
  j = 0; // Initial index of second subarray 
  k = l;
  while (i < n1 && j < n2){ 
    if (ascend){
      if (L[i].getElementsByTagName("TD")[sortedBy].innerHTML.toLowerCase() <= R[j].getElementsByTagName("TD")[sortedBy].innerHTML.toLowerCase()) 
      { 
          // rows[k] = L[i];
          rows[k].parentNode.replaceChild(L[i], rows[k]); 
          i++; 
      } 
      else
      { 
          // rows[k] = R[j];
          rows[k].parentNode.replaceChild(R[j], rows[k]);  
          j++; 
      } 
      k++; 
    } else{
      if (L[i].getElementsByTagName("TD")[sortedBy].innerHTML.toLowerCase() >= R[j].getElementsByTagName("TD")[sortedBy].innerHTML.toLowerCase()) 
      { 
          // rows[k] = L[i];
          rows[k].parentNode.replaceChild(L[i], rows[k]); 
          i++; 
      } 
      else
      { 
          // rows[k] = R[j];
          rows[k].parentNode.replaceChild(R[j], rows[k]);  
          j++; 
      } 
      k++; 
    }
  } 
  while (i < n1) 
    { 
        // rows[k] = L[i]; 
        rows[k].parentNode.replaceChild(L[i], rows[k]); 
        i++; 
        k++; 
    } 
  
    /* Copy the remaining elements of R[], if there 
       are any */
    while (j < n2) 
    { 
        // rows[k] = R[j]; 
        rows[k].parentNode.replaceChild(R[j], rows[k]); 
        j++; 
        k++; 
    } 

}

window.mergeSort = function(rows, l, r, sortedBy, ascend) {
  if (r > l)
    { 
        // Same as (l+r)/2, but avoids overflow for 
        // large l and h 
        let m = Math.floor((l+r)/2); 
  
        // Sort first and second halves 
        mergeSort(rows, l, m, sortedBy, ascend); 
        mergeSort(rows, m+1, r, sortedBy, ascend); 
  
        merge(rows, l, m, r, sortedBy, ascend); 
    }
}

window.sort = function(sortedBy){
  mergeSort(rows, 1, rows.length - 1, sortedBy, ascend)
  ascend = (ascend) ? false : true;
}

window.filter = () => {
  var input, filter, table, tr, td, i, txtValue;
  let selection = document.getElementById("selection").selectedIndex;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[selection];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}


</script>
</body>
</html>