<?php include('server.php');

if ($_SESSION['user_type'] != 'kunde') {
         session_destroy();

		header("location: login.php");

     }

	if (!isset($_SESSION['username'])) {
		$_SESSION['msg'] = "Du er ikke logget ind korrekt";
		header('location: login.php');
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header("location: login.php");
	}
include('head.php');
  ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Dine bestillinger</title>
        <meta name="robots" content="noindex, nofollow">
        <link rel="stylesheet" href="css/flexboxgrid.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
        <link rel="icon" href="img/ifapple.png">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body {
                overflow-x: hidden;
            }

            .tjek form{
              width: 85%;
              padding-top: 2vw;
              text-align: left;
              margin-left: 25vw;
            }

            input[type=text] {
                border: none;
                background-color: transparent;
                text-align: center;
            }
        </style>
    </head>

    <body>
      <header>
          <nav class="navbar navbar-inverse">
              <div class="container-fluid">
                  <div class="navbar-header"> <a class="navbar-brand" href="kundeindex.php">DanPanel</a> </div>
                  <ul class="nav navbar-nav">
                      <li class="active"><a href="kundetjek.php">Tjek bestillinger</a></li>
                  </ul>

                  <ul class="nav navbar-nav navbar-right" style="margin-right: 0.3vw;">
                      <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo ucfirst($_SESSION['username']); ?><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="update.php">Opdater oplysninger</a></li>
                          <li><a class="logud" href="kundeindex.php?logout='1'" style="width:100%;">Log ud</a></li>
                        </ul>
                      </li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                      <li> <a href="kundeindex.php">Tilbage til forside</a> </li>
                  </ul>
              </div>
          </nav>
      </header>
        <div class="container">
            <div class="row con">
                <h3>Dine bestillinger</h3></div>
            <div class="row resultat">
                    <?php
                    $bruger = $_SESSION['username'];
                    $query = "SELECT * FROM bookings A LEFT OUTER JOIN employee B ON A.employeeId = B.employeeId RIGHT OUTER JOIN company C ON A.companyId = C.companyId WHERE A.name = '$bruger' ORDER BY date ASC";

                  //vare fundet fundet
            		    $result = mysqli_query($db, $query);
                    if ($result->num_rows > 0) {

                       ?>
                       <form action="" method="post">
                         <div class="round">
                           <?php
                       while($row = $result->fetch_assoc()) {
                      echo "<table border=0>";
       ?>
            <div style="width:100%;" class="<?php echo ($row['date']<date('Y-m-d') ? "gammel" : "" ) ?>">
             <input type="radio" value="<?php echo $row['id']?>" name="appointmentId">
             <input size="7" type="text" name="date" readonly value="<?php echo $row['date'];?>">
             <?php echo ucfirst($row['timeslot'])?>
             <?php echo " hos "?>
             <?php echo ucfirst ($row["employeeName"]);?>
             <?php echo "("; echo ucfirst($row["companyName"]); echo ")";?>
             </div>
             </div>
             <?php
             echo "</table>";
   }
    ?><div class="wrapper" style="text-align:center;">
      <button type="submit" class="btn btn-danger" name="cancel">Aflys booking</button>
    </div>
       </form>
    <?php
}
else {
  ?>
  <div class="round">
  <?php
  echo "<table border=0>"; ?>
     <input style="margin-top:2vh; width:100%;" type="text" readonly value="Du har ingen reservationer">
     <?php
   echo "</table>";
   ?>
   </div>
   <?php
}

        ?>
                </div>
            </div>


    </body>

    </html>
