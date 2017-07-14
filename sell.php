<?php
 
    require("../includes/config.php"); 
 
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("sell_form.php", ["title" => "Sell"]);
    }
 
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $rows = query("SELECT * FROM portfolio WHERE id = ? AND symbol = ?", $_SESSION["id"], $_POST["symbol"]);
 
        if (count($rows) == 0)
        {
            apologize("You do not currently own any shares of {$_POST["symbol"]}");
        }
 
        $row = $rows[0];
 
        if ($row["shares"] < $_POST["shares"])
        {
            apologize("You do not own {$_POST["shares"]} of {$_POST["symbol"]}. Please enter a lower quantity");
        }
 
        if ($row["shares"] == $_POST["shares"]) 
        {
            query("DELETE FROM portfolio WHERE id = ? AND symbol = ?", $_SESSION["id"], $_POST["symbol"]);
        }
        else
        {
            query("UPDATE portfolio SET shares = ? WHERE id = ? AND symbol = ?", $row["shares"] - $_POST["shares"], $_SESSION["id"], $_POST["symbol"]);
        }
 
        $stock = lookup($_POST["symbol"]);
 
        query("UPDATE users SET cash = cash + ? WHERE id = ?", $_POST["shares"]*$stock["price"], $_SESSION["id"]);
 
        query("INSERT INTO history (id, transaction, timestamp, symbol, shares, price) VALUES (?, ?, ?, ?, ?, ?)", $_SESSION["id"], "SELL", date('Y-m-d h:i:s'), strtoupper($_POST["symbol"]), $_POST["shares"], $stock["price"]);
 
        redirect("/");
 
    }
 
?>
