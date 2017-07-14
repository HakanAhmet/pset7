<?php
 
    require("../includes/config.php"); 
 
    $transactions = query("SELECT * FROM history WHERE id = ?", $_SESSION["id"]);
 
    render("history_info.php", ["transactions" => $transactions, "title" => "History"]);
 
?>
