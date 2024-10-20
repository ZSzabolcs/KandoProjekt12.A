<?php 
namespace Main;
use PDO;
use PDOException;
include "Login_register_class.php";
session_name('user');
session_start();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="cucc.css">
    <title>Bejelentkezés</title>
</head>
<body>
    <header>
        <h1 class="text-center text-container">
            Magyar földeken
        </h1>
    </header>
    <nav class="navbar navbar-expand-lg navbarcucc">

        <div class="container-fluid justify-content-center">
          <!-- Links -->
          <ul class="navbar-nav">
            <li class="nav-item navpad">
              <a class="nav-link" href="#">Kezdőlap</a>
            </li>
            <li class="nav-item navpad">
              <a class="nav-link" href="#">Felhasználói fiók</a>
            </li>
            <li class="nav-item navpad">
              <a class="nav-link" href="#">Közösségi tér</a>
            </li>
            <li class="nav-item navpad">
                <a class="nav-link" href="#">Üzenetek</a>
              </li>
              <li class="nav-item navpad">
                <a class="nav-link" href="#">Események</a>
              </li>
              <li class="nav-item navpad">
                <a class="nav-link" href="#">Cikkek</a>
              </li>
          </ul>
        </div>
      
      </nav>
    <div class="container flex-grow-1 min-vh-63 py-3">
        <h1 class="text-center">Bejelentkezés</h1>
        <div class="form">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                
                <label for="email1">Email cím:</label>
                <input type="email" id="email1" name="email" required><br>
                <label for="username1" class="my-2">Felhasználónév:</label>
                <input type="text" id="username1" name="username" required><br>
                <label for="password1">Jelszó:</label>
                <input type="password" id="password1" name="password" required><br>
                <button type="submit" name="action" value="login" onclick="Login()" class="submit my-4">Bejelentkezés</button>
            </form>
            
          <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      try {
          $db = new PDO('sqlite:Blogger.db');
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $username = Login_register::TestInput($_POST['username']);
          $email = Login_register::TestInput($_POST['email']);
          $password = Login_register::TestInput($_POST['password']);
          $u = 'username'; $e = 'email'; $p = 'password';

          $sql_finding = "SELECT password FROM user WHERE $u = :$u AND $e = :$e";
          $stmt = $db->prepare($sql_finding);
          $stmt->bindValue(":$u", $username, PDO::PARAM_STR);
          $stmt->bindValue(":$e", $email, PDO::PARAM_STR);
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          if ($row) {
              $hashed_password = $row[$p];

              if (password_verify($password, $hashed_password)) {
                  echo "Bejelentkezés sikeres!";
                  $_SESSION['user'] = $username;
                  Login_register::ToAnotherPage('cucc.php');
            } else {
                echo "A jelszó helytelen!";
              }
          } else {
              echo "Nincs ilyen felhasználó!";
          }
      
      } catch(PDOException $e){
          echo 'Hiba történt '.$ $e->getMessage();
      }
      $db = null;
    }
        ?>
          <a href="<?php echo htmlspecialchars('register.php'); ?>">Még nincs fiókod? </a>
        </div>
    </div>
    <footer class="container py-3 footer">
        Footer, lábjegyzet, jogi izék, bla bla bla
    </footer>
    <script src="methods.js"></script>
</body>
</html>
