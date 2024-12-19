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
    <?php include "head.html"; ?>
    <title>Blogger készítés</title>
    <style>

   :root {
      font: 400 2ch/1.25 Consolas;
    }
    
    body {
      font-size: 2ch
    }
    
    #editor {
      height: 400px;
      width: 375px;
      margin: 10px auto 0;
    }
    
    fieldset {
      margin: 2px auto 15px;
      width: 375px;
    }
    
    </style>
</head>

<body>
    <header>
        <h1 class="text-center text-container">
            Magyar földeken
        </h1>
    </header>
    <nav class="navbar navbar-expand-lg navbarcucc">
        <div class="container-fluid justify-content-center">
            <ul class="navbar-nav">
                <li class="nav-item navpad">
                    <a class="nav-link" href="<?php echo htmlspecialchars("cucc.php"); ?>">Kezdőlap</a>
                </li>
                <li class="nav-item navpad">
                    <a class="nav-link" href="<?php echo htmlspecialchars("chatszobak.php"); ?>">Közösségi tér</a>
                </li>
                <li class="nav-item navpad">
                    <a class="nav-link" href="<?php echo htmlspecialchars("blogok.php"); ?>">Blogok</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="">
        <h1 class="text-center">Blog készítés</h1>
        <fieldset><button class="fontStyle" onclick="document.execCommand('italic', false, null);"
                    title="Italicize Highlighted Text"><i>I</i>
                </button>
                <button class="fontStyle" onclick="document.execCommand('bold', false, null);"
                    title="Bold Highlighted Text"><b>B</b>
                </button>
                <button class="fontStyle" onclick="document.execCommand('underline', false, null);"
                    title='Underline Highlighted Text'><u>U</u>
                </button>
        </fieldset><br>
        <textarea id="blog" contenteditable="true" style="width: 100%; height: 80px;">

        </textarea>
        <script>document.getElementById("blog").textContent = "";</script>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" onsubmit="return SubmitContent()">
            <input type="hidden" name="content" id="content">
            <label for="title">A blog címe:</label>
            <input type="text" name="title" id="title" required>
            <button type="submit">Publikáld</button>
        </form>

        <?php
        $username = $_SESSION['user'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $db = DeveloperDB::CallPDO();
            $blog_content = Login_register::TestInput($_POST["content"]);
            $decoded_content = html_entity_decode($blog_content);
            $blog_title = Login_register::TestInput($_POST["title"]);
            $u = "blog_username"; $bt = "blog_title"; $bc = "blog_content"; $bm = "blog_made_date";
            $sql_blog = "INSERT INTO blog ($u, $bt, $bc, $bm) VALUES (:$u, :$bt, :$bc, :$bm)";
            $now = date("Y-m-d");

            $sql_check_blog_title = "SELECT COUNT(*) as piece FROM blog WHERE $bt = :$bt";
            $stmt = $db->prepare($sql_check_blog_title);
            $stmt->bindValue(":$bt", $blog_title, DeveloperDB::PARAM_STR);
            $stmt->execute();
            
            $row = $stmt->fetch(DeveloperDB::FETCH_ASSOC);
            if ($row["piece"] > 0){
                echo "A blog cím létezik!";
            }
            else{
            $sql_insert = "INSERT INTO blog ($u, $bt, $bc, $bm) VALUES (:$u, :$bt, :$bc, :$bm)";
            $stmt = $db->prepare($sql_insert);
            $stmt->bindValue(":$u", $username, DeveloperDB::PARAM_STR);
            $stmt->bindValue(":$bt", $blog_title, DeveloperDB::PARAM_STR);
            $stmt->bindValue(":$bc", $decoded_content, DeveloperDB::PARAM_STR);
            $stmt->bindValue(":$bm", $now, DeveloperDB::PARAM_STR);

            $success = $stmt->execute();
                if ($success) {
                    echo "Sikeres feltöltés!";
                }

        }
    }
        catch (PDOException $e) {
            echo 'Hiba történt a PDO-val '. $e->getMessage();
        }
    }
    ?>
    </div>
<script src="methods.js"></script>
</body>
</html>

