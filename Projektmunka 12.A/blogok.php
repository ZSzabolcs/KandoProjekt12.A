<?php
namespace Main;
include "Login_register_class.php";
include "Developer_class.php";
session_name("user");
session_start();
if ($_SESSION["user"] === null)  Login_register::ToAnotherPage("login.php");
?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <?php include "head.html"; ?>
    <title>Blogok</title>
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
                    <a class="nav-link" href="<?php echo htmlspecialchars("blogger_create.php"); ?>">Blog készítő felület</a>
                </li>
            </ul>
        </div>
    </nav>
    <?php
    $blogs_info = [];
    $chlimit = 411;
    $num = 0;
    $db = DeveloperDB::CallPDO();
    $stmt = $db->prepare("SELECT * FROM blog LIMIT 10");
    $stmt->execute();
    $posts = $stmt->fetchAll(DeveloperDB::FETCH_ASSOC);

    ?>
    <div class="container flex-grow-1 min-vh-63 py-3 blogbejhatter">
        <?php
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $cu = "comment_username";  $tt = "target_title";  $cc = "comment_content";   $cd = "comment_date"; $ci = "comment_id";
                $bt = "blog_title";   $bc = "blog_content";   $bu = "blog_username";   $bi = "blog_id";  $bd = "blog_made_date";
                $reszlet = substr(htmlspecialchars($post[$bc]), 0, $chlimit);
                $blog_text_length = strlen($post[$bc]);
                $maradek = $blog_text_length - $chlimit;
                $mar_text = substr(htmlspecialchars($post[$bc]), $chlimit, abs($maradek));
                echo '<div class="container blogbej my-2 py-2">
                <div class="commenter">'.
                    $post[$bu].' <br>dátum: '.$post[$bd].' <br> Cím: '.$post[$bt].'</div>
                <div class="p-3 bejegyzes">
                    <div>'.$reszlet
                        .'<button data-bs-toggle="collapse" id="content" data-bs-target="#content'.$post[$bi].'" class="more" id="more'.$num.'">Több</button></div>
                    <div id="content'.$post[$bi].'" class="test collapse">'.
                        $mar_text
                    .'</div>
                </div>
            </div>';
            $blogs_info[$num][0] = $blog_text_length;
            $blogs_info[$num][1] = $post[$bi];
                // Kommentek lekérdezése a blogbejegyzéshez
                $comment_stmt = $db->prepare("SELECT * FROM comment");
                $comment_stmt->execute();
                $comments = $comment_stmt->fetchAll(DeveloperDB::FETCH_ASSOC);

                echo '<div class="collapse container" id="content' . $post[$bi] . '">';
                if (!empty($comments)) {
                    foreach ($comments as $comment) {
                        if ($post[$bi] === $comment[$ci]) {
                            echo '<div class="comment">';
                            echo '<span class="commenter">' . htmlspecialchars($comment[$cu]) . ':</span><span> ' . htmlspecialchars($comment[$cd]) . '</span><br>';
                            echo '<div class="p-3">' . htmlspecialchars($comment[$cc]) . '</div>';
                            echo '</div>';
                        }
                    }
                } else {
                    echo '<p>Nincsenek kommentek.</p>';
                }
                echo 'Itt írhatsz kommentet!';
                echo '<form action="blogok.php" method="post">';
                echo "<textarea name='comment_text'></textarea>";
                echo "<input type='hidden'  name='post_id' value='$num'>";
                echo "<button type='submit'>Küldés</button>";
                echo '</form>';
                echo '</div>';
                $num++;
            }
        } else {
            echo "<p>Nincsenek blogbejegyzések.</p>";
        }
        $db = null;

        if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["comment_text"])) {
            $cu = "comment_username";
            $tt = "target_title";
            $cc = "comment_content";
            $cd = "comment_date";
            $db = DeveloperDB::CallPDO();
            $now = date("Y-m-d H:i");
            $commenter = $_SESSION["user"];
            $comment_content = $_POST["comment_text"];
            $blog_title = $blogs_info[$_POST["post_id"]][1];
            $insert_sql = 'INSERT INTO "comment" ('.$cu.', '.$tt.', '.$cc.', '.$cd.') VALUES (:'.$cu.', :'.$tt.', :'.$cc.', :'.$cd.')';
            $stmt = $db->prepare($insert_sql);
            $stmt->bindValue(":$cu", $commenter, DeveloperDB::PARAM_STR);
            $stmt->bindValue(":$tt", $blog_title, DeveloperDB::PARAM_STR);
            $stmt->bindValue(":$cc", $comment_content, DeveloperDB::PARAM_STR);
            $stmt->bindValue(":$cd", $now, DeveloperDB::PARAM_STR);
            $stmt->execute();
            echo '<meta http-equiv="refresh" content="0.5">';
        }

        $db = null;
        ?>
    </div>
    <footer class="container py-3 footer">
        Footer, lábjegyzet, jogi izék, bla bla bla
    </footer>
    <script>
        const blogs = document.getElementsByClassName("container blogbej my-2 py-2");

        for (let i = 0; i < blogs.length; i++) {
            if (<?php for ($i = 0; $i < count($blogs_info); $i++) {
                    echo $blogs_info[$i][0];
                } ?> <= <?php echo $chlimit; ?>) {
                blogs[i].removeChild(blogs[i].lastChild);

            }
        }


        for (let i = 0; i < blogs.length; i++) {

            let button = blogs[i].querySelector(".more");
            button.onclick = function() {
                let isExpanded = this.getAttribute("aria-expanded") === "true";
                this.setAttribute("aria-expanded", isExpanded);

                if (!isExpanded) {
                    blogs[i].appendChild(button);
                    this.innerText = "Több";
                } else {
                    blogs[i].appendChild(button);
                    this.innerText = "Kevesebb";
                }
            }
        }
    </script>
</body>

</html>