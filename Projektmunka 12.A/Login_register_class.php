<?php namespace Main;

final class Login_register{

   public static function TestInput($data)
   {
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
   }


   public static function ToAnotherPageWithDB($database, $connection, $web_name)
   {
       $connection->close();
       session_start();
       header("Location: $web_name");
       $database->close();
       
   }

   public static function ToAnotherPage($web_name){
    header("Location: $web_name");
    exit();
   }
}
?>