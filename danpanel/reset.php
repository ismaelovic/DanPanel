<?php include('server.php');

if (isset($_GET['userId']) && isset($_GET['userName']) && isset($_GET['token'])) {
  $userId = $_GET['userId'];
  $userName = $_GET['userName'];
  $userToken = $_GET['token'];
}
else if (!isset($_GET['userId']) || !isset($_GET['userName']) || !isset($_GET['token'])) {
    header('location: login.php');
}

include('head.php');

$errors = array();

if (isset($_POST['reset_user'])) {
  // Input fra forms
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  // Validering af input i felterne
  if (empty($password_1)) {
    array_push($errors, "Adgangskode mangler");
   }
    //koderne skal være ens
  if ($password_1 != $password_2) {
    array_push($errors, "De indtastede koder matcher ikke ");
    }

  // registrer bruger hvis der er ingen fejl
  if (count($errors) == 0) {
    $password = ($password_1);
        //tilføj til tabellen hvis der 0 fejl
    $query = "UPDATE login SET adgangskode='$password', token='0' WHERE brugerId='$userId' AND brugernavn='$userName' AND token='$userToken'";
    mysqli_query($db, $query);

    $query2 = "SELECT * FROM login WHERE brugernavn='$userName' AND brugerId='$userId'";
    $result = mysqli_query($db, $query2);
    if (mysqli_num_rows($result) == 1) {
    echo '<script>console.log("Bruger blev fundet!")</script>';
    while($row = $result->fetch_assoc()) {
            $to = $row['email'];
            $headers = "From: ziyani.ismael@live.dk" . "\r\n";
            $subject = "Adgangskode";
            $msg = "Hej $userName. Din adgangskode er nu ændret";
           }
            mail($to,$subject,$msg,$headers);
    }
    else {
      echo "<script>console.log('Fejl i query2' );</script>";
    }
}
}
      ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Glemt login</title>
        <style>
            body {
                overflow: hidden;
                background: linear-gradient( rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url(img/strawb.jpg);
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-position: center;
                padding: 0;
                font-family: 'Ubuntu', sans-serif;
            }

            .content-login {
                overflow: hidden;
            }
            .con {
                border: none;
                padding: 0.5vh;
            }

            .con h3 {
                margin-left: 3vw;
            }

            input {
                text-align: left;
            }

            .btn {
                position: absolute;
                right: 3vw;
            }
        </style>
    </head>

    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <ul class="nav navbar-nav navbar-right">
                    <li> <a class="logud" href="login.html">Tilbage til login</a> </li> -->
                </ul>
            </div>
        </nav>
        <div class="content-login">
            <div class="con row">
                <h3>Indtast ny adgangskode</h3> </div>
            <form method="post" action="">
                <?php include('errors.php'); ?>
                <div class="input-group-login">
                    <label>Navn</label>
                    <input type="hidden" name="userId" value="<?php echo $userId ?>">
                    <input class="form-control" type="text" name="userName" readonly value="<?php echo ucfirst($userName); ?>">
                   </div>
                  <div class="input-group">
                      <label>Ny adgangskode</label>
                      <input class="form-control" type="password" name="password_1"> </div>
                  <div class="input-group">
                      <label>Bekræft adgangskode</label>
                      <input class="form-control" type="password" name="password_2"> </div>
                    <div class="input-group-login">
                        <button type="submit" class="btn btn-success " name="reset_user">Bekræft</button>
                    </div>
            </form>
        </div>
    </body>

    <?php

     ?>

    </html>
