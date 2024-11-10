<?php
namespace Main;
use PDOException;
include "Login_register_class.php";
include "Developer_class.php";
session_name('user');
session_start();
?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="cucc.css">
    <script src="methods.js" defer></script>
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
                    <a class="nav-link" href="<?php echo htmlspecialchars("cucc.php") ?>">Kezdőlap</a>
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
                <button type="submit" onclick="Regist()"
                    class="submit my-4">Regisztráció</button>
            </form>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Akkor indul el ha megnyomjuk a 'submit' gombot!
                try {
                    // Kapcsolódás az adatbázishoz
                    $db = DeveloperDB::CallPDO();
                    // Amikor beregisztrál!
                    $username = Login_Register::TestInput($_POST['username']);
                    $email = Login_Register::TestInput($_POST['email']);
                    $password = Login_Register::TestInput($_POST['password']);
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    $u = 'username';  $e = 'email';  $p = 'password';

                    //Felhasználó ellenőrzése
                    $sql_check_username = "SELECT COUNT(*) as piece FROM user WHERE $u = :$u";
                    $stmt = $db->prepare($sql_check_username);
                    $stmt->bindValue(":$u", $username, DeveloperDB::PARAM_STR);
                    $stmt->execute();

                    $row = $stmt->fetch(DeveloperDB::FETCH_ASSOC);
                    if ($row['piece'] > 0) {
                        // Ha a felhasználónév már létezik, hibaüzenetet jelenítünk meg
                        echo "A felhasználónév létezik!";
                    } else {

                        // Ha a felhasználónév nem létezik, folytatjuk a regisztrációt
                        $sql_insert = "INSERT INTO user ($u, $e, $p) VALUES (:$u, :$e, :$p)";
                        $stmt = $db->prepare($sql_insert);
                        $stmt->bindValue(":$u", $username, DeveloperDB::PARAM_STR);
                        $stmt->bindValue(":$e", $email, DeveloperDB::PARAM_STR);
                        $stmt->bindValue(":$p", $password, DeveloperDB::PARAM_STR);

                        $success = $stmt->execute();
                        if ($success) {
                            $_SESSION['user'] = $username;
                            $directory_name = "/kepek/users/" . $username . "/public";
                            $current_path = getcwd();
                            $directory_path = realpath($current_path . DIRECTORY_SEPARATOR . $directory_name);
                            if ($directory_path === false) {
                                $directory_path = $current_path . DIRECTORY_SEPARATOR . $directory_name;
                                if (mkdir($directory_path, 0755, true)) {
                                    echo "Sikeres regisztráció!!!";
                                    Login_register::ToAnotherPage("cucc.php");
                                } else {
                                    echo "Hiba a mappa létrehozásakor.";
                                }
                            } else {
                                echo "A felhasználó létezik!";
                            }

                        } else {
                            echo "Hiba történt, próbálja meg később!";
                        }
                    }

                } catch (PDOException $e) {
                    print ("Hiba történt: " . $e->getMessage() . "<br>");
                    die();
                }
                $db = null;
            }

            ?>
            <a href="<?php echo htmlspecialchars('login.php'); ?>">Már van fiókod?</a>
        </div>
    </div>
    <footer class="container py-3 footer">
        Footer, lábjegyzet, jogi izék, bla bla bla
    </footer>
</body>
</html>