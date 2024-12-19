<?php 
namespace Main;
session_name('user');
session_start();
?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <?php include "head.html"; ?>
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
              <ul class="navbar-nav">
                <li class="nav-item navpad">
                  <a class="nav-link" href="<?php echo htmlspecialchars("chatszobak.php"); ?>">Chat szobák</a>
                </li>
                <li class="nav-item navpad">
                    <a class="nav-link" href="<?php echo htmlspecialchars("blogger_create.php"); ?>">Blog készítő</a>
                  </li>
                  <li class="nav-item navpad">
                    <a class="nav-link" href="<?php echo htmlspecialchars("blogok.php"); ?>">Blogok</a>
                  </li>
              </ul>
            </div>
          
          </nav>
        <div class="container flex-grow-1 min-vh-63 py-3">
            <h1 class="username">Üdvözöljük <i><?php
             if ($_SESSION["user"] === null) {
              Login_register::ToAnotherPage("login.php");
             }
             else {
              echo $_SESSION["user"];
             }
             ?></i>!</h1>
            <h1 class="text-center">
              Rólunk 
            </h1>
            <p>
              Oldalunk azért jött létre, hogy a Magyarországon élő természetszerető emberek könnyebben megtalálják egymást, túrákat, barlangászást, szalonnasütést és egyéb programokat szervezzenek, tippeket, tanácsokat kérjenek és osszanak meg egymással, különböző látogatásra érdemes helyeket mutassanak be, fényképeket osszanak meg, és egy jól működő közösséget alkossanak.
            </p>
            <h2>
              Az ötletgazda
            </h2>
            <p>
              <b>Zelenák Szabolcs</b>, 19 éves, 12. osztályos középiskolás tanuló.
            </p>
            <p>
              "A természet szeretete már nagyon régóta szívügyem, de nagyon nehéz manapság olyan embert találni, aki osztozna a lelkesedésemen. Bizonyára nem én vagyok az egyetlen, aki így érez, ezért úgy gondoltam, össze kellene fogni egy jól működő közösséget ezen emberek számára."
            </p>
            <h2>
              A csapat
            </h2>
            <p>
              <b>Zelenák Szabolcs</b> - Ötletgazda, tervező és front-end felelős.
            </p>
            <p>
              <b>Csiger Imre Krisztián</b>, 19 éves, 12. osztályos középiskolás tanuló - Back-end felelős
            </p>
            <p>
              Ketten hoztuk létre az oldalt egy iskolai projektmunka céljából, ugyanakkor ennél többet látunk benne.
            </p>
        </div>
        <footer class="container py-3 footer">
            Footer, lábjegyzet, jogi izék, bla bla bla
        </footer>
    </body>
</html>