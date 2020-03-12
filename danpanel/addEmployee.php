<?php include('server.php');
$firma = $_SESSION['user_shop'];
$firmaId = $_SESSION['companyId'];
include('head.php')
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Tilføj medarbejder</title>

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
                  <div class="navbar-header"> <a class="navbar-brand" href="adminindex.php">DanPanel</a> </div>
                  <ul class="nav navbar-nav">
                      <li><a href="tjek.php">Tjek bestillinger</a></li>
                      <li><a href="lager.php">Lager</a></li>
                      <li class="active"><a href="addEmployee.php">Tilføj medarbejder</a></li>
                      <li><a href="tjeklogin.php">Håndter brugere</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                      <li> <a class="logud" href="adminindex.php?logout='1'">Log ud</a> </li>
                  </ul>
              </div>
          </nav>
      </header>
        <div class="content">
            <div class="con row">
                <h3>Tilføj medarbejder</h3> </div>
            <form method="post" action="addEmployee.php">
                <?php include('errors.php'); ?>
                <?php echo isset($msg)?$msg:"";?>
                <div class="datoer">
                   <div class="input-group row">
                   <label>Navn</label>
                   <input type="hidden" name="id" value="<?php echo $employeeId; ?>">
                   <input type="text" name="name" value="<?php echo ucfirst($row['employeeName']) ?>"> </div>
                   <div class="input-group row">
                   <label>Telefon nummer</label>
                   <input type="text" name="number" value="<?php echo $row['number'] ?>"> </div>

                     <div class="input-group row">
                         <label for="mondayStart">Mandag</label>
                         <select name="mondayStart" class="text-center">
                               <option value="08:00">08:00</option>
                               <option value="09:00">09:00</option>
                               <option value="10:00">10:00</option>
                               <option value="11:00">11:00</option>
                               <option value="12:00">12:00</option>
                               <option value="Fri">Fri</option>
                           </select>
                           <select name="mondayEnd" class="text-center">
                               <option value="17:00">17:00</option>
                               <option value="18:00">18:00</option>
                               <option value="19:00">19:00</option>
                               <option value="20:00">20:00</option>
                               <option value="21:00">21:00</option>
                               <option value="Fri">Fri</option>
                             </select>
                     </div>
                     <div class="input-group row">
                         <label for="tuesdayStart">Tirsdag</label>
                         <select name="tuesdayStart" class="text-center">
                               <option value="08:00">08:00</option>
                               <option value="09:00">09:00</option>
                               <option value="10:00">10:00</option>
                               <option value="11:00">11:00</option>
                               <option value="12:00">12:00</option>
                               <option value="Fri">Fri</option>
                           </select>
                           <select name="tuesdayEnd" class="text-center">
                                 <option value="17:00">17:00</option>
                                 <option value="18:00">18:00</option>
                                 <option value="19:00">19:00</option>
                                 <option value="20:00">20:00</option>
                                 <option value="21:00">21:00</option>
                                 <option value="Fri">Fri</option>
                             </select>
                     </div>
                     <div class="input-group row">
                         <label for="wednesdayStart">Onsdag</label>
                         <select name="wednesdayStart" class="text-center">
                               <option value="08:00">08:00</option>
                               <option value="09:00">09:00</option>
                               <option value="10:00">10:00</option>
                               <option value="11:00">11:00</option>
                               <option value="12:00">12:00</option>
                               <option value="Fri">Fri</option>
                           </select>
                           <select name="wednesdayEnd" class="endDate text-center">
                                 <option value="17:00">17:00</option>
                                 <option value="18:00">18:00</option>
                                 <option value="19:00">19:00</option>
                                 <option value="20:00">20:00</option>
                                 <option value="21:00">21:00</option>
                                 <option value="Fri">Fri</option>
                             </select>
                     </div>
                     <div class="input-group row">
                         <label for="thursdayStart">Torsdag</label>
                         <select name="thursdayStart" class="startDate text-center">
                               <option value="08:00">08:00</option>
                               <option value="09:00">09:00</option>
                               <option value="10:00">10:00</option>
                               <option value="11:00">11:00</option>
                               <option value="12:00">12:00</option>
                               <option value="Fri">Fri</option>
                           </select>
                           <select name="thursdayEnd" class="endDate text-center">
                                 <option value="17:00">17:00</option>
                                 <option value="18:00">18:00</option>
                                 <option value="19:00">19:00</option>
                                 <option value="20:00">20:00</option>
                                 <option value="21:00">21:00</option>
                                 <option value="Fri">Fri</option>
                             </select>
                     </div>
                     <div class="input-group row">
                         <label for="fridayStart">Fredag</label>
                         <select name="fridayStart" class="startDate text-center">
                               <option value="08:00">08:00</option>
                               <option value="09:00">09:00</option>
                               <option value="10:00">10:00</option>
                               <option value="11:00">11:00</option>
                               <option value="12:00">12:00</option>
                               <option value="Fri">Fri</option>
                           </select>
                           <select name="fridayEnd" class="endDate text-center">
                                 <option value="17:00">17:00</option>
                                 <option value="18:00">18:00</option>
                                 <option value="19:00">19:00</option>
                                 <option value="20:00">20:00</option>
                                 <option value="21:00">21:00</option>
                                 <option value="Fri">Fri</option>
                             </select>
                     </div>
                     <div class="input-group row">
                         <label for="saturdayStart">Lørdag</label>
                         <select name="saturdayStart" class="startDate text-center">
                               <option value="08:00">08:00</option>
                               <option value="09:00">09:00</option>
                               <option value="10:00">10:00</option>
                               <option value="11:00">11:00</option>
                               <option value="12:00">12:00</option>
                               <option value="Fri">Fri</option>
                           </select>
                           <select name="saturdayEnd" class="endDate text-center">
                                 <option value="17:00">17:00</option>
                                 <option value="18:00">18:00</option>
                                 <option value="19:00">19:00</option>
                                 <option value="20:00">20:00</option>
                                 <option value="21:00">21:00</option>
                                 <option value="Fri">Fri</option>
                             </select>
                     </div>
                     <div class="input-group row">
                         <label for="sundayStart">Søndag</label>
                         <select name="sundayStart" class="startDate text-center">
                               <option value="08:00">08:00</option>
                               <option value="09:00">09:00</option>
                               <option value="10:00">10:00</option>
                               <option value="11:00">11:00</option>
                               <option value="12:00">12:00</option>
                               <option value="Fri">Fri</option>
                           </select>
                           <select name="sundayEnd" class="text-center">
                                 <option value="17:00">17:00</option>
                                 <option value="18:00">18:00</option>
                                 <option value="19:00">19:00</option>
                                 <option value="20:00">20:00</option>
                                 <option value="21:00">21:00</option>
                                 <option value="Fri">Fri</option>
                             </select>
                     </div>
                   </div>
                    <div class="input-group">
                        <button type="submit" class="btn-success" name="reg_employee">Opret</button>
                    </div>
            </form>
        </div>
    </body>

    </html>
