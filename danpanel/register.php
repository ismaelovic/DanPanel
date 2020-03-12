<?php include('server.php');

include('head.php');

?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>DanPanel</title>

        <style>
            .btn-success {
                margin-top: 4vh;
                margin-bottom: 3vh;
                font-family: 'Ubuntu', sans-serif;
                border-radius: 10px;
            }

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
                    <div class="navbar-header"> <a class="navbar-brand" href="login.php">DanPanel</a> </div>
                    <ul class="nav navbar-nav navbar-right">
                        <li> <a class="logud" href="login.php">Tilbage til forside</a> </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="content-login">
            <div class="con row">
                <h3>Opret bruger</h3> </div>
            <form method="post" action="register.php">
                <?php include('errors.php'); ?>
                <?php echo isset($msg)?$msg:"";?>
                    <div class="input-group-login">
                  <label>Fornavn</label>
                  <input type="text" name="username"> </div>
                  <div class="input-group-login">
                      <label>Efternavn</label>
                      <input type="text" name="lastname"> </div>
                    <div class="input-group-login">
                    <label>E-mail</label>
                      <input type="email" name="email" placeholder="Indtast venligst en gyldig adresse"> </div>
                      <div class="input-group-login">
                          <label>Telefon nummer</label>
                          <input type="text" name="number"> </div>
                      <div class="input-group-login">
                          <label>Adgangskode</label>
                          <input type="password" name="password_1"> </div>
                      <div class="input-group-login">
                          <label>Bekræft adgangskode</label>
                          <input type="password" name="password_2"> </div>
                      <div class="input-group-login">
                          <button type="submit" class="btn btn-success" name="reg_user">Opret </button>
                      </div>
                    </div>

            </form>
        </div>
    </body>

    </html>
