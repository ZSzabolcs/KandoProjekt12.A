<?php 
namespace Main;
use PDO;
use PDOException;
include "Login_register_class.php";
session_name("user");
session_start();
?>
<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="cucc.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <title>Cucc</title>
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
                  <a class="nav-link" href="<?php echo htmlspecialchars("cucc.php"); ?>">Kezdőlap</a>
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
                    <a class="nav-link" href="<?php echo htmlspecialchars("blogok.php"); ?>">Blogok</a>
                  </li>
              </ul>
            </div>
        </nav>
        <?php
            try {
              $num = 0;
              $db = new PDO("sqlite:Blogger.db");
              $db->exec('PRAGMA foreign_keys = ON;');
              $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $stmt = $db->prepare("SELECT * FROM blog");
              $stmt->execute();
              $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
          } catch(PDOException $e) {
              echo "Connection failed: " . $e->getMessage();
          }
            ?>
        <div class="container flex-grow-1 min-vh-63 py-3 blogbejhatter">
        <?php
    if (!empty($posts)) {
        foreach ($posts as $post) {
            echo '<div class="container blogbej my-2 py-2">';
            echo '<h3>' . htmlspecialchars($post["blog_title"]) . '</h3>';
            echo '<div class="bevezeto">' . substr(htmlspecialchars($post["blog_content"]), 0, 470) . '...'; // Rövidített szöveg
            echo '<button data-bs-toggle="collapse" data-bs-target="#content' . $post["blog_id"] . '" class="more" id="more'.$num.'" onclick="MoveButton()">Több</button></div>';
            
            echo '<div id="content' . $post["blog_id"] . '" class="collapse">' . htmlspecialchars($post["blog_content"]) . '</div>';
            echo '</div>';
            $num++;
            // Kommentek lekérdezése a blogbejegyzéshez
            $comment_stmt = $db->prepare("SELECT * FROM comment WHERE comment_id = :post_id");
            $comment_stmt->execute(['post_id' => $post["blog_id"]]);
            $comments = $comment_stmt->fetchAll(PDO::FETCH_ASSOC);

            echo '<div class="collapse container" id="content'.$post["blog_id"].'">';
            if (!empty($comments)) {
                foreach ($comments as $comment) {
                    echo '<div class="comment">';
                    echo '<span class="commenter">' . htmlspecialchars($comment["comment_username"]) . ':</span><br>';
                    echo '<div class="p-3">' . htmlspecialchars($comment["comment_content"]) . '</div>';
                    echo '</div>';
                }
            } else {
                echo "<p>Nincsenek kommentek.</p>";
            }
            echo '</div>';
        }
    } else {
        echo "<p>Nincsenek blogbejegyzések.</p>";
    }
    ?>
        </div>
            <footer class="container py-3 footer">
            Footer, lábjegyzet, jogi izék, bla bla bla
        </footer>
        <script src="methods.js"></script>
        
</body>
</html>