<?php 
namespace Main;
include "Developer_class.php";
include "Login_register_class.php";
$developer = new Developer();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="cucc.css">
    <title>Bejelentkezés</title>
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
        <h1 class="text-center">Bejelentkezés</h1>
        <div class="form">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                
                <label for="email1">Email cím:</label>
                <input type="email" id="email1" name="email" required><br>
                <label for="username1" class="my-2">Felhasználónév:</label>
                <input type="text" id="username1" name="username" required><br>
                <label for="password1">Jelszó:</label>
                <input type="password" id="password1" name="password" required><br>
                <button type="submit" name="action" value="login" class="submit my-4">Bejelentkezés</button>
            </form>
        </div>
    </div>
    <footer class="container py-3 footer">
        Footer, lábjegyzet, jogi izék, bla bla bla
    </footer>

</body>
</html>

<?php
$t = [];
$myfile = fopen("newfile.txt", "r") or die("Unable to open file!");
$i = 0;
$ti = -1;
$tx = "";
while(!feof($myfile)) {
    if(fgetc($myfile) !== ","){
        $tx[$ti + 1] = fgetc($myfile);
        $ti++; 
    }
    else if (fgetc($myfile) === ","){
        array_push($t, $tx);
        $tx = "";
        $ti = 0;
    }
}

//fread($myfile,filesize("newfile.txt"));
fclose($myfile);
foreach ($t as $value) {
    echo $value;
}
?>