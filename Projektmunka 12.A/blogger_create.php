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
    <title>Blogger készítés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="cucc.css">
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
        <div id="blog" contenteditable="true">

        </div>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" onsubmit="return SubmitContent()">
            <input type="hidden" name="content" id="content">
            <button type="submit">Publikáld</button>
        </form>

        <?php
        $username = $_SESSION['user'];
        $blog_title = "Most komolyan!!";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $db = new PDO('sqlite:Blogger.db');
            $db->exec('PRAGMA foreign_keys = ON;');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $blog_content = Login_register::TestInput($_POST["content"]);
            $decoded_content = html_entity_decode($blog_content);
            $u = "blog_username"; $bt = "blog_title"; $bc = "blog_content"; $bm = "blog_made_date";
            $sql_blog = "INSERT INTO blog ($u, $bt, $bc, $bm) VALUES (:$u, :$bt, :$bc, :$bm)";
            $now = date("Y-m-d");

            $sql_check_blog_title = "SELECT COUNT(*) as piece FROM blog WHERE $bt = :$bt";
            $stmt = $db->prepare($sql_check_blog_title);
            $stmt->bindValue(":$bt", $blog_title, PDO::PARAM_STR);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row["piece"] > 0){
                echo "A blog cím létezik!";
            }
            else{
            $sql_insert = "INSERT INTO blog ($u, $bt, $bc, $bm) VALUES (:$u, :$bt, :$bc, :$bm)";
            $stmt = $db->prepare($sql_insert);
            $stmt->bindValue(":$u", $username, PDO::PARAM_STR);
            $stmt->bindValue(":$bt", $blog_title, PDO::PARAM_STR);
            $stmt->bindValue(":$bc", $decoded_content, PDO::PARAM_STR);
            $stmt->bindValue(":$bm", $now, PDO::PARAM_STR);

            $success = $stmt->execute();
                if ($success) {
                    echo "Sikeres feltöltés!";
                }

        }
    }
        catch (PDOException $e) {
            echo 'Hiba történt '. $e->getMessage();
        }
    }
    ?>
    </div>
<script src="methods.js"></script>
</body>
</html>

