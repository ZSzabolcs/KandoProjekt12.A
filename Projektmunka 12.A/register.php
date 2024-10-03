<?php
function ToAnotherPage($database, $connection)
{
    $database->close();
    $connection->close();
    session_start();
    header("Location: link.html");
    exit();
}

// Akkor indul el ha megnyomjuk a 'submit' gombot!
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $servername = "localhost";
    $db_username = "csiger";
    $db_password = "";
    $dbname = "phpdatabase";

    // Kapcsolódás az adatbázishoz
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Kapcsolódási hiba ellenőrzése
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Posztolás következik!
    switch ($_POST['action']) {
        // Amikor beregisztrál!
        case 'register':
            $username = $_POST['username'];
            $email = $_POST['email'];
            //$_POST['password'], PASSWORD_DEFAULT
            $password = password_hash($password, PASSWORD_DEFAULT);

            //Felhasználó ellenőrzése
            $sql_check_username = "SELECT * FROM users WHERE username = ?";
            $stmt = $conn->prepare($sql_check_username);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();


            if ($stmt->num_rows > 0) {
                // Ha a felhasználónév már létezik, hibaüzenetet jelenítünk meg
                echo '<div class="message error">The username is already taken. Please choose another one.</div>';
                $stmt->close();
                $conn->close();
                break;
            } else {
                // Ha a felhasználónév nem létezik, folytatjuk a regisztrációt
                $sql_insert = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql_insert);
                $stmt->bind_param("sss", $username, $email, $password);
            }


            if ($stmt->execute()) {
                echo "<div class=\"message success\">Registration successful!</div>";
                ToAnotherPage($stmt, $conn);
            } else {
                echo "<div class=\"message error\">Error: $stmt->error</div>";
            }

            break;
         //////////////////////////////////////////////////////////

         // Amikor bejelentkezik!
        case 'login':
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $sql_atolvasas = "SELECT password FROM users WHERE username = ? AND email = ?";
            $stmt = $conn->prepare($sql_atolvasas);
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($hashed_password);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {
                    echo '<div class="message success">Login successful!</div>';
                    ToAnotherPage($stmt, $conn);

                } else {
                    echo '<div class="message error">No user found with the provided username, email or password!</div>';
                }
            } else {
                echo '<div class="message error">No user found with the provided username, email or password!</div>';
            }

            break;
    }

    $conn->close();
}

/*
   if ($_POST['action'] == 'register') 
   {
       $username = $_POST['username'];
       $email = $_POST['email'];
       $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

       $sql_atiras = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
       $stmt = $conn->prepare($sql_atiras);
       $stmt->bind_param("sss", $username, $email, $password);

       if ($stmt->execute()) {
           echo '<div class="message success">Registration successful!</div>';
       } else {
           echo '<div class="message error">Error: ' . $stmt->error . '</div>';
       }

       $stmt->close();
   } 
   
   else if ($_POST['action'] == 'login') 
   {
       $username = $_POST['username'];
       $email = $_POST['email'];
       $password = $_POST['password'];

       $sql_atolvasas = "SELECT password FROM users WHERE username = ? AND email = ?";
       $stmt = $conn->prepare($sql_atolvasas);
       $stmt->bind_param("ss", $username, $email);
       $stmt->execute();
       $stmt->store_result();

       if ($stmt->num_rows > 0) {
           $stmt->bind_result($hashed_password);
           $stmt->fetch();

           if (password_verify($password, $hashed_password)) {
               echo '<div class="message success">Login successful!</div>';
           } else {
               echo '<div class="message error">Invalid password!</div>';
           }
       } else {
           echo '<div class="message error">No user found with the provided username and email!</div>';
       }

       $stmt->close();
   }
   */
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register and Login</title>
    <style>
        .message {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid transparent;
            border-radius: 5px;
        }

        .message.success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .message.error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>

<body>
    <h1>Register</h1>
    <form method="post" action="register.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit" name="action" value="register">Register</button>
    </form>

    <h1>Login</h1>
    <form method="post" action="register.php">
        <label for="username1">Username:</label>
        <input type="text" id="username1" name="username" required><br>
        <label for="email1">Email:</label>
        <input type="email" id="email1" name="email" required><br>
        <label for="password1">Password:</label>
        <input type="password" id="password1" name="password" required><br>
        <button type="submit" name="action" value="login">Login</button>
    </form>


    <script module="text/javascript">
        localStorage.clear();
        let va = <?php echo 4 === 4; ?>;
        let b = Boolean(va);
        console.log(b);
        if (b) {
            console.log("2 = 2")
        }
        else {
            console.log("2 != 4")
        }
    </script>

</body>

</html>
