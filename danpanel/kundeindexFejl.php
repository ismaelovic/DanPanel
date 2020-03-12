<?php
include('server.php');

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
        <title>DanPanel</title>

        <style>
            .round {
                border-bottom: solid gainsboro 1px;
            }

            .container {
                margin-top: 7vh;
                width: 70%;
                min-height: 80vh;
                position: relative;

            }

            .indhold {
                border-bottom: solid green 1px;
                padding-bottom: 1vh;
            }

            footer {
                margin-top: 5vh;
            }

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
                width: 80%;
								margin: auto;
                border: none;
                background-color: whitesmoke;
                text-align: center;
            }

            .round .tekst {
                width: 2.5vw;
                -moz-appearance: textfield;
                border: none;
                background-color: whitesmoke;
            }
						.salon{
							border: solid grey 0.5px;
							text-align: center;
							padding: 1vw;
						}
						.salons img{
							width: 6vw;
							height: 6vh;
						}
						.employee{
							border-bottom: solid black 0.5px;
							text-align: center;
							padding: 1vw;
						}
						.employee input{
							text-align: center;
							font-size: 1vw;
						}
        </style>
    </head>

    <body>
        <header>
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header"> <a class="navbar-brand" href="kundeindex.php">DanPanel</a> </div>
                    <ul class="nav navbar-nav">
                        <li><a href="calendar.php">Book</a></li>
                        <li><a href="kundetjek.php">Tjek bestilling</a></li>
                        <li><a href="update.php">Opdater oplysninger</a></li>
                        <li><a href="season.php">Sæson</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li> <a class="logud" href="kundeindex.php?logout='1'">Log ud</a> </li>
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
											<h3><img src="img/user.png"><strong><?php echo ucfirst($_SESSION['username']);?></strong></h3>
											<?php endif ?>
							</div>
					</div>


							<div class="row salons">
						<?php
						$query = "SELECT * FROM company ORDER BY companyId";
						$result = mysqli_query($db, $query);
						while($row = $result->fetch_assoc()) {
							$name = $row['companyName'];
						?>
						<div class="col-xs-4">

							 <div class="salon">
							<img src="<?php echo ($row['companyImage']=="" ? "https://www.designwizard.com/wp-content/uploads/2018/06/e65b5e20-6a22-11e8-b508-dd83a1659ed4.jpg" : $row['companyImage'] ) ; ?>"></img><br>
							<strong><input type="text" readonly value="<?php echo $name;?>"></strong>
							<p><i><?php echo $row['companyAdress']?></p>
							<p><?php echo $row['companyZip']?></i></p>
							<input type="hidden" value="<?php echo $row['companyId']?>">
							<input type="submit" class="pick" data-companyId="<?php echo $row['companyId']; ?>" value="Vælg">
						</div>

					</div>
						<?php
					}
					?>
				</div>
					<?php
					if (isset($_POST['pickShop'])) {
						$salonId = $_POST['id'];
            $salonName = $_POST['name'];
						?>
							<div class="row">
								<h3 class="text-center col-xs-12">Vælg din medarbejder hos <?php echo ucfirst($salonName)?></h3>
								<br><br><br>
            <?php

           $query = "SELECT * FROM employee WHERE companyId = '$salonId'";
					 $result = mysqli_query($db, $query);
            while($row = $result->fetch_assoc()) {
							?>
							<div class="col-xs-4">
							<form method="post" action="kundeindex.php">
						<div class="employee">
							<input type="hidden" name="salonId" value="<?php echo $salonId?>">
							<input type="hidden" name="salonName" value="<?php echo $salonName?>">
							<input type="hidden" name="employeeId" value="<?php echo $row["employeeId"]?>">
							<input class="text-center btn btn-primary" type="submit" name="pickEmployee" value="<?php echo ucfirst($row["employeeName"])?>">
						</div>
							</form>
							</div>
							<?php
							 }
           ?>
					 		</div>
				<?php
				}
				?>
        </div>
	<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center">Booking for <span id="chos"></span> </h4>

            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="">Timeslot</label>

                                <strong><input type="text" id="chosen" readonly class="form-control text-center"></strong>
                            </div>
                            <div class="form-group pull-right">
                                <button class="btn btn-primary" type="submit" name="book_appointment">Vælg medarbejder</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<script>
				$(".pick").click(function(){
					var chosen = $(this).attr('data-companyId');
					console.log("firma nr:", chosen);
					//$("#chosen").html(chosen);
			    //$("#chosen").val(chosen);
					$.post('ajax.php', { chosen: chosen}, function(employee){
						//$("#chosen").html(data);
				    //$("#chosen").val(data);
						//alert(employee);
						JSON.stringify(employee);
						console.log("Efter Hele: ", employee);

						for (i=0;i<employee.length;i++){
    				for(j in employee[i]){
        		if (employee[i].hasOwnProperty(j)){
            console.log(j + ' => ' + employee[i][j]);
        		}

    }
}

					});
					$("#myModal").modal("show");
				});


				</script>
    </body>

    </html>
