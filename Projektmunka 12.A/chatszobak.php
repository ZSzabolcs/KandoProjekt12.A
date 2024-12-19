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
<nav class="navbar navbar-expand-lg navbarcucc">
        <div class="container-fluid justify-content-center">
            <ul class="navbar-nav">
                <li class="nav-item navpad">
                    <a class="nav-link" href="<?php echo htmlspecialchars("cucc.php"); ?>">Kezdőlap</a>
                </li>
                <li class="nav-item navpad">
                    <a class="nav-link" href="<?php echo htmlspecialchars("blogok.php"); ?>">Blogok</a>
                </li>
                <li class="nav-item navpad">
                    <a class="nav-link" href="<?php echo htmlspecialchars("blogger_create.php"); ?>">Blog készítő felület</a>
                </li>
            </ul>
        </div>
    </nav>
   <h1><?php echo$_SESSION["user"] ?></h1>

   <?php
      $db = DeveloperDB::CallPDO();
      $stmt = $db->prepare('SELECT * FROM '.$_SESSION["user"].'__chats_page');
      $stmt->execute();
      $messages = $stmt->fetchAll(DeveloperDB::FETCH_ASSOC);
      if(!empty($messages)){
         foreach ($messages as $message) {
            if ($message["from_who"] === $_SESSION["user"]) {
               echo '<span style="float: right;">'.$message["from_who"].'</span><br><div class="my-message">'.$message['message_text'].'</div>';
               echo "<br><br>";
            }
            else{
               echo '<p>'.$message["from_who"].'</p><br><div class="others-message">'.$message["message_text"].'</div>';
               echo "<br><br>";
               
            }
            
         }
         
        }
        else {
         echo "Nincsen üzenet! Írjál egyet!";
        }
        $db = null;
   
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           $db = DeveloperDB::CallPDO();
           $message = Login_register::TestInput($_POST["message"]);
           if (!empty($message)) {
           $now = date("Y-m-d H:i");
           $d = "message_date"; $f = "from_who"; $t = "message_text";
           $sql_insert_text = 'INSERT INTO '.$_SESSION["user"].'__chats_page ('.$d.', '.$f.', '.$t.') VALUES (:'.$d.', :'.$f.', :'.$t.')';
           $stmt = $db->prepare($sql_insert_text);
           $stmt->bindValue(":$d", $now, DeveloperDB::PARAM_STR);
           $stmt->bindValue(":$f", $_SESSION["user"], DeveloperDB::PARAM_STR);
           $stmt->bindValue(":$t", $message, DeveloperDB::PARAM_STR);
           $stmt->execute();
           echo '<meta http-equiv="refresh" content="0.5">';
         }
           
        }
        $db = null;

    
    
   ?>
   
   <form action="chatszobak.php" method="post">
      <input style="width: 500px; margin-left:650px; margin-top: 10px;" placeholder="Küldjél egy üzenetet" type="text" name="message">
      <button type="submit" name="sent_message">Küldés</button>
   </form>
</body>
</html>