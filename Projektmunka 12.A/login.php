<?php
namespace Main;
include "Login_register_class.php";
include "Developer_class.php";
session_name("user");
session_start();
?>
<!DOCTYPE html>
<html lang="hu">

<head>
  <?php include "head.html"; ?>
  <title>Bejelentkezés</title>
</head>

<body>
  <header>
    <h1 class="text-center text-container">
      Magyar földeken
    </h1>
  </header>
  <nav class="navbar navbar-expand-lg navbarcucc" >
  </nav>
  <div class="container flex-grow-1 min-vh-63 py-3">
    <h1 class="text-center">Bejelentkezés</h1>
    <div class="form">
      <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

        <label for="email1">Email cím:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="username1" class="my-2">Felhasználónév:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password1">Jelszó:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit" onclick="Login()" class="submit my-4">Bejelentkezés</button>
      </form>

      <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $db = DeveloperDB::CallPDO();
          $username = Login_register::TestInput($_POST['username']);
          $email = Login_register::TestInput($_POST['email']);
          $password = Login_register::TestInput($_POST['password']);
          $u = 'username'; $e = 'email'; $p = 'password';

          $sql_finding = "SELECT password FROM user WHERE $u = :$u AND $e = :$e";
          $stmt = $db->prepare($sql_finding);
          $stmt->bindValue(":$u", $username, DeveloperDB::PARAM_STR);
          $stmt->bindValue(":$e", $email, DeveloperDB::PARAM_STR);
          $stmt->execute();

          $row = $stmt->fetch(DeveloperDB::FETCH_ASSOC);
          if ($row) {
            $hashed_password = $row[$p];

            if (password_verify($password, $hashed_password)) {
              $_SESSION['user'] = $username;
              Login_register::ToAnotherPage('cucc.php');
            } else {
              echo "A jelszó, vagy más adat helytelen!";
            }
          } else {
            echo "Nincs ilyen felhasználó!";
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
  <script>
const Login = () => {
    const username_login = document.querySelector("#username");
    const email_login = document.querySelector("#email");
    const password_login = document.querySelector("#password");
    if (username_login.value.trim() === "" || email_login.value.trim() === "" || password_login.value.trim() === ""){
        console.error("Add meg a szükséges adatokat!");
    }
    else sessionStorage.setItem("user", username_login.value.trim());
}
  </script>
</body>
</html>
