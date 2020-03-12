<?php include('server.php');
include('head.php');

      ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Glemt login</title>
        <style>

            .con {
                border: none;
                padding: 0.5vh;
            }
            .content-login{
              height: 40%;
              overflow: hidden;
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
                    <li> <a class=" logud" href="login.php">Tilbage til login</a> </li>
                </ul>
            </div>
        </nav>
        <div class="content-login">
            <div class="con row">
                <h3>Indtast din E-mail</h3> </div>
            <form method="post" action="forgot.php">
                <?php include('errors.php'); ?>
                  <?php echo isset($msg)?$msg:"";?>
                    <div class="input-group-login">
                        <label>E-mail</label>
                        <input type="text" name="email"> </div>
                    <div class="input-group-login">
                        <button type="submit" class="btn btn-success " name="forgot_user">Bekræft</button>
                    </div>
            </form>
        </div>
    </body>

    </html>
