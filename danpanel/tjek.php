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
  $firma = $_SESSION['user_shop'];
  $firmaId = $_SESSION['companyId'];
  include('head.php');
  //echo "<script type='text/javascript'>alert('$firma med id: $firmaId')</script>";
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title> <?php echo $firma; ?> Admin </title>

        <style>
            .container {
                margin-top: 7vh;
                font-family: 'Ubuntu', sans-serif;
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
                        <li class="active"><a href="tjek.php">Tjek bestillinger</a></li>
                        <li><a href="lager.php">Services</a></li>
                        <li><a href="addEmployee.php">Tilføj medarbejder</a></li>
                        <li><a href="tjeklogin.php">Håndter brugere</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li> <a class="logud" href="adminindex.php?logout='1'">Log ud</a> </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="container">
            <div class="row con mb20">
                <h3>Tjek bestillinger</h3></div>
            <div class="row mb20">
                <form class="admin_tjek_box col-md-4 col-xs-12" action="tjek.php" method="post">
                    <br>
                    <label for="dt">Fra</label>
                    <br>
                    <input name="dt" type="date" placeholder="åååå-mm-dd" />
                    <br>
                    <br>
                    <label for="navn">Indtast kundens navn: </label>
                    <br>
                    <input type="text" name="navn">
                    <br>
                    <br>
                    <input type="submit" class="btn-success" name="check_btn" value="Vis!">
                    <br>
                    <br> </form>
                <div class="tabel col-md-8 col-xs-12">
                    <?php


        if (isset($_POST['check_btn'])) {
             ?>
    <form class="sletknap" action="tjek.php" method="post">
                      <?php
     $name = $_POST['navn'];
     $date = $_POST['dt'];
     if ((!empty($_POST['dt']) && !empty($_POST['navn']))) {

       $query = "SELECT * FROM bookings A inner join employee B on A.employeeId=B.employeeId WHERE A.name='$name' AND A.date='$date' AND B.companyId ='$firmaId'";

      //fundet
		$result = mysqli_query($db, $query);

      if ($result->num_rows > 0) {
    // output data of each row
          echo "<strong>$name</strong> har følgende reservationer: <br />";
          ?>
                                <br>
                                <?php
    while($row = $result->fetch_assoc()) {
        echo "<table table class=table-striped table-hover table-bordered>";
       $orderid = $row["id"];
        ?>
            <div class="<?php echo ($row['date']<date('Y-m-d') ? "gammel" : "" ) ?>">
            <input type="radio" name="vareid" value="<?php echo $orderid ?>"><?php echo $row["id"]?>
            <?php echo " - "?>
            <strong><?php echo ucfirst($row["name"]) ?></strong>
            <?php echo $row["date"]; echo " ("; echo $row["timeslot"]; echo ")" ?>
            <?php echo " hos "; echo ucfirst($row["employeeName"])?>
          </div>
            <?php

        echo "</table>";
    }

}
else {
     echo "<table class=table-striped table-hover table-bordered>";
          echo "Ingen bestillinger3";
          echo "</table>";
}
  }
            if ((empty($_POST['dt']) && empty($_POST['navn']))) {

                 $query = "SELECT * FROM bookings A inner join employee B on A.employeeId=B.employeeId WHERE B.companyId ='$firmaId' ORDER BY A.date DESC";

      //vare fundet fundet
		$result = mysqli_query($db, $query);

      if ($result->num_rows > 0) {
    // output data of each row
          echo "Der er bestilt følgende: <br />";
          //echo " " . $row["bruger"];
    while($row = $result->fetch_assoc()) {
        echo "<table class=table-striped table-hover table-bordered>";
       $orderid = $row["id"];
        ?>
        <div class="<?php echo ($row['date']<date('Y-m-d') ? "gammel" : "" ) ?>">
        <input type="radio" name="vareid" value="<?php echo $orderid ?>"><?php echo $row["id"]?>
        <?php echo " - "?>
        <strong><?php echo ucfirst($row["name"]) ?></strong>
        <?php echo $row["date"]; echo " ("; echo $row["timeslot"]; echo ")" ?>
        <?php echo " hos "; echo ucfirst($row["employeeName"])?>
      </div>
        <?php

        echo "</table>";
    }
}else {
     echo "<table class=table-striped table-hover table-bordered>";
          echo "Ingen bestillinger fundet";
          echo "</table>";
}
  return;
}
             if (empty($_POST['dt'])) {

              $query = "SELECT * FROM bookings A inner join employee B on A.employeeId=B.employeeId WHERE A.name='$name' AND B.companyId ='$firmaId' ORDER BY A.date DESC";

      //vare fundet fundet
		$result = mysqli_query($db, $query);

      if ($result->num_rows > 0) {
    // output data of each row
          echo "<strong>$name</strong> har følgende reservationer: <br />";
          ?>
                                                                                                                    <br>
                                                                                                                    <?php
          //echo " " . $row["bruger"];
  while($row = $result->fetch_assoc()) {
        echo "<table class=table-striped table-hover table-bordered>";
       $orderid = $row["id"];
        ?>
        <div class="<?php echo ($row['date']<date('Y-m-d') ? "gammel" : "" ) ?>">
        <input type="radio" name="vareid" value="<?php echo $orderid ?>"><?php echo $row["id"]?>
        <?php echo " - "?>
        <strong><?php echo ucfirst($row["name"]) ?></strong>
        <?php echo $row["date"]; echo " ("; echo $row["timeslot"]; echo ")" ?>
        <?php echo " hos "; echo ucfirst($row["employeeName"])?>
      </div>
        <?php
        echo "</table>";
    }
}
else {
     echo "<table class=table-striped table-hover table-bordered>";
          echo "Ingen bestillinger for $name";
          echo "</table>";
}

            }
            if(empty($_POST['navn'])){

                $query = "SELECT * FROM bookings A inner join employee B on A.employeeId=B.employeeId WHERE A.date='$date' AND B.companyId ='$firmaId' ORDER BY A.name DESC";

      //vare fundet fundet
		$result = mysqli_query($db, $query);

      if ($result->num_rows > 0) {
    // output data of each row
          echo "For <strong>$date</strong> er der booket følgende:";
?>
                                                                                                                                                    <br>
                                                                                                                                                    <br>
                                                                                                                                                    <?php
     while($row = $result->fetch_assoc()) {
        echo "<table class=table-striped table-hover table-bordered>";
       $orderid = $row["id"];
        ?>
        <div class="<?php echo ($row['date']<date('Y-m-d') ? "gammel" : "" ) ?>">
        <input type="radio" name="vareid" value="<?php echo $orderid ?>"><?php echo $row["id"]?>
        <?php echo " - "?>
        <strong><?php echo ucfirst($row["name"]) ?></strong>
        <?php echo $row["date"]; echo " ("; echo $row["timeslot"]; echo ")" ?>
        <?php echo " hos "; echo ucfirst($row["employeeName"])?>
      </div>
        <?php
        echo "</table>";
    }
}else {
     echo "<table class=table-striped table-hover table-bordered>";
          echo "Ingen bestillinger for $date";
          echo "</table>";
}
            }
                ?>
<br>
<input type="submit" class="btn-danger" name="slet_btn" value="Slet">
</form>
<?php
            }
        ?>
                </div>
            </div>
        </div>
        <footer>


            <?php
             //$query = "DELETE FROM bestillinger WHERE tid < timestampadd(day, -70, now())";
               //vare fundet fundet
		//$result = mysqli_query($db, $query);
          //          ?>
        </footer>
    </body>

    </html>
