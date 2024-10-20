<?php 
namespace Main;
//PHP Cookie
session_name('user');
session_start();
?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="cucc.css">
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
            <h1 class="username">Üdvözöljük<i></i>!</h1>
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
              <b>Csiger Imre Krisztián</b>, 18 éves, 12. osztályos középiskolás tanuló - Back-end felelős
            </p>
            <p>
              Ketten hoztuk létre az oldalt egy iskolai projektmunka céljából, ugyanakkor ennél többet látunk benne.
            </p>
        </div>
        <footer class="container py-3 footer">
            Footer, lábjegyzet, jogi izék, bla bla bla
        </footer>
        <script src="script.js"></script>
    </body>
</html>