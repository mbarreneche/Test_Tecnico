<?php
header("refresh:2; url = index.php#login" );
require_once("clases/dbMySql.php");
require_once("clases/validator.php");
require_once("clases/auth.php");
$auth = new Auth;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bienvenida</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <nav class="navibar">
    <a class="navibar__home-link" href="index.php"><i class="fas fa-home fa-2x"></i></a>
    <ul class="navibar__list">
      <li class="navibar__list__item"><a class="navibar__list__item__link" href="index.php#home">Inicio</a></li>
      
      <?php if ($auth->usuarioLogueado()) : ?>
        
        <li class="navibar__list__item"><a class="navibar__list__item__link" href="logout.php">Logout</a></li>
      <?php else : ?>
        <li class="navibar__list__item"><a class="navibar__list__item__link" href="index.php#login">Login</a></li>
        <li class="navibar__list__item"><a class="navibar__list__item__link" href="index.php#register">Registro</a></li>
      <?php endif; ?>
    </ul>
  </nav>
  <section>

    <div class="alert alert-success" role="alert">
      <h2 class="alert-heading">Gracias por registrarte!</h2>
    </div>

  </section>
</body>

</html>