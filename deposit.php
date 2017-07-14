<?php
 
    require("../includes/config.php"); 
 
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("deposit_form.php", ["title" => "Buy"]);
    }
 
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
 
        query("UPDATE users SET cash = cash + ? WHERE id = ?", $_POST["deposit"], $_SESSION["id"]);
        
        redirect("/");
    }
 
?>
