<?php include('server.php');
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
  $bruger = $_SESSION['username'];
  $firma = $_SESSION['user_shop'];
  $firmaId = $_SESSION['companyId'];

  include('head.php');
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title><?php echo $firma ?> Admin </title>

        <style>
            .container {
                margin-top: 10vh;
                overflow-y: scroll;
            }

            footer {
                margin-top: 12vh;
            }

            .wrapper {
                align-content: center;
                margin-top: 2vh;
            }

            .wrapper input,
            .wrapper select {
                margin-right: 0.2vw;
                margin-left: 0.2vw;
                height: 3vh;
                text-align: center;
                border-radius: 5px;
                border: gainsboro solid 1px;
                box-shadow: none;
            }

            .wrapper input[type=number] {
                -moz-appearance: textfield;
                margin-left: 0.5vw;
            }

            .wrapper input[type=text] {
                width: 6vw;
            }

            .add {
                display: flex;
                justify-content: center;
            }
            .tjek {
                overflow: hidden;
            }
            .tjek input[type=text] {
                text-align: center;
                border-radius: 5px;
                border: gainsboro solid 1px;
                box-shadow: none;
            }

            .titel h3 {
                font-size: 2.5vh;
            }

            radio {
                border: solid red 3px;
                color: aqua;
            }

           input[type=number] {
                -moz-appearance: textfield;
                width: 4vw;
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
                        <li class="active"><a href="lager.php">Services</a></li>
                        <li><a href="addEmployee.php">Tilføj bruger</a></li>
                        <li><a href="tjeklogin.php">Håndter brugere</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li> <a class="logud" href="adminindex.php?logout='1'">Log ud</a> </li>
                    </ul>
                </div>
            </nav>
        </header>

        <div class="container">

            <div class="row con">
                <h3><?php echo $firma;?> services</h3> </div>
            <div class="row wrapper">
                <div class="col-xs-12 add">
                    <h3>Tilføj services</h3></div>
                <div class="col-md-12 add">

                    <form method="post" action="lager.php">
                        <?php include('errors.php'); ?>
                            <input type="text" name="name" placeholder="navn">
                            <input size="50" type="text" name="description" placeholder="beskrivelse">
                            <input size="10" type="text" name="duration" placeholder="varighed">
                            <input size="10" type="text" name="cleanup" placeholder="pause">
                            <input size="10" type="text" name="price" placeholder="pris">
                            <button type="submit" class="btn btn-success" name="add_btn">Tilføj</button>
                    </form>
                </div>
            </div>
            <div class="row tjek">

                <div class="tabel col-xs-12 col-md-12">
                            <form action="lager.php" method="post">
                                <?php
                 $query = "SELECT * FROM Services WHERE companyId = '$firmaId' ORDER BY serviceName ASC";

      //vare fundet fundet
		$result = mysqli_query($db, $query);

      if ($result->num_rows > 0) {
     ?>
                                    <div class="titel row">
                                        <h3>Sortiment:</h3>
                                        <br> </div>
                                    <?php

    while($row = $result->fetch_assoc()) {
          echo "<table border=0>";
        ?>
        <input type="radio" name="productid" value="<?php echo $row['serviceID']; ?>">
        <input size="6" type="text" name="productName" readonly value="<?php echo ucfirst($row['serviceName'])?>">
        <input size="35" type="text" readonly value="<?php echo ucfirst($row['serviceDescription'])?>">
        <input size="10" type="text" readonly value="<?php echo $row['serviceDuration']; echo " min"?>">
        <input size="10" type="text" readonly value="<?php echo $row['servicePrice']; echo " kr";?>">
    <?php
        echo "</table>";
    }
}?>
        <br>
        <input type="submit" class="btn btn-danger" name="slet_service" value="Slet">


        </form>
                </div>
            </div>
        </div>
        <footer>

        </footer>
    </body>

    </html>
