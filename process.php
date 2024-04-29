<?php
$conn = new mysqli("localhost", "root", "", "login");
if(!$conn);
{
    echo "Could not connect to sql";
}

$sql = "SELECT * FROM STUDENTS";
$result = $conn ->query($sql);
echo "<table border = 1 width=60% cellspacing=0>";

echo "<th>";
echo "admno";
echo "</th>";
echo "<th>";
echo "sname";
echo "</th>";

while($row=$result ->fetch_array()){
    echo "<tr>";
    echo "<td>".$row['admno']."</td>";
    echo "<td>".$row['sname']."</td>";
    echo "</tr>";
}
echo "</table>";
?>