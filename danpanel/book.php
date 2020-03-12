<?php
include('server.php');
	if ($_SESSION['user_type'] != 'kunde') {
      session_destroy();
		header("location: login.php");

     }
	else if(!isset($_SESSION['user_type'])) {
			 session_destroy();
			 header("location: login.php");
		 }

	else if (!isset($_SESSION['username'])) {
		session_destroy();
		$_SESSION['msg'] = "Du er ikke logget ind korrekt";
		header('location: login.php');
	}

	else if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header("location: login.php");
	}
	$bruger = $_SESSION['username'];
  $brugerId = $_SESSION['userId'];
	$firma = $_SESSION['salonName'];
	$firmaId = $_SESSION['salonId'];
	$employeeId = $_SESSION['employeeId'];

	include('head.php');

	//echo "<script type='text/javascript'>alert('bruger: $bruger firma: $firma firmaId: $firmaId medarbejder $employeeId ');</script>";
if(isset($_GET['date'])){
    $date = $_GET['date'];
    //echo "<script type='text/javascript'>alert('Dato: $date');</script>";
    $mysqli = new mysqli('mysql14.unoeuro.com', 'izkea_dk', 'jemobid94', 'izkea_dk_db');
    $stmt=$mysqli->prepare("SELECT * FROM bookings WHERE date=? AND employeeId =?");
    $stmt->bind_param("ss", $date, $employeeId);
    $bookings = array();
    if($stmt->execute()) {
      $result=$stmt->get_result();
      if ($result->num_rows>0) {
        while ($row=$result->fetch_assoc()) {
          $bookings[] = $row['timeslot'];
        }
        $stmt->close();

      }else{
        echo "<script type='text/javascript'>console.log('ingen bookinger idag');</script>";
      }
    }else{
      echo "<script type='text/javascript'>console.log('Fejl');</script>";
    }
}

if(isset($_POST['book_appointment'])){
    $timeslot = $_POST['timeslot'];
		$service = $_POST['service'];
    $stmt=$mysqli->prepare("SELECT * FROM bookings WHERE date=? AND timeslot=? AND employeeId=?");
    $stmt->bind_param("sss", $date, $timeslot, $employeeId);
    if($stmt->execute()) {
      $result=$stmt->get_result();
      if ($result->num_rows>0){
          $msg = "<div class='alert alert-danger'>Allerede booket</div>";
      } else {
        $stmt = $mysqli->prepare("INSERT INTO bookings (userId, companyId, serviceId, employeeId, name, timeslot, date) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param('sssssss', $brugerId, $firmaId, $service, $employeeId, $bruger, $timeslot, $date);
        $stmt->execute();

				$stmtMail = $mysqli->prepare("SELECT * FROM login WHERE brugerId=?");
				$stmtMail->bind_param('s', $brugerId);
				$stmtMail->execute();
				$result = $stmtMail->get_result();
				while ($row = $result->fetch_assoc()) {
					$userEmail = $row['email'];
					$headers = "From: ziyani.ismael@live.dk" . "\r\n";
					$subject = "Booking gennemført";
					$msg = "Hej $bruger. Du har booket en tid hos $firma. Din booking er \n$timeslot - $date \n\nVenlig hilsen \n\nDanPanel";
					mail($userEmail,$subject,$msg,$headers);
				}
        $msg = "<div class='alert alert-success' style='text-align: center;'>Booking gennemført. Du har booket tid hos $firma kl. $timeslot d. $date <br> Du får en kvittering over din registrerede e-mail adresse og en påmindelse over SMS</div>";
        $bookings[]=$timeslot;
        $stmt->close();
        $mysqli->close();
      }
    }

}

$weekday = date('l', strtotime($date));
$query = "SELECT * FROM employee WHERE employeeId='$employeeId'";
$result = mysqli_query($db, $query);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
	if($weekday == "Monday"){
		$start =  $row["startMonday"];
		$end = $row["endMonday"];
	}
	else if($weekday == "Tuesday"){
		$start =  $row["startTuesday"];
		$end = $row["endTuesday"];
	}
	else if($weekday == "Wednesday"){
		$start =  $row["startWednesday"];
		$end = $row["endWednesday"];
	}
	else if($weekday == "Thursday"){
		$start =  $row["startThursday"];
		$end = $row["endThursday"];
	}
	else if($weekday == "Friday"){
		$start =  $row["startFriday"];
		$end = $row["endFriday"];
	}
	else if($weekday == "Saturday"){
		$start =  $row["startSaturday"];
		$end = $row["endSaturday"];
	}
	else if($weekday == "Sunday"){
		$start =  $row["startSunday"];
		$end = $row["endSunday"];
	}
}
} else {
		echo "<script type='text/javascript'>console.log('Fejl i vagtplan');</script>";
}


$duration = 30;

function timeslots($duration, $start, $end){
  $start = new DateTime($start);
  $end = new DateTime($end);
  $interval = new DateInterval("PT".$duration."M");

	//DateInterval er en klasse der definerer et interval i tid ... P=Period, T=Time, M=minutes
  $slots = array();
  for($intStart=$start; $intStart<$end; $intStart->add($interval)){

		$endPeriod = clone $intStart;
    $endPeriod->add($interval);

    $slots[] = $intStart->format("H:i")."-".$endPeriod->format("H:i");
  }
  return $slots;
}
?>
<!doctype html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
  </head>

  <body>
    <nav class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header"> <a class="navbar-brand" href="kundeindex.php">DanPanel</a> </div>
						<ul class="nav navbar-nav navbar-right">
								<li> <a class=" logud" href="calendar.php">Tilbage til kalender</a> </li>
						</ul>
				</div>
		</nav>
    <div class="container">
        <h1 class="text-center" style="margin: 3vh;">Booking for dato: <?php echo date('d. F Y', strtotime($date)); ?></h1>
        <div class="row" style="margin:auto; width:90%;">
          <div class="col-md-12">
            <?php echo isset($msg)?$msg:"";?>
          </div>
            <?php
              $timeslots = timeslots($duration, $start, $end);
              $datetoday = date("Y-m-d");
              $timeNow = date("H:i");
              foreach($timeslots as $ts){
                ?>
                <div class="col-xs-4 col-md-2" id="timeButtons">
                  <div class="form-group">
                    <?php if($date==$datetoday && $ts < $timeNow){ ?>
                        <button class="btn" style="border:solid lightgray 1px;"><?php echo "Utilgængelig"; ?></button>
                    <?php }
                    else if (in_array($ts, $bookings)) {?>
                      <button class="btn btn-danger"><?php echo $ts; ?></button>
                    <?php
                    }
                    else{ ?>
                      <button class="btn btn-success book" data-timeslot="<?php echo $ts ?>"><?php echo $ts; ?></button>
                      <?php } ?>
                  </div>
                </div>
                <?php
              }
              ?>
        </div>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Booking for <span id="slot"></span> </h4>
      </div>
      <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <form class="" action="" method="post">
            <div class="form-group">
              <label for="timeslot">Time</label>
              <input type="text" readonly name="timeslot" id="timeslot" class="form-control">
            </div>
						<div class="form-group">
              <label for=""></label>
							<?php
							$query = "SELECT * FROM Services WHERE companyId='$firmaId' ORDER BY serviceID";
							$result = mysqli_query($db, $query);
							?>
              <select name="service" class="form-control">
								<?php 	while($row = $result->fetch_assoc()) {  ?>
              	<option value="<?php echo $row['serviceID'] ?>"> <?php echo $row['serviceName']; echo "  -  "; echo $row['serviceDuration']; echo " min";   ?></option>
								<?php 	} ?>
              </select>
            </div>
            <div class="form-group pull-right">
              <button type="submit" name="book_appointment" class="btn btn-success">Book</button>
            </div>
          </form>
        </div>
      </div>
      </div>
    </div>

  </div>
</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script>
  $(".book").click(function(){
    var timeslot = $(this).attr('data-timeslot');
    $("#slot").html(timeslot);
    $("#timeslot").val(timeslot);
    $("#myModal").modal("show");
  });
</script>
  </body>

</html>
