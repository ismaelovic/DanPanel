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
$bruger = $_SESSION['username'];
$brugerId = $_SESSION['userId'];
include('head.php');

?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Opdater oplysninger</title>

        <style>
            input,
            select {
                text-align: left;
            }

        </style>
    </head>

    <body>
      <header>
          <nav class="navbar navbar-inverse">
              <div class="container-fluid">
                  <div class="navbar-header"> <a class="navbar-brand" href="kundeindex.php">DanPanel</a> </div>
                  <ul class="nav navbar-nav">
                      <li><a href="kundetjek.php">Tjek bestillinger</a></li>
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
        <div class="content">
          <?php
            $query = "SELECT * FROM login WHERE brugerId = '$brugerId'";
            $result = mysqli_query($db, $query);
             ?>

            <div class="con row">
                <h3>Opdatér oplysninger</h3> </div>
            <form method="post" action="update.php">
                <?php include('errors.php');
                echo isset($msg)?$msg:"";
                if (mysqli_num_rows($result) == 1) {
                while($row = $result->fetch_assoc()) {
                 ?>
                    <div class="input-group">
                    <label>Fornavn</label>
                    <input type="text" name="username" value="<?php  echo ucfirst($row['brugernavn']) ?>"> </div>
                    <div class="input-group">
                    <label>Efternavn</label>
                    <input type="text" name="lastname" value="<?php  echo ucfirst($row['efterNavn']) ?>"> </div>
                    <div class="input-group">
                    <label>E-mail</label>
                    <input type="email" name="email" value="<?php echo $row['email'] ?>" oninvalid="this.setCustomValidity('Indtast venligst en gyldig e-mail adresse')"
                    oninput="setCustomValidity('')"> </div>
                    <div class="input-group">
                    <label>Telefon nummer</label>
                    <input type="text" name="number" value="<?php echo $row['number'] ?>"> </div>
                    <div class="input-group">
                    <label>Adgangskode</label>
                    <input type="password" name="password_1" value="<?php echo $row['adgangskode'] ?>"> </div>
                    <div class="input-group">
                    <label>Bekræft adgangskode</label>
                    <input type="password" name="password_2" value="<?php echo $row['adgangskode'] ?>"> </div>
                    <div class="input-group">
                        <button type="submit" class="btn btn-success" name="update_user">Opdatér</button>
                    </div>
                    <?php }

                    }
                    else {
                      echo "<script type='text/javascript'>alert('Mere end 1 resultat!');</script>";
                    }?>
            </form>
        </div>
    </body>

    </html>
