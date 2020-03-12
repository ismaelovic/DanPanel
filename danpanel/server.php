<?php

session_start();

$errors = array();

// Database opsættelse
$db = mysqli_connect('mysql14.unoeuro.com', 'izkea_dk', 'jemobid94', 'izkea_dk_db');
$db->set_charset("utf8");
// Ved Log ind
if (isset($_POST['login_user'])) {
	$email = mysqli_real_escape_string($db, $_POST['email']);
	$password = mysqli_real_escape_string($db, $_POST['password']);

    // tjek om felterne er udfyldt
	if (empty($email)) {
		array_push($errors, "E-mail mangler");
	}
	if (empty($password)) {
		array_push($errors, "Adgangskode mangler");
	}

	if (count($errors) == 0) {

        //Validere om inputs findes i tabellen
		$query = "SELECT * FROM login WHERE email='$email' AND adgangskode='$password'";

        //bruger fundet
		$results = mysqli_query($db, $query);


		if (mysqli_num_rows($results) == 1) {

            $logged_in_user = mysqli_fetch_assoc($results);
						//tjek om bruger er admin eller kunde
            if ($logged_in_user['brugertype'] == 'admin') {

							$companyId = $logged_in_user['companyId'];
							$query2 = "SELECT * FROM company WHERE companyId = '$companyId'";
							$result2 = mysqli_query($db, $query2);
							$getCompany = mysqli_fetch_assoc($result2);

								$_SESSION['userId'] = $logged_in_user['brugerId'];
                $_SESSION['username'] = $logged_in_user['brugernavn'];
								$_SESSION['user_type'] = $logged_in_user['brugertype'];
								$_SESSION['companyId'] = $companyId;
								$_SESSION['user_shop'] = $getCompany['companyName'];

                //admin siden
                header('location: adminindex.php');
			}
            //bruger = kunde henvis til kundeside
            else{
								$_SESSION['userId'] = $logged_in_user['brugerId'];
                $_SESSION['username'] = $logged_in_user['brugernavn'];
								$_SESSION['user_type'] = $logged_in_user['brugertype'];
                //kunde siden
								header('location: kundeindex.php');
			}
        }
				else if (mysqli_num_rows($results) > 1) {
					array_push($errors, "Fejl mere end 1 resultat");
				}
		else {
			array_push($errors, "Forkert email eller adgangskode");
		}
	}
}

// Ny bruger
if (isset($_POST['update_user'])) {
	// Input fra forms
	$brugerId = $_SESSION['userId'];
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$lastname = mysqli_real_escape_string($db, $_POST['lastname']);
	$email = mysqli_real_escape_string($db, $_POST['email']);
  $number = mysqli_real_escape_string($db, $_POST['number']);
	$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
	$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

	// Validering af input i felterne
	if (empty($username)) { array_push($errors, "Brugernavn mangler"); }
	if (empty($password_1)) { array_push($errors, "Adgangskode mangler"); }
	if (empty($number) || strlen($number)!=8) { array_push($errors, "Indtast venligst et gyldigt nummer"); }

    //koderne skal være ens
    if ($password_1 != $password_2) {
		array_push($errors, "De indtastede koder er ikke ens");
	}

	// registrer bruger hvis der er ingen fejl
	if (count($errors) == 0) {
		$password = ($password_1);
        //tilføj til tabellen hvis der 0 fejl
		$query = "UPDATE login SET brugernavn='$username', efterNavn='$lastname', adgangskode='$password', email='$email', number='$number' WHERE brugerId = '$brugerId'";
		mysqli_query($db, $query);
		if(mysqli_affected_rows($db) == 1){
			if (mysqli_errno($db) == 1062) {
					array_push($errors, "Email eksisterer allerede");
			}
				$msg = "<div class='alert alert-success style=margin:auto;'>Dine info er nu opdateret!</div>";
			}
	else
		{//There was either nothing or an error
		if(mysqli_affected_rows($db) == 0){
			if (mysqli_errno($db) == 1062) {
					array_push($errors, "Email eksisterer allerede");
			}
		}
		if(mysqli_affected_rows($db) == -1) {
			if (mysqli_errno($db) == 1062) {
					array_push($errors, "Email eksisterer allerede");
			}
		}

    }
}
}

if (isset($_POST['reg_user'])) {
	// Input fra forms
	$userName = mysqli_real_escape_string($db, $_POST['username']);
	$lastName = mysqli_real_escape_string($db, $_POST['lastname']);
	$userNumber = mysqli_real_escape_string($db, $_POST['number']);
	$userEmail = mysqli_real_escape_string($db, $_POST['email']);
	$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
	$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

	// Validering af input i felterne
	if (empty($userName) || empty($lastName) ) { array_push($errors, "Navn mangler"); }
	if (empty($userEmail)) { array_push($errors, "E-mail adresse mangler"); }
	if (empty($password_1)) { array_push($errors, "Adgangskode mangler"); }
	if (empty($userNumber) || strlen($userNumber) != 8 ) { array_push($errors, "Indtast venligst et gyldigt nummer"); }
	if ($password_1 != $password_2) {
	array_push($errors, "De indtastede koder er ikke ens");
	}
	if (count($errors) == 0) {
		$password = ($password_1);
        //tilføj til tabellen hvis der 0 fejl
		$query = "INSERT INTO login (brugernavn, efterNavn, adgangskode, brugertype, number, email)
		VALUES('$userName', '$lastName', '$password', 'kunde', '$userNumber', '$userEmail')";
		$result = mysqli_query($db, $query);
		if (!$result) {
			//echo "<script>console.log('Fejlkode: " . mysqli_errno($db) . "' );</script>";
			if (mysqli_errno($db) == 1062) {
					array_push($errors, "Email eksisterer allerede");
			}
		echo '<script>console.log("Bruger blev IKKE tilføjet")</script>';
		}
		else {
			$headers = "From: ziyani.ismael@live.dk" . "\r\n";
			$subject = "Velkommen";
			$upperName = ucfirst($userName);
			$message = "Hej $upperName. Velkommen til DanPanel.";

			mail($userEmail,$subject,$message,$headers);
			$link = "<a href=login.php>Log ind</a>";
			$msg = "<div class='alert alert-success style=margin:auto;'>Velkommen $upperName. Din profil er nu oprettet. $link for at udforske videre.  </div>";
		}

	}
}

if (isset($_POST['forgot_user'])) {
	// Input fra form
	$userEmail = mysqli_real_escape_string($db, $_POST['email']);

	// Validering af input i felterne
	if (empty($userEmail)) { array_push($errors, "E-mail adresse mangler"); }

	if (count($errors) == 0) {
        //tilføj til tabellen hvis der 0 fejl
		$query = "SELECT * FROM login WHERE email='$userEmail'";
		$result = mysqli_query($db, $query);
		if(mysqli_affected_rows($db) == 1){
	  //your code here will execute when there is at least one result
		echo '<script>console.log("Bruger blev fundet!")</script>';
		while($row = $result->fetch_assoc()) {
						$userId = $row['brugerId'];
						$userName = $row['brugernavn'];
						$to = $row['email'];
						$headers = "From: ziyani.ismael@live.dk" . "\r\n";
						$subject = "Reset";
						$temp = uniqid();
						$message = "Hej $userName. Vi har bemærket at du har forsøgt at nulstille din adgangskode. Klik på linket for at gendanne din kode. http://www.izkea.dk/danpanel/reset.php?token=".$temp."&userId=".$userId."&userName=".$userName." \n\n\n Hvis du ikke har forsøgt at nulstille din kode så ignorer denne besked.";
						$query2 = "UPDATE login set token='$temp' WHERE email='$userEmail'";
						$result2 = mysqli_query($db, $query2);
					 }
						echo "<script>console.log('Id: " . $temp . "' );</script>";
						mail($to,$subject,$message,$headers);
						$msg = "<div class='alert alert-success style=margin:auto;'> Der er nu sendt en mail til $to. Tjek din indbakke for at nulstille din kode.</div>";
	}
	else
	{//Ingen resultater eller fejl
	  if(mysqli_affected_rows($db) == 0){
	    //There were 0 results
			array_push($errors, "$userEmail blev ikke fundet..." );
	  }
	  if(mysqli_affected_rows($db) == -1) {
	    //This executes when there is an error
			//$errocode = mysqli_errno($db);
			array_push($errors, "Fejl");

	  }
	}


    }
}



if (isset($_POST['reg_employee'])) {
	// Input fra forms
	$employeeName = mysqli_real_escape_string($db, $_POST['name']);
	$employeeNumber = mysqli_real_escape_string($db, $_POST['number']);
	$mondayStart = mysqli_real_escape_string($db, $_POST['mondayStart']);
  $mondayEnd = mysqli_real_escape_string($db, $_POST['mondayEnd']);
	$tuesdayStart = mysqli_real_escape_string($db, $_POST['tuesdayStart']);
	$tuesdayEnd = mysqli_real_escape_string($db, $_POST['tuesdayEnd']);
	$wednesdayStart = mysqli_real_escape_string($db, $_POST['wednesdayStart']);
	$wednesdayEnd = mysqli_real_escape_string($db, $_POST['wednesdayEnd']);
	$thursdayStart = mysqli_real_escape_string($db, $_POST['thursdayStart']);
	$thursdayEnd = mysqli_real_escape_string($db, $_POST['thursdayEnd']);
	$fridayStart = mysqli_real_escape_string($db, $_POST['fridayStart']);
	$fridayEnd = mysqli_real_escape_string($db, $_POST['fridayEnd']);
	$saturdayStart = mysqli_real_escape_string($db, $_POST['saturdayStart']);
	$saturdayEnd = mysqli_real_escape_string($db, $_POST['saturdayEnd']);
	$sundayStart = mysqli_real_escape_string($db, $_POST['sundayStart']);
	$sundayEnd = mysqli_real_escape_string($db, $_POST['sundayEnd']);

	// Validering af input i felterne
	if (empty($employeeName)) { array_push($errors, "Navn mangler"); }
	if (empty($employeeNumber) || strlen($employeeNumber) != 8) { array_push($errors, "Indtast et gyldigt nummer"); }

	$companyId = $_SESSION['companyId'];
	// registrer bruger hvis der er ingen fejl
	if (count($errors) == 0) {
        //tilføj til tabellen hvis der 0 fejl
		$query = "INSERT INTO employee (employeeName, companyId, number, startMonday, endMonday, startTuesday, endTuesday, startWednesday, endWednesday, startThursday, endThursday, startFriday, endFriday, startSaturday, endSaturday, startSunday, endSunday)VALUES('$employeeName', '$companyId', '$employeeNumber', '$mondayStart', '$mondayEnd', '$tuesdayStart', '$tuesdayEnd', '$wednesdayStart',
		'$wednesdayEnd', '$thursdayStart', '$thursdayEnd', '$fridayStart', '$fridayEnd', '$saturdayStart', '$saturdayEnd', '$sundayStart', '$sundayEnd')";
		mysqli_query($db, $query);

		$upperName = ucfirst($employeeName);
		$msg = "<div class='alert alert-success style=margin:auto;'>$upperName er nu oprettet som medarbejder.</div>";
    }
}

if (isset($_POST['update_employee'])) {
	// Input fra forms
	$medarbejderId = mysqli_real_escape_string($db, $_POST['id']);
	$employeeName = mysqli_real_escape_string($db, $_POST['name']);
	$employeeNumber = mysqli_real_escape_string($db, $_POST['number']);
	$mondayStart = mysqli_real_escape_string($db, $_POST['mondayStart']);
  $mondayEnd = mysqli_real_escape_string($db, $_POST['mondayEnd']);
	$tuesdayStart = mysqli_real_escape_string($db, $_POST['tuesdayStart']);
	$tuesdayEnd = mysqli_real_escape_string($db, $_POST['tuesdayEnd']);
	$wednesdayStart = mysqli_real_escape_string($db, $_POST['wednesdayStart']);
	$wednesdayEnd = mysqli_real_escape_string($db, $_POST['wednesdayEnd']);
	$thursdayStart = mysqli_real_escape_string($db, $_POST['thursdayStart']);
	$thursdayEnd = mysqli_real_escape_string($db, $_POST['thursdayEnd']);
	$fridayStart = mysqli_real_escape_string($db, $_POST['fridayStart']);
	$fridayEnd = mysqli_real_escape_string($db, $_POST['fridayEnd']);
	$saturdayStart = mysqli_real_escape_string($db, $_POST['saturdayStart']);
	$saturdayEnd = mysqli_real_escape_string($db, $_POST['saturdayEnd']);
	$sundayStart = mysqli_real_escape_string($db, $_POST['sundayStart']);
	$sundayEnd = mysqli_real_escape_string($db, $_POST['sundayEnd']);

	// Validering af input i felterne
	if (empty($employeeName)) { array_push($errors, "Navn mangler"); }
	if (empty($employeeNumber) || strlen($employeeNumber)!=8) { array_push($errors, "Indtast venligst et gyldigt telefon nummer "); }

	// registrer bruger hvis der er ingen fejl
	if (count($errors) == 0) {
		echo "<script>console.log('medarbejder: " . $employeeName . "' );</script>";
        //tilføj til tabellen hvis der 0 fejl
		$query = "UPDATE employee SET employeeName='$employeeName', number='$employeeNumber', startMonday='$mondayStart', endMonday='$mondayEnd',
		startTuesday='$tuesdayStart', endTuesday='$tuesdayEnd', startWednesday='$wednesdayStart', endWednesday='$wednesdayEnd',
		startThursday='$thursdayStart', endThursday='$thursdayEnd', startFriday='$fridayStart', endFriday='$fridayEnd',
		startSaturday='$saturdayStart', endSaturday='$saturdayEnd', startSunday='$sundayStart', endSunday='$sundayEnd' WHERE employeeId='$medarbejderId'";

		$result = mysqli_query($db, $query);
		if(!$result){
			$errorcode = mysqli_errno($db);
			echo '<script>console.log("Fejlkode = '. $errorcode .' ")</script>';
		}
		if(mysqli_affected_rows($db) == 1){
			$upperName = ucfirst($employeeName);
			echo "<script type='text/javascript'>alert('$upperName er nu opdateret')</script>";
	  	}
	else
		{//There was either nothing or an error
		if(mysqli_affected_rows($db) == 0){
			$errorcode = mysqli_errno($db);
			echo '<script>console.log("Fejlkode = '. $errorcode .' ")</script>';
		}
		if(mysqli_affected_rows($db) == -1) {
			if (mysqli_errno($db) == 1062) {
					array_push($errors, "Email eksisterer allerede");
			}
		}

    }
		}
}

//tilføj services til salon
if (isset($_POST['add_btn'])) {
    // Input fra forms
	$name = mysqli_real_escape_string($db, $_POST['name']);
	$description = mysqli_real_escape_string($db, $_POST['description']);
	$duration = mysqli_real_escape_string($db, $_POST['duration']);
	$cleanup = mysqli_real_escape_string($db, $_POST['cleanup']);
  $price = mysqli_real_escape_string($db, $_POST['price']);

    	// Validering af input i felterne
			if (empty($name)) {  array_push($errors, "Navn mangler");}
			if (empty($description)) { array_push($errors, "Beskrivelse mangler"); }
    	if (empty($duration)) {  array_push($errors, "Varighed mangler");}
    	if (empty($price)) {  array_push($errors, "Pris mangler"); }

    $companyId = $_SESSION['companyId'];

    // Tilføj til lager hvis der er ingen fejl
	if (count($errors) == 0) {

	$query = "INSERT INTO Services (companyId, serviceName, serviceDescription, serviceDuration, cleanUp, servicePrice)
	VALUES('$companyId', '$name', '$description', '$duration', '$cleanup', '$price')";

		mysqli_query($db, $query);

        //respons
      echo "<script type='text/javascript'>alert('$name er nu tilføjet som service!')</script>";
       //header('location: tilvarer.php');

}
    //fejl
    else{
        echo '<script>console.log("Varen blev IKKE tilføjet")</script>';
    }

}

 if (isset($_POST['cancel'])) {
	$today = date('Y-m-d');
  $appointmentId = $_POST['appointmentId'];
	$query = "SELECT date FROM bookings WHERE id = '$appointmentId'";
	$result = mysqli_query($db, $query);
	if ($result->num_rows==1) {
		while($row = $result->fetch_assoc()) {
			$appointmentdate = $row['date'];
		 }
		 if($appointmentdate<=$today){
	 		echo "<script type='text/javascript'>alert('Du kan ikke aflyse denne aftale.')</script>";
	 	 }
	 	else {
	 		$query = "DELETE FROM bookings WHERE id='$appointmentId'";
	 		echo "<script>console.log('Idag er det: " . $today . "' );</script>";
	 		echo "<script>console.log('Aftale: " . $appointmentId . " og dens dato er : ". $appointmentdate ."' );</script>";
	 		$result = mysqli_query($db, $query);
	 		echo "<script type='text/javascript'>alert('Din booking er nu slettet ID-nr.($appointmentId)')</script>";
	 	}
	 }
	 else {
	 	echo "<script>console.log('Ingen booking fundet!' );</script>";
	 }
 }

 if (isset($_POST['slet_service'])) {
        $productId = $_POST['productid'];
				$productName = $_POST['productName'];

          $query = "DELETE FROM Services WHERE serviceID='$productId'";


		$result = mysqli_query($db, $query);
      echo "<script type='text/javascript'>alert('$productName er nu slettet nr.(id = $productId)')</script>";
 }

//slet bruger fra system
if (isset($_POST['slet_login_btn'])) {

    $username = $_POST['username'];

    $query = "DELETE FROM employee WHERE employeeName='$username'";

		$result = mysqli_query($db, $query);
    echo "<script type='text/javascript'>alert(' $username er nu slettet ')</script>";
}

if (isset($_POST['pickShop'])) {
	$_SESSION['salonId'] = $_POST['salonId'];
  $_SESSION['salonName'] = $_POST['salonName'];

  header('location: calendar.php');
}



?>
