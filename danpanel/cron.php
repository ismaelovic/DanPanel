<?php
include('server.php');

$query = "SELECT * FROM bookings A left outer join company B on A.companyId=B.companyId right outer join login C on A.userId=C.brugerId WHERE A.date = date(NOW()) + INTERVAL 1 DAY";
$result = mysqli_query($db, $query);
$today = date('Y-m-d - h:i:s');
if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
          $idA = $row['userId'];
          $firma = $row['companyName'];
          $firmaId = $row['companyId'];
          $nameA = $row['name'];
          $dateA = $row['date'];
          $timeslot = $row['timeslot'];
          $to = $row['number'];

          $username = 'cphiz4';
          $apikey = '96bef698-6e42-4885-832e-5b10470d42bd';
          $sendto = '45'.$to.'';
          $from = '4531170049';
          $message="Hej $nameA. Husk din aftale imorgen $dateA";

          //$url = 'https://'.$username.':'.$apikey.'@api.cpsms.dk/v2/simplesend/'.$sendto.'/'.urlencode($message).'/'.$from;
          //file_get_contents($url);

          $file = dirname(__FILE__) . '/output.txt';
          $data = "ID: $idA - Hej $nameA. Husk din aftale imorgen d. $dateA - $timeslot med $firma. sendt: $today \n";
          file_put_contents($file, $data, FILE_APPEND);
          //echo("<script>console.log('ID: $idA -- $nameA har en aftale imorgen! $to med $firma. sendt: $today ');</script>");
 }
 }
 else {
   $file = dirname(__FILE__) . '/output.txt';
   $data = "Ingen kommende reservationer. Sendt: $today \n";
   file_put_contents($file, $data, FILE_APPEND);
 }

 ?>
