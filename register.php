<?php
	require("../includes/config.php");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
   render("register_form.php", ["title" => "Register"]);
    }
  else if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["username"]))
        {
            apologize("You must provide a username.");
        }
        else if (empty($_POST["password"]))
        {
            apologize("You must provide a password.");
        }
        else if (empty($_POST["confirmation"]))
        {
            apologize("You must confirm your password.");
        }
        else if ($_POST["confirmation"] != $_POST["password"])
        {
        	apologize("Password and confirmation do not match");
        }
      $success = query("INSERT INTO users (username, hash, cash) VALUES(?, ?, 10000.00)", $_POST["username"], crypt($_POST["password"]));
        if ($success === false)
        {
        	apologize("Account creation failed");
        } 
        else {
        	$rows = query("SELECT LAST_INSERT_ID() AS id");
	    	$id = $rows[0]["id"];
	        $_SESSION["id"] = $id;
	        redirect("/"); 
        }   	
	}
?>
