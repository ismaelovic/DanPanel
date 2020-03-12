<?php include('server.php');
    if ($_SESSION['user_type'] != 'admin') {
         session_destroy();
		     header("location: login.php");
     }


	if (!isset($_SESSION['username'])) {
    session_destroy();
		header('location: login.php');
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header("location: login.php");
	}
  $firma = $_SESSION['user_shop'];
  $firmaId = $_SESSION['companyId'];
  include('head.php');
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Håndter medarbejdere</title>
        <meta name="robots" content="noindex, nofollow">
        <link rel="stylesheet" href="css/flexboxgrid.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
        <link rel="icon" href="img/ifapple.png">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
          .container {
                margin-top: 7vh;
            }

            .resultat input[type=text] {
                width: 5vw;
                border: none;
                background-color: whitesmoke;
                text-align: center;
            }

            footer {
                margin-top: 12vh;
            }
        </style>
    </head>

    <body>
        <header>
          <nav class="navbar navbar-inverse">
              <div class="container-fluid">
                  <div class="navbar-header"> <a class="navbar-brand" href="adminindex.php">DanPanel</a> </div>
                  <ul class="nav navbar-nav">
                      <li><a href="tjek.php">Tjek bestillinger</a></li>
                      <li><a href="lager.php">Services</a></li>
                      <li><a href="addEmployee.php">Tilføj medarbejder</a></li>
                      <li class="active"><a href="tjeklogin.php">Håndter brugere</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                      <li> <a class="logud" href="adminindex.php?logout='1'">Log ud</a> </li>
                  </ul>
              </div>
          </nav>
        </header>
        <div class="container">
            <div class="row con">
                <h3><?php echo $firma?> medarbejdere</h3></div>
            <div class="row tjek">
                <div class="resultat">
                        <form action="tjeklogin.php" method="post">
                            <?php

             $query = "SELECT * FROM employee WHERE companyId = $firmaId";

		$result = mysqli_query($db, $query);

      if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        echo "<table border = 0>";

        ?>
                                <div class="round">
                                    <input type="radio" id="checkbox" name="employeeId" value="<?php echo $row['employeeId'] ?>">
                                    <input type="text" readonly value="<?php echo ucfirst($row['employeeId'])?>">
                                    <input type="text" readonly value="<?php echo ucfirst($row['employeeName'])?>">
                                        <?php echo "Tlf nr: "; echo ucfirst ($row["number"]);?>
                                </div>
                                <?php

        echo "</table>";
    }
      }



        ?>
        <div class="submit-buttons">
          <input type="submit" class="btn btn-warning" name="update_login_btn" value="Opdatér">
          <input type="submit" class="btn btn-danger" name="slet_login_btn" value="Slet"> </form>
        </div>

                </div>
                <?php
                if (isset($_POST['update_login_btn'])) {
                  $employeeId = $_POST['employeeId'];
                  $query = "SELECT * FROM employee WHERE employeeId = '$employeeId'";
                  $result = mysqli_query($db, $query);
                  ?>
                <div class="opdater">
                  <div class="text-center">
                      <h4>Opdatér oplysninger</h4> </div>
                  <form method="post" action="tjeklogin.php">
                      <?php include('errors.php');
                      if (mysqli_num_rows($result) == 1) {
                        //echo "<script>console.log('medarbejderId: " . $employeeId . "' );</script>";
                      while($row = $result->fetch_assoc()) {
                       ?>
                       <div class="datoer">
                          <div class="input-group row">
                          <label>Navn</label>
                          <input type="hidden" name="id" value="<?php echo $employeeId; ?>">
                          <input type="text" name="name" value="<?php echo ucfirst($row['employeeName']) ?>"> </div>
                          <div class="input-group row">
                          <label>Telefon nummer</label>
                          <input type="text" name="number" value="<?php echo $row['number'] ?>"> </div>

                            <div class="input-group row">
                                <label for="mondayStart">Mandag</label>
                                <select name="mondayStart" class="startDate text-center">
                                      <option class="firstChoice" value="<?php echo $row['startMonday'] ?>"><?php echo $row['startMonday'] ?></option>
                                      <option value="08:00">08:00</option>
                                      <option value="09:00">09:00</option>
                                      <option value="10:00">10:00</option>
                                      <option value="11:00">11:00</option>
                                      <option value="12:00">12:00</option>
                                      <option value="Fri">Fri</option>
                                  </select>
                                  <select name="mondayEnd" class="endDate text-center">
                                      <option class="firstChoice" value="<?php echo $row['endMonday'] ?>"><?php echo $row['endMonday'] ?></option>
                                      <option value="17:00">17:00</option>
                                      <option value="18:00">18:00</option>
                                      <option value="19:00">19:00</option>
                                      <option value="20:00">20:00</option>
                                      <option value="21:00">21:00</option>
                                      <option value="Fri">Fri</option>
                                    </select>
                            </div>
                            <div class="input-group row">
                                <label for="tuesdayStart">Tirsdag</label>
                                <select name="tuesdayStart" class="startDate text-center">
                                      <option class="firstChoice" value="<?php echo $row['startTuesday'] ?>"><?php echo $row['startTuesday'] ?></option>
                                      <option value="08:00">08:00</option>
                                      <option value="09:00">09:00</option>
                                      <option value="10:00">10:00</option>
                                      <option value="11:00">11:00</option>
                                      <option value="12:00">12:00</option>
                                      <option value="Fri">Fri</option>
                                  </select>
                                  <select name="tuesdayEnd" class="endDate text-center">
                                        <option value="<?php echo $row['endTuesday'] ?>" class="firstChoice"><?php echo $row['endTuesday'] ?></option>
                                        <option value="17:00">17:00</option>
                                        <option value="18:00">18:00</option>
                                        <option value="19:00">19:00</option>
                                        <option value="20:00">20:00</option>
                                        <option value="21:00">21:00</option>
                                        <option value="Fri">Fri</option>
                                    </select>
                            </div>
                            <div class="input-group row">
                                <label for="wednesdayStart">Onsdag</label>
                                <select name="wednesdayStart" class="startDate text-center">
                                      <option value="<?php echo $row['startWednesday'] ?>" class="firstChoice"><?php echo $row['startWednesday'] ?></option>
                                      <option value="08:00">08:00</option>
                                      <option value="09:00">09:00</option>
                                      <option value="10:00">10:00</option>
                                      <option value="11:00">11:00</option>
                                      <option value="12:00">12:00</option>
                                      <option value="Fri">Fri</option>
                                  </select>
                                  <select name="wednesdayEnd" class="endDate text-center">
                                        <option value="<?php echo $row['endWednesday'] ?>" class="firstChoice"><?php echo $row['endWednesday'] ?></option>
                                        <option value="17:00">17:00</option>
                                        <option value="18:00">18:00</option>
                                        <option value="19:00">19:00</option>
                                        <option value="20:00">20:00</option>
                                        <option value="21:00">21:00</option>
                                        <option value="Fri">Fri</option>
                                    </select>
                            </div>
                            <div class="input-group row">
                                <label for="thursdayStart">Torsdag</label>
                                <select name="thursdayStart" class="startDate text-center">
                                      <option value="<?php echo $row['startThursday'] ?>" class="firstChoice"><?php echo $row['startThursday'] ?></option>
                                      <option value="08:00">08:00</option>
                                      <option value="09:00">09:00</option>
                                      <option value="10:00">10:00</option>
                                      <option value="11:00">11:00</option>
                                      <option value="12:00">12:00</option>
                                      <option value="Fri">Fri</option>
                                  </select>
                                  <select name="thursdayEnd" class="endDate text-center">
                                        <option value="<?php echo $row['endThursday'] ?>" class="firstChoice"><?php echo $row['endThursday'] ?></option>
                                        <option value="17:00">17:00</option>
                                        <option value="18:00">18:00</option>
                                        <option value="19:00">19:00</option>
                                        <option value="20:00">20:00</option>
                                        <option value="21:00">21:00</option>
                                        <option value="Fri">Fri</option>
                                    </select>
                            </div>
                            <div class="input-group row">
                                <label for="fridayStart">Fredag</label>
                                <select name="fridayStart" class="startDate text-center">
                                      <option value="<?php echo $row['startFriday'] ?>" class="firstChoice"><?php echo $row['startFriday'] ?></option>
                                      <option value="08:00">08:00</option>
                                      <option value="09:00">09:00</option>
                                      <option value="10:00">10:00</option>
                                      <option value="11:00">11:00</option>
                                      <option value="12:00">12:00</option>
                                      <option value="Fri">Fri</option>
                                  </select>
                                  <select name="fridayEnd" class="endDate text-center">
                                        <option value="<?php echo $row['endFriday'] ?>" class="firstChoice"><?php echo$row['endFriday'] ?></option>
                                        <option value="17:00">17:00</option>
                                        <option value="18:00">18:00</option>
                                        <option value="19:00">19:00</option>
                                        <option value="20:00">20:00</option>
                                        <option value="21:00">21:00</option>
                                        <option value="Fri">Fri</option>
                                    </select>
                            </div>
                            <div class="input-group row">
                                <label for="saturdayStart">Lørdag</label>
                                <select name="saturdayStart" class="startDate text-center">
                                      <option value="<?php echo $row['startSaturday'] ?>" class="firstChoice"><?php echo $row['startSaturday'] ?></option>
                                      <option value="08:00">08:00</option>
                                      <option value="09:00">09:00</option>
                                      <option value="10:00">10:00</option>
                                      <option value="11:00">11:00</option>
                                      <option value="12:00">12:00</option>
                                      <option value="Fri">Fri</option>
                                  </select>
                                  <select name="saturdayEnd" class="endDate text-center">
                                        <option value="<?php echo $row['endSaturday'] ?>" class="firstChoice"><?php echo $row['endSaturday'] ?></option>
                                        <option value="17:00">17:00</option>
                                        <option value="18:00">18:00</option>
                                        <option value="19:00">19:00</option>
                                        <option value="20:00">20:00</option>
                                        <option value="21:00">21:00</option>
                                        <option value="Fri">Fri</option>
                                    </select>
                            </div>
                            <div class="input-group row">
                                <label for="sundayStart">Søndag</label>
                                <select name="sundayStart" class="startDate text-center">
                                      <option value="<?php echo $row['startSunday'] ?>" class="firstChoice"><?php echo $row['startSunday'] ?></option>
                                      <option value="08:00">08:00</option>
                                      <option value="09:00">09:00</option>
                                      <option value="10:00">10:00</option>
                                      <option value="11:00">11:00</option>
                                      <option value="12:00">12:00</option>
                                      <option value="Fri">Fri</option>
                                  </select>
                                  <select name="sundayEnd" class="endDate text-center">
                                        <option value="<?php echo $row['endSunday'] ?>" class="firstChoice"><?php echo $row['endSunday'] ?></option>
                                        <option value="17:00">17:00</option>
                                        <option value="18:00">18:00</option>
                                        <option value="19:00">19:00</option>
                                        <option value="20:00">20:00</option>
                                        <option value="21:00">21:00</option>
                                        <option value="Fri">Fri</option>
                                    </select>
                            </div>
                          </div>


                              <button type="submit" class="btn btn-warning" name="update_employee">Opdatér</button>

                          <?php }

                          }
                          else {
                            echo "<script type='text/javascript'>alert('Mere end 1 resultat!');</script>";
                          }
                        }
                        ?>
                  </form>
                </div>
            </div>
        </div>

        <footer>

        </footer>
    </body>


    </html>
