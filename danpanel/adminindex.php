<?php
include('server.php');
session_start();

    if ($_SESSION['user_type'] != 'admin') {
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

	if (!isset($_SESSION['user_shop'])) {
    session_destroy();
		unset($_SESSION['user_type']);
		header("location: login.php");
	}
		$firma = $_SESSION['user_shop'];
		$firmaId = $_SESSION['companyId'];
		//echo "<script type='text/javascript'>alert('$firma med id: $firmaId')</script>";
include('head.php');
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>DanPanel Admin</title>
        <style>
            body {
                background-color: #f1f1f1;
            }

            .container {
                margin-top: 7vh;
            }

            .status {

                text-align: center;
                font-size: 5vh;
            }

            footer {
                margin-top: 10vh;
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
                        <li><a href="tjeklogin.php">Håndter medarbejdere</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li> <a class="logud" href="adminindex.php?logout='1'">Log ud</a> </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="container">
            <div class="con row">
                <h3><strong>Velkommen tilbage</strong></h3> </div>
            <div class="wrapper row">
                <div class="col-xs-12 index">
                    <?php  if (isset($_SESSION['username'])&&($_SESSION['user_type'])) : ?>
                        <h3> <br><img src="img/user.png"><strong><?php echo ucfirst($firma);?></strong></h3>
                        <?php endif ?>
                </div>
            </div>
            <div class="wrapper row">
                <div class="col-xs-12 col-md-4 status">
                    <div class="titel">
                        <h3>Status</h3></div>
                    <?php


                 $query = "SELECT count(id) AS total FROM bookings WHERE companyId = $firmaId AND date >= DATE(NOW())";


      //vare fundet fundet
		$result = mysqli_query($db, $query);
        $values = mysqli_fetch_assoc($result);
        $num_rows = $values['total'];

    // output data of each row
           ?>
                        <div class="tekst">
                            <h4> <strong><?php echo $num_rows; echo ($num_rows==1 ? " bestilling" : " bestillinger" ) ?></strong></h4></div>



                        <?php


                 $query2 = "SELECT count(DISTINCT(name)) AS total2 FROM bookings WHERE companyId = $firmaId AND date >= DATE(NOW())";


      //vare fundet fundet
		$result2 = mysqli_query($db, $query2);
        $values2 = mysqli_fetch_assoc($result2);
        $num_orders = $values2['total2'];

    // output data of each row
           ?>
                            <div class="tekst">

                                <h4>Fra <strong><?php echo $num_orders; echo ($num_orders==1 ? " kunde" : " kunder" ) ?></strong></h4></div>


                </div>
                <div class="col-xs-12 col-md-8 indhold">
                    <?php


                 $query = "SELECT * FROM bookings A left outer join Services B on A.serviceId = B.serviceID WHERE A.companyId = $firmaId AND date >= DATE(NOW()) ORDER BY date ASC LIMIT 3";


      //vare fundet fundet
		$result = mysqli_query($db, $query);

      if ($result->num_rows > 0) {
    // output data of each row
           ?>
                        <div class="titel">
                            <h3>Seneste bestillinger:</h3></div>
                        <?php


    while($row = $result->fetch_assoc()) {
        echo "<table border = 0>";


        ?>
        <div class="round" style="font-size:1.4vh;"> <strong><?php echo $row["tid"]?></strong>

                    <?php echo ucfirst($row["name"]) ?>
										  <?php echo ucfirst($row["date"])?>
                        <?php echo " (" ?>
                            <strong><?php echo $row["timeslot"]?></strong>
                                    <?php echo " ) - " ?>
                                    <?php echo ucfirst($row["serviceName"])?>
        </div>
        <?php

        echo "</table>";

    }

}
else {
  ?>
  <div class="round">
    <h3>  <?php echo "Ingen reservationer"; ?></h3>
  </div>
  <?php

}

        ?>
                </div>
            </div>
        </div>
        <footer class="footer row">

        </footer>
    </body>

    </html>
