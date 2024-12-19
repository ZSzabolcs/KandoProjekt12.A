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
    <?php include "head.html";   ?>
    <script src="methods.js"></script>
    <title>Regisztráció</title>
</head>

<body>
    <header>
        <h1 class="text-center text-container">
            Magyar földeken
        </h1>
    </header>
    <nav class="navbar navbar-expand-lg navbarcucc">
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
                $db = DeveloperDB::CallPDO();
                $username = Login_Register::TestInput($_POST['username']);
                $email = Login_Register::TestInput($_POST['email']);
                $password = Login_Register::TestInput($_POST['password']);
                $password = password_hash($password, PASSWORD_DEFAULT);
                $u = 'username';   $e = 'email';   $p = 'password';

                //Felhasználó ellenőrzése
                $sql_check_username = "SELECT COUNT(*) AS piece FROM user WHERE $u = :$u";
                $stmt = $db->prepare($sql_check_username);
                $stmt->bindValue(":$u", $username, DeveloperDB::PARAM_STR);
                $stmt->execute();

                $row = $stmt->fetch(DeveloperDB::FETCH_ASSOC);
                if ($row['piece'] > 0) {
                    // Ha a felhasználónév már létezik, hibaüzenetet jelenítünk meg
                    echo "A felhasználónév létezik!";
                } else {
                    $sql_insert = "INSERT INTO user ($u, $e, $p) VALUES (:$u, :$e, :$p)";
                    $stmt = $db->prepare($sql_insert);
                    $stmt->bindValue(":$u", $username, DeveloperDB::PARAM_STR);
                    $stmt->bindValue(":$e", $email, DeveloperDB::PARAM_STR);
                    $stmt->bindValue(":$p", $password, DeveloperDB::PARAM_STR);

                    $success = $stmt->execute();
                    if ($success) {
                        $_SESSION['user'] = $username;
                        $sql_create_table = 'CREATE TABLE IF NOT EXISTS ' . $username . '__chats_page  (
                            "chat_ser_num" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                            "from_who" VARCHAR(30) NOT NULL,
                            "message_text" TEXT NOT NULL,
                            "message_date" DATE NOT NULL,
                            CONSTRAINT FK_'.$username.'_page FOREIGN KEY (from_who)
                            REFERENCES user(username)
                            )';
                        $stmt = $db->prepare($sql_create_table);
                        $stmt->execute();
                        $directory_name = "/kepek/users/" . $username . "/public";
                        $current_path = getcwd();
                        $directory_path = realpath($current_path . DIRECTORY_SEPARATOR . $directory_name);
                        if ($directory_path === false) {
                            $directory_path = $current_path . DIRECTORY_SEPARATOR . $directory_name;
                            if (mkdir($directory_path, 0755, true)) {
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

                $db = null;
            }


            ?>
            <a href="<?php echo htmlspecialchars('login.php'); ?>">Már van fiókod?</a>
        </div>
    </div>
    <footer class="container py-3 footer">
        Footer, lábjegyzet, jogi izék, bla bla bla
    </footer>

    <script>
const Regist = () => {
    const username_regist = document.querySelector("#username");
    const email_regist = document.querySelector("#email");
    const password_regist = document.querySelector("#password");
    if (username_regist.value === "" || email_regist === "" || password_regist === ""){
        console.error("Add meg a szükséges adatokat!");
    }
    else sessionStorage.setItem("user", username_regist.value);
}
    </script>
</body>

</html>