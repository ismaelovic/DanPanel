<?php
include('server.php');

	if ($_SESSION['user_type'] != 'kunde') {
    session_destroy();
		header("location: login.php");
     }

	if (!isset($_SESSION['username'])) {
		header('location: login.php');
		echo "<script type='text/javascript'>alert('Du er ikke logget ind korret!');</script>";
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
        <title>DanPanel</title>

        <style>

            input {
                margin-right: 0.1vw;
                margin-left: 0.1vw;
            }

            input[type=number] {
                width: 4vw;
                -moz-appearance: textfield;
                margin-left: 0.5vw;
            }

            input[type=text] {
                width: 6vw;
                border: none;
                background-color: whitesmoke;
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
                        <li><a href="kundetjek.php">Tjek bestillinger</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right" style="margin-right: 1vw;">
												<li class="dropdown">
									        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo ucfirst($_SESSION['username']); ?><span class="caret"></span></a>
									        <ul class="dropdown-menu">
									          <li><a href="update.php">Opdater oplysninger</a></li>
														<li><a class="logud" href="kundeindex.php?logout='1'" style="width:100%;">Log ud</a></li>
									        </ul>
									      </li>

                    </ul>
                </div>
            </nav>
        </header>
        <div class="container">
					<div class="con row">
							<h3><strong>Velkommen tilbage</strong></h3> </div>

					<div class="controls">
							<button type="button" class="knap" data-filter="all">Alle</button>
							<button type="button" class="knap salon" data-toggler=".salon">Frisør</button>
							<button type="button" class="knap massage" data-toggler=".massage">Massage</button>
							<button type="button" class="knap skin" data-toggler=".skin">Skin</button>
					</div>

							<div class="row salons">
						<?php
						$query = "SELECT * FROM company ORDER BY companyId";
						$result = mysqli_query($db, $query);
						while($row = $result->fetch_assoc()) {
						?>
						<div class="mix col-xs-4 <?php echo $row['companyCategory']; ?>">
							<form method="post" action="">
							 <div class="salon">
							<img src="<?php echo ($row['companyImage']=="" ? "https://danpanel.dk/assets/site/assets/images/icons/One-stop-shop-ikon.png" : $row['companyImage'] ) ; ?>"></img><br>
							<strong><input type="text" style="width:10vw;" name="salonName" readonly value="<?php echo $row['companyName'];?>"></strong>
							<p><i><?php echo $row['companyAdress']?></p>
							<p><?php echo $row['companyZip']?></i></p>
							<input type="hidden" name="salonId" value="<?php echo $row['companyId']?>">
							<input type="submit" name="pickShop" class="btn btn-success" style="font-size:1.5vh;" value="Vælg">
						</div>
					</form>
					</div>
						<?php
					}
					?>
				</div>

        </div>

				<script src="css/mixitup.min.js"></script>
		    <script>
		        var containerEl = document.querySelector('.container');
		        var mixer = mixitup(containerEl);
		    </script>
    </body>

    </html>
