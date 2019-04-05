<html>
<title> HW4 </title>
<body>
<h1> HW4 </h1>
<h2> Authors: Ethan Steinbacher and Harry Zhou </h2>
<hr>

<form>
<input type="button" value="Go back to main page" onclick="window.location.href='index.php'" />
</form>

<?php
require 'vendor/autoload.php'; // include Composer's autoloader

$conn = new MongoDB\Client('mongodb://localhost');
$db = $conn->HW4;

$tourneys = $db->tourneys;
$matches = $db->matches;
$players = $db->players;

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
</form>

<input type="text" id="myInput" onkeyup="filter()" placeholder="Type your search" title="Type in a name">

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
document.getElementById("name").onclick = function() {sort(0)}
document.getElementById("height").onclick = function() {sort(1)}
document.getElementById("hand").onclick = function() {sort(2)}
document.getElementById("country").onclick = function() {sort(3)}
var table = document.getElementById("myTable");
var rows = table.rows
var ascend = true

//Adapted from C code in https://www.geeksforgeeks.org/merge-sort/
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
          rows[k].parentNode.replaceChild(L[i], rows[k]); 
          i++; 
      } 
      else
      { 
          rows[k].parentNode.replaceChild(R[j], rows[k]);  
          j++; 
      } 
      k++; 
    } else{
      if (L[i].getElementsByTagName("TD")[sortedBy].innerHTML.toLowerCase() >= R[j].getElementsByTagName("TD")[sortedBy].innerHTML.toLowerCase()) 
      { 
          rows[k].parentNode.replaceChild(L[i], rows[k]); 
          i++; 
      } 
      else
      { 
          rows[k].parentNode.replaceChild(R[j], rows[k]);  
          j++; 
      } 
      k++; 
    }
  } 
    /* Copy the remaining elements of L, if there 
       are any */
  while (i < n1) 
    { 
        rows[k].parentNode.replaceChild(L[i], rows[k]); 
        i++; 
        k++; 
    } 
  
    /* Copy the remaining elements of R, if there 
       are any */
    while (j < n2) 
    { 
        rows[k].parentNode.replaceChild(R[j], rows[k]); 
        j++; 
        k++; 
    } 

}

window.mergeSort = function(rows, l, r, sortedBy, ascend) {
  if (r > l)
    { 
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