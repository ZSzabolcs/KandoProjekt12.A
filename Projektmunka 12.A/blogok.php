<?php
namespace Main;
use PDOException;
include "Login_register_class.php";
include "Developer_class.php";
session_name("user");
session_start();
?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <?php include "head.html" ?>
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
                    <a class="nav-link" href="<?php echo htmlspecialchars("chatszobak.php"); ?>">Üzenetek</a>
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
        $complete_blogs_texts = [];
        $chlimit = 411;
        $num = 0;
        $db = DeveloperDB::CallPDO();
        $stmt = $db->prepare("SELECT * FROM blog LIMIT 10");
        $stmt->execute();
        $posts = $stmt->fetchAll(DeveloperDB::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Kapcsolati hiba: " . $e->getMessage();

    }
    ?>
    <div class="container flex-grow-1 min-vh-63 py-3 blogbejhatter">
        <?php
        if (!empty($posts)) {
            foreach ($posts as $post) {
                echo '<div class="container blogbej my-2 py-2">';
                echo '<h3>' . htmlspecialchars($post["blog_title"]) . '</h3>';
                echo '<div class="commenter">Írta: ' . $post["blog_username"] . '</div>';
                $reszlet = substr(htmlspecialchars($post["blog_content"]), 0, $chlimit);
                echo '<div class="bevezeto">' . $reszlet . '</div>';
                echo '<button data-bs-toggle="collapse" data-bs-target="#content' . $post["blog_id"] . '" class="more" id="more' . $num . '">Több</button>';
                $blog_text = strlen($post["blog_content"]);
                $maradek = $blog_text - $chlimit;
                echo '<div id="content' . $post["blog_id"] . '" class="collapse">' . substr(htmlspecialchars($post["blog_content"]), $chlimit, abs($maradek)) . '</div>';
                $complete_blogs_texts[$num] = $blog_text;
                echo '</div>';
                $num++;
                // Kommentek lekérdezése a blogbejegyzéshez
                $comment_stmt = $db->prepare("SELECT * FROM comment WHERE comment_id = :post_id");
                $comment_stmt->execute(['post_id' => $post["blog_id"]]);
                $comments = $comment_stmt->fetchAll(DeveloperDB::FETCH_ASSOC);

                echo '<div class="collapse container" id="content' . $post["blog_id"] . '">';
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
    <script>
        
        const blogs = document.getElementsByClassName("container blogbej my-2 py-2");

        for (let i = 0; i < blogs.length; i++) {
            if (<?php for ($i = 0; $i < count($complete_blogs_texts); $i++) {
                echo $complete_blogs_texts[$i];
            } ?> <= <?php echo $chlimit; ?>) {
                blogs[i].removeChild(blogs[i].lastChild);

            }
        }


        for (let i = 0; i < blogs.length; i++) {

            let button = blogs[i].querySelector(".more");
            button.onclick = function () {
                let isExpanded = this.getAttribute("aria-expanded") === "true";
                this.setAttribute("aria-expanded", isExpanded);

                if (!isExpanded) {
                    blogs[i].appendChild(button);
                    button.innerText = "Több";
                }
                else {
                    blogs[i].appendChild(button);
                    button.innerText = "Kevesebb";
                }
            };
        }
            
    </script>
</body>

</html>