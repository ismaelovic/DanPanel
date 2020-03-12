<?php include('server.php');
include('head.php');

      ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>DanPanel Login</title>
        <style>
            body {
                overflow: hidden;
                background: linear-gradient( rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url(img/barbershop.jpg);
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-position: center;
                padding: 0;
                font-family: 'Ubuntu', sans-serif;
            }

            .con {
                border: none;
                padding: 0.5vh;
            }

            .con h3 {
                margin-left: 3vw;
                font-size: 2.5vh;
            }

            input {
                text-align: left;
            }

            .btn {
                position: absolute;
                right: 3vw;
            }
            .content-login{
              height: 60%;
              overflow: hidden;
            }
        </style>
    </head>

    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <ul class="nav navbar-nav navbar-right">
                    <!-- <li> <a class=" logud" href="index.html">Tilbage til forside</a> </li> -->
                </ul>
            </div>
        </nav>
        <div class="content-login">
            <div class="con row">
                <h3>Log ind for at forsætte</h3> </div>
            <form method="post" action="login.php">
                <?php include('errors.php'); ?>
                    <div class="input-group-login">
                        <label>E-mail</label>
                        <input type="text" name="email"> </div>
                    <div class="input-group-login">
                        <label>Adgangskode</label>
                        <input type="password" name="password"> </div>
                    <div class="input-group-login">
                        <button type="submit" class="btn btn-success " name="login_user">Log ind</button>
                    </div>
                    <div style="position: absolute; bottom: 5vh; font-size:2vh;" class="input-group-login">
                        Har du endnu ikke en konto? Opret dig <a href="register.php">her</a>
                      </div><br>
                    <div style="position: absolute; bottom: 1vh; font-size:2vh;" class="input-group-login">
                          Glemt kode? <a href="forgot.php">Klik her</a>
                      </div>
            </form>
        </div>
    </body>

    </html>
