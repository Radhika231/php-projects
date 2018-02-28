<?php
//Note- white space before <?php can give header errors
	$link=mysqli_connect("shareddb-g.hosting.stackcp.net","secret-diary-32372cb0","1a1w41o88d","secret-diary-32372cb0"); //user name=database name on ecowebhosting      
      if(mysqli_connect_error())
      {
        die("Database Connection Error");
      }   
?>