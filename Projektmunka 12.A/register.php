<?php
namespace Main;
use mysqli;
include "Developer_class.php";
include "Login_register_class.php";
$developer = new Developer();
const reg = false;
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="cucc.css">
    <title>Regisztráció</title>
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
        <h1 class="text-center">Regisztráció</h1>
        <div class="form">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                
                <label for="email">Email cím:</label>
                <input type="email" id="email" name="email" required><br>
                <label for="username" class="my-2">Felhasználónév:</label>
                <input type="text" id="username" name="username" required><br>
                <label for="password">Jelszó:</label>
                <input type="password" id="password" name="password" required><br>
                <button type="submit" name="action" value="register" class="submit my-4">Regisztráció</button>
            </form>
        </div>
    </div>
    <footer class="container py-3 footer">
        Footer, lábjegyzet, jogi izék, bla bla bla
    </footer>
</body>
</html>


<?php




// Akkor indul el ha megnyomjuk a 'submit' gombot!
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Kapcsolódás az adatbázishoz
    $conn = new mysqli($developer->GetServerName(), $developer->GetDbUsername(), $developer->GetDbPassword(), $developer->GetDbName());

    // Kapcsolódási hiba ellenőrzése
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Posztolás következik!
    if ($_POST['action'] === 'register') {
        // Amikor beregisztrál!
        $username = Login_Register::TestInput($_POST['username']);
        $email = Login_Register::TestInput($_POST['email']);
        $password = Login_Register::TestInput($_POST['password']);
        $password = password_hash($password, PASSWORD_DEFAULT);

        //Felhasználó ellenőrzése
        $sql_check_username = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql_check_username);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();


        if ($stmt->num_rows > 0) {
            // Ha a felhasználónév már létezik, hibaüzenetet jelenítünk meg
            echo "The username is already taken. Please choose another one.";
            $stmt->close();
            $conn->close();
        } else {
            // Ha a felhasználónév nem létezik, folytatjuk a regisztrációt
            $sql_insert = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bind_param("sss", $username, $email, $password);
        }


        if ($stmt->execute() && reg === false) {
            echo "Registration successful!";
            $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
            $txt = "Registered,\n";
            fwrite($myfile, $txt);
            $txt = "true,";
            fwrite($myfile, $txt);
            fclose($myfile);
            Login_Register::ToAnotherPageWithDB($stmt, $conn, 'login.php');
        } else {
            echo "Error found: $stmt->error";
        }
        
    }
    // Amikor bejelentkezik!
    else if ($_POST['action'] === 'login') {
        $username = Login_Register::TestInput($_POST['username']);
        $email = Login_Register::TestInput($_POST['email']);
        $password = Login_Register::TestInput($_POST['password']);

        $sql_finding = "SELECT password FROM users WHERE username = ? AND email = ?";
        $stmt = $conn->prepare($sql_finding);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                echo "Login successful!";
                Login_Register::ToAnotherPageWithDB($stmt, $conn, 'login.php');

            } else {
                echo "No user found with the provided username, email or password!";
            }
        } else {
            echo "No user found with the provided username, email or password!";
        }
    }

    $stmt->close();
    $conn->close();

}


?>