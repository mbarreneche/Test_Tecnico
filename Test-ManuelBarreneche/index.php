<?php


require_once("clases/dbMySql.php");
require_once("clases/validator.php");
require_once("clases/auth.php");
$auth = new Auth;
$dbMysql = new dbMySql;
if(isset($_SESSION["email"])){
  $usuario = $dbMysql->buscarPorEmail($_SESSION["email"]); }
  
  // REGISTRO //
if ($_POST && isset($_POST["register"])) {
  $errores = Validator::validarRegistro($_POST);
  $nameOk = $_POST["name"];
  $lastnameOk = $_POST["lastname"];
  $emailOk = $_POST["email"];
  $ciudad1Ok = $_POST["ciudad1"];
  $ciudad2Ok = $_POST["ciudad2"];
  $ciudad3Ok = $_POST["ciudad3"];
  if (empty($errores)) {
    if (!$dbMysql->existeUsuario($_POST["email"])) {
      $usuario = new Usuario($_POST);      
      $dbMysql->guardarUsuario($usuario); 
      header("Location:bienvenida.php");
      exit;
    }
  }
}
                                         // LOGIN //
if ($_POST && isset($_POST["login"])) {
  $erroresLogin = Validator::validarLogin($_POST);
 
  if (empty($erroresLogin)) {
  $auth->loguearUsuario($_POST["email"]);
    
    header("Location:index.php");
    exit;
  }
}
if ($auth->usuarioLogueado()) {
  $user = $auth->usuarioLogueado();}
  ?>

<!DOCTYPE html>
  <html lang="en">

  <head>
  <meta charset="utf-8">
  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous" ></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test</title>
  <link rel="stylesheet" href="css/style.css">
  </head>

  <body>
  <nav class="navibar">
  <?php if ($auth->usuarioLogueado()) : // ?>
    
    <ul class="navibar__list2">
    <li class="navibar__list__item"><a class="navibar__list__item__link" href="#"><?php echo $usuario->getName();  ?></a></li>
    </ul><?php endif; ?>
    <ul class="navibar__list">
    <li class="navibar__list__item"><a class="navibar__list__item__link" href="#home">Home</a></li>
    <?php if ($auth->usuarioLogueado()) : ?>

    <li class="navibar__list__item"><a class="navibar__list__item__link" href="logout.php">Logout</a></li>
    <?php else : ?>
    <li class="navibar__list__item"><a class="navibar__list__item__link" href="#login">Login</a></li>
    <li class="navibar__list__item"><a class="navibar__list__item__link" href="#register">Registro</a></li>
    <?php endif; ?>
    </ul>
    </nav>
    <main class="content" id="home">
 
 <section class="clima" id="clima"> 



 <div class="botonesclima">
 <input id="ciudad"></input>
  <button class="form__btn" id="dameclima">¡¡ Dame el clima !!</button>
  </div>
  <div class="divclima"></div>

  <script type="text/javascript">
    $(document).ready(function(){
      
      $("#dameclima").click(function(){
                
            var ciudad = $("#ciudad").val();
            var key  = 'c76f8272396b136b6cb40bccc939ef5d';
            
            $.ajax({
              url:'http://api.openweathermap.org/data/2.5/weather',
              dataType:'json',
              type:'GET',
              data:{q:ciudad, appid: key, units: 'metric', lang: 'es'},

              success: function(data){
                var wf = '';
                $.each(data.weather, function(index, val){

                  wf += '<p class="climap"><b>' + data.name + "</b><img src="+ val.icon + ".png></p>" + '<p class="climap">'+ data.main.temp + '&deg;C ' + 
                  ' | ' + val.main + ", " + val.description 

                });
              
               $(".divclima").html(wf);
              }

            })

      });
    });
  </script>
<?php if ($auth->usuarioLogueado()) : ?>
<div class="ciudadesfavoritas">
    <h1 class="titulociudades">Ciudades Favoritas de <?php echo $usuario->getName(); ?>:</h1>
    <ul>
        <li><p class="listaciudades"> <?php echo $usuario->getCiudad1(); ?></p></li>
        <li><p class="listaciudades"> <?php echo $usuario->getCiudad2(); ?></p></li>
        <li><p class="listaciudades"> <?php echo $usuario->getCiudad3(); ?></p></li>
    </ul>
</div>
<?php else : ?>

 <div class="ciudadesfavoritas">
 <?php endif; ?>
    
</div>

 </section>
   
    <?php if (!$auth->usuarioLogueado()) : ?>
    <section class="login-section" id="login">
    <form class="form" action="index.php#login" method="POST">
    <h1 class="form__title">Login</h1>
    <div class="form__group">
    <label class="form__group__text-label" for="email">Email:</label>
    <input class="form__group__text-field" type="email" name="email" id="email" placeholder="Ingrese su correo electronico" required>
    </div>
    <?php if (!empty($erroresLogin["email"])) { ?>
      <div class="alert alert-danger" role="alert">
      <?php echo $erroresLogin["email"]; ?>
      </div>
      <?php } ?>

      <div class="form__group">
      <label class="form__group__text-label" for="pwd">Contraseña:</label>
      <input class="form__group__text-field" type="password" name="pwd" id="pwd" placeholder="Password">
      </div>
      <?php if (!empty($erroresLogin["pwd"])) { ?>
        <div class="alert alert-danger" role="alert">
        <?php echo $erroresLogin["pwd"]; ?>
        </div>
        <?php } ?>
        

        <button type="submit" class="form__btn submit" name="login" value="ingresar">Login</button>

        <p class="form__not-registered">¿No tenés cuenta?<a class="form__not-registered__link" href="#register">Registrate</a></p>
        <input type="hidden" name="login" value="">
        </form>
        </section>
        <?php endif; ?>

        <?php if (!$auth->usuarioLogueado()) : ?>
        <section class="register-section" id="register">
        <form class="form" action="index.php#register" method="post">
        <h1 class="form__title">Registrate</h1>
        <div class="form__group">
        <label class="form__group__text-label" for="name">Nombre</label>
        <input id="name" class="form__group__text-field" name="name" type="text" value=""
        <?php if (isset($nameOk) && empty($errores["name"])) { echo $nameOk;
        } ?> placeholder="Ingresá tu nombre">
        </div>
        <?php if (!empty($errores["name"])) { ?>
          <div class="alert alert-danger" role="alert">
          <?php echo $errores["name"]; ?>
          </div>
          <?php } ?>
          <div class="form__group">
          <label class="form__group__text-label" for="lastname">Apellido</label>
          <input id="lastname" class="form__group__text-field" name="lastname" type="text" value=""
          <?php if (isset($lastnameOk) && empty($errores["lastname"])) {
            echo $lastnameOk;
          } ?> placeholder="Ingresá tu apellido">
          </div>
          <?php if (!empty($errores["lastname"])) { ?>
            <div class="alert alert-danger" role="alert">
            <?php echo $errores["lastname"]; ?>
            </div>
            <?php } ?>
            <div class="form__group">
            <label class="form__group__text-label" for="email">Email</label>
            <input id="email" class="form__group__text-field" name="email" type="email" value="
            <?php if (isset($emailOk) && empty($errores["email"])) {
              echo $emailOk;
            } ?>" placeholder="Ingresá tu email">
            </div>
            <?php if (!empty($errores["email"])) { ?>
              <div class="alert alert-danger" role="alert">
              <?php echo $errores["email"]; ?>
              </div>
              <?php } ?>
              <div class="form__group">
              <label class="form__group__text-label" for="pwd">Contraseña</label>
              <input id="pwd" class="form__group__text-field" name="pwd" type="password" placeholder="Password">
              </div>
              <div class="form__group">
              <label class="form__group__text-label" for="retypepwd">Repite Contraseña</label>
              <input id="retypepwd" class="form__group__text-field" name="retypepwd" type="password" placeholder="Password">
              </div>
              <?php if (!empty($errores["pwd"])) { ?>
                <div class="alert alert-danger" role="alert">
                <?php echo $errores["pwd"]; ?>
                </div>
                <?php } ?>

                <div class="form__group">
            <label class="form__group__text-label" for="ciudad1">Ingresa tus 3 ciudades favoritas</label>
            <input id="ciudad1" class="form__group__text-field" name="ciudad1" type="text" value="
            <?php if (isset($ciudad1Ok) && empty($errores["ciudad1"])) {
              echo $ciudad1Ok;
            }?>" placeholder="Ingresá tus ciudades favoritas">
            </div>
            <?php if (!empty($errores["ciudad1"])) { ?>
              <div class="alert alert-danger" role="alert">
              <?php echo $errores["ciudad1"]; ?>
              </div>
              <?php } ?>

              <div class="form__group">
            <label class="form__group__text-label" for="ciudad2"></label>
            <input id="ciudad2" class="form__group__text-field" name="ciudad2" type="text" value="
            <?php if (isset($ciudad2Ok) && empty($errores["ciudad2"])) {
              echo $ciudad2Ok;
            } ?>" placeholder="Ingresá una de tus ciudades favoritas">
            </div>
            <?php if (!empty($errores["ciudad2"])) { ?>
              <div class="alert alert-danger" role="alert">
              <?php echo $errores["ciudad2"]; ?>
              </div>
              <?php } ?>

              <div class="form__group">
            <label class="form__group__text-label" for="ciudad3"></label>
            <input id="ciudad3" class="form__group__text-field" name="ciudad3" type="text" value="
            <?php if (isset($ciudad3Ok) && empty($errores["ciudad3"])) {
              echo $ciudad3Ok;
            } ?>" placeholder="Ingresá una de tus ciudades favoritas">
            </div>
            <?php if (!empty($errores["ciudad3"])) { ?>
              <div class="alert alert-danger" role="alert">
              <?php echo $errores["ciudad3"]; ?>
              </div>
              <?php } ?>
                
                  
                  <button class="form__btn" type="submit" name="register">Registrarme</button>
                  <input type="hidden" name="register" value="">
                  </form>
                  </section>
                  <?php endif; ?>
                  </main>
                  </body>

                  </html>