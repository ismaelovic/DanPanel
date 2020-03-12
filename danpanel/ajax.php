<?php
include('server.php');

if(isset($_POST['chosen'])){
//echo "Hello again!";

$query = "
SELECT *
FROM employee
WHERE companyId = '" . trim($_POST['chosen']) . "'
";
$myEmployees = array();
$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {
while($row = $result->fetch_assoc()) {
  //$myEmployee = $row['employeeName'];
  //echo $myEmployee;
  array_push($myEmployees, $row['employeeName']);
}
}
else {
  echo "No SQL!";
}

echo json_encode($myEmployees);

//print_r($myEmployees);

//var_dump($myEmployees);

//echo $myEmployees[1];

}

 ?>
