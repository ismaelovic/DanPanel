<?php
include("server.php");

    $choice = mysql_real_escape_string($_GET['choice']);

    $query = "SELECT servicePrice FROM Services WHERE serviceName ='$choice'";


    $result = mysql_query($query);

    while ($row = mysql_fetch_array($result)) {
        echo "<option>" . $row{'serviceName'} . "</option>";
        //echo "<option>" . $query . "</option>";

    }
?>
