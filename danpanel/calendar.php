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
		$_SESSION['msg'] = "Du er ikke logget ind korrekt";
		header('location: login.php');
	}

	else if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header("location: login.php");
	}

	$bruger = $_SESSION['username'];
	$firma = $_SESSION['salonName'];
	$firmaId = $_SESSION['salonId'];

	include('head.php');
	//echo "<script type='text/javascript'>alert('bruger: $bruger firma: $firma firma: $firmaId ');</script>";
	function build_calendar($month, $year, $employeeId){

		// titler for ugedage
 	 $daysOfWeek = array('Søndag','Mandag','Tirsdag','Onsdag','Torsdag','Fredag','Lørdag');

 	 // dag for den givne måned. konvereteret til unix timestamp
 	 $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

 	 // How many days does this month contain?
 	 $numberDays = date('t',$firstDayOfMonth);

	 //Array info for current month
 	 $dateComponents = getdate($firstDayOfMonth);

 	 // What is the name of the month in question?
 	 $monthName = $dateComponents['month'];

 	 //Index værdi af hvilken ugedag det er. fra 0-6
 	 $dayOfWeek = $dateComponents['wday'];


	 //Aktuel dato
 	$datetoday = date('Y-m-d');

//oprette kalender i tabelform med header
 	$calendar = "<table class='table table-bordered'>";
 	$calendar .= "<center><h3>$monthName $year</h3>";
	//mktime(hour, minute, second, month, day, year)
 	$calendar.= "<a class='btn btn-xs btn-primary' href='?month=".date('m', mktime(0, 0, 0, $month-1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month-1, 1, $year))."'>Forrige måned</a> ";

 	$calendar.= " <a class='btn btn-xs btn-primary' href='?month=".date('m')."&year=".date('Y')."'>Nuværende måned</a> ";

 	$calendar.= "<a class='btn btn-xs btn-primary' href='?month=".date('m', mktime(0, 0, 0, $month+1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month+1, 1, $year))."'>Næste måned</a></center><br>";



 		$calendar .= "<tr>";

    //kalender header med dagenavne
     foreach($daysOfWeek as $day){
        $calendar.="<th class='header' style='text-align:center;'>$day</th>";
     }

    $calendar.= "</tr><tr>";

		//De første dage på ugen er tomme.
    if($dayOfWeek > 0){
        for($i=0;$i<$dayOfWeek;$i++){
            $calendar.="<td></td>";
        }
    }

    //dag counter
    $currentDay = 1;

    //nummer på måneden i 2 cifre.
    $month = str_pad($month,2,"0", STR_PAD_LEFT);

    while($currentDay <= $numberDays){
			//her sørger vi for der kun er 7 dage pr række
        if($dayOfWeek == 7){
            $dayOfWeek = 0;
            $calendar.= "</tr><tr>";
        }

        $currentDayRel = str_pad($currentDay,2,"0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";
        $today = $date==date('Y-m-d')? "today":"";
				$weekday = date('l', strtotime($date));
				$db = mysqli_connect('mysql14.unoeuro.com', 'izkea_dk', 'jemobid94', 'izkea_dk_db');
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
		}
		else {
			echo "<script>console.log('Query virker ikke! ' );</script>";
		}


				if($date<date('Y-m-d')){
            $calendar.="<td><h4>$currentDay</h4><button class='btn btn-xs' style='border:solid lightgray 1px;'>Utilgængelig</button>";
        }
        else if($start==trim("Fri") || $end==trim("Fri")){
            $calendar.="<td class='$today'><h4>$currentDay</h4><button class='btn btn-warning btn-xs'>Fri</button>";
        }
        else{
             $calendar.="<td class='$today'><h4>$currentDay</h4><a href='book.php?date=".$date."' class='btn btn-success btn-xs'>Book</a>";
        }


        $calendar.="</td>";

        //incrementing counters
        $currentDay++;
        $dayOfWeek++;
    }

    //færdiggør kolonnen hvis der ikke er flere dage på ugen
    if($dayOfWeek != 7){
        $remainingDays = 7-$dayOfWeek;
        for($i=0;$i<$remainingDays;$i++){
            $calendar.="<td></td>";
        }
    }

    $calendar.="</tr>";
    $calendar.="</table>";
    echo $calendar;
}

?>


<html>
	<head>
		<title>Calendar Example</title>

        <style>
						.container{
						padding-right:1.5vw;
						padding-left: 1.5vw;
						overflow-y: scroll;
						}
            table{
                table-layout: fixed;
            }
            td{
                width: 33%;
            }
						.today h4{
							font-weight: bold;
							font-size: 1.5vw;
							color: green;
						}

        </style>
        </head>

	<body>
		<nav class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header"> <a class="navbar-brand" href="kundeindex.php">DanPanel</a> </div>
						<ul class="nav navbar-nav navbar-right">
								<li> <a class=" logud" href="kundeindex.php">Tilbage til forside</a> </li>
						</ul>
				</div>
		</nav>

	<div class="container">
		<div class="row overlay" id="overlay">
			<h3 class="text-center col-xs-12">Vælg din medarbejder hos <?php echo ucfirst($firma)?></h3>
	<?php
 $query = "SELECT * FROM employee WHERE companyId = '$firmaId' ORDER BY employeeId ASC";
 $result = mysqli_query($db, $query);
	while($row = $result->fetch_assoc()) {
		?>
		<div class="col-xs-12 employeeWrapper">
		<form method="post" action="">
	<div class="employee">
		<input type="hidden" name="salonId" value="<?php echo $salonId?>">
		<input type="hidden" name="salonName" value="<?php echo $salonName?>">
		<input type="hidden" name="employeeId" value="<?php echo $row["employeeId"]?>">
		<input class="text-center btn btn-primary" type="submit" name="pickEmployee" value="<?php echo ucfirst($row["employeeName"])?>">
	</div>
		</form>
		</div>
		<?php
		 }
 ?>
		</div>
	    <div class="row">
	        <?php
					if(isset($_POST['pickEmployee'])) {
						?>
						<script language="javascript">
							document.getElementById("overlay").style.display = "none";
						</script>
						<?php

						$employeeId = $_POST['employeeId'];
						$dateComponents = getdate();
					 if(isset($_GET['month']) && isset($_GET['year'])){
							 $month = $_GET['month'];
							 $year = $_GET['year'];
					 }
					 else{
							 $month = $dateComponents['mon'];
							 $year = $dateComponents['year'];
					 }
					echo build_calendar($month,$year, $employeeId);
					$_SESSION['employeeId'] = $employeeId;
					}
            ?>
	    </div>
	</div>

	</body>
</html>
