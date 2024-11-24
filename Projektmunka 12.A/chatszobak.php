<?php
namespace Main;
use PDOException;
use PDO;
include "Developer_class.php";
include "Login_register_class.php";
session_name("user");
session_start();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <?php include "head.html"; ?>
    <title>Chatszobád</title>
</head>
<body>


   <?php
   try {
      $db = DeveloperDB::CallPDO();
      $stmt = $db->prepare('SELECT * FROM '.$_SESSION["user"].'___chats_page');
      $stmt->execute();
      $messages = $stmt->fetchAll(DeveloperDB::FETCH_ASSOC);


   } catch (PDOException $e)
    { 
      echo 'Kapcsolati Hiba: '.$e->getMessage();
    }
   
        if(!empty($_POST["message"])){
           $db = DeveloperDB::CallPDO();
           $message = Login_register::TestInput($_POST["message"]);
           $now = date("Y-m-d");
           $d = "message_date"; $t = "message_text";
           $sql_insert_text = 'INSERT INTO '.$_SESSION["user"].'___chats_page ('.$d.', '.$t.') VALUES (:'.$d.', :'.$t.')';
           $stmt = $db->prepare($sql_insert_text);
           $stmt->bindValue(":$d", $now, DeveloperDB::PARAM_STR);
           $stmt->bindValue(":$t", $message, DeveloperDB::PARAM_STR);
           $stmt->execute();
           $db = null;
        }
        else if(!empty($messages)){
         foreach ($messages as $message) {
            echo $message;
            echo "<br>";
         }
        }
        else {
         $message = "Nincsen üzenet! Írjál egyet!";
         echo $message;
        }
        

    
    
   ?>
   
   <form action="chatszobak.php" method="post">
      <input placeholder="Küldjél egy üzenetet" type="text" name="message">
      <button type="submit" name="sent_message">Küldés</button>
   </form>
</body>
</html>