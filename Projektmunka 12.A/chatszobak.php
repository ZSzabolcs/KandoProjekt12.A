<?php
namespace Main;
use PDOException;
use PDO;
include "Developer_class.php";
include "Login_register_class.php";
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <?php include "head.html"; ?>
    <title>Chatszobád</title>
</head>
<body>
   <form action="chatszobak.php" method="post">
    <input placeholder="Küldjél egy üzenetet" type="text" name="message">
    <button type="submit" name="sent_message">Küldés</button>
   </form>

   <?php
   if(isset($_POST["sent_message"])) {

        if(!empty($_POST["message"])){
           $message = Login_register::TestInput($_POST["message"]);
        }

        
    }
   ?>
</body>
</html>