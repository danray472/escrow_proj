<html> <body>
<?php
$admno = $_POST['admno'];
$sname = $_POST['sname'];
$conn = new mysqli("localhost", "root", "", "login");

if(!$conn);
{
   echo "Could not connect to the database"; 
}

$sql = "inset into student valuses"('$admno', '$sname');
$result = $conn->query($sql);
echo "record successfully added";
?>
<a href="form.php">Add another Record</a>
<br><br>
<a href="processor.php">Display the Data</a>
</body>