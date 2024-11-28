<?php
namespace Main;
include "Developer_class.php";
include "Login_register_class.php";
session_name("user");
session_start();
if ($_SESSION["user"] === null) Login_register::ToAnotherPage("login.php");
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <?php include "head.html"; ?>
    <title>Chatszobád</title>
</head>
<body>


   <?php
      $db = DeveloperDB::CallPDO();
      $stmt = $db->prepare('SELECT * FROM '.$_SESSION["user"].'___chats_page');
      $stmt->execute();
      $messages = $stmt->fetchAll(DeveloperDB::FETCH_ASSOC);
      if(!empty($messages)){
         foreach ($messages as $message) {
            echo $message["message_text"];
            echo "<br>";
         }
        }
        else {
         echo "Nincsen üzenet! Írjál egyet!";
         
        }
   
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           $db = DeveloperDB::CallPDO();
           $message = Login_register::TestInput($_POST["message"]);
           $now = date("Y-m-d H:i");
           $d = "message_date"; $t = "message_text";
           $sql_insert_text = 'INSERT INTO '.$_SESSION["user"].'___chats_page ('.$d.', '.$t.') VALUES (:'.$d.', :'.$t.')';
           $stmt = $db->prepare($sql_insert_text);
           $stmt->bindValue(":$d", $now, DeveloperDB::PARAM_STR);
           $stmt->bindValue(":$t", $message, DeveloperDB::PARAM_STR);
           $stmt->execute();
           $db = null;
        }
        

    
    
   ?>
   
   <form action="chatszobak.php" method="post">
      <input placeholder="Küldjél egy üzenetet" type="text" name="message">
      <button type="submit" name="sent_message">Küldés</button>
   </form>
</body>
</html>