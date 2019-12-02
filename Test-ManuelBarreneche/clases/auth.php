<?php
class Auth
{
  function __construct()
  {
    session_start();
    //pasar el email de la cookie a session
  }
public function loguearUsuario($email)
{
   $_SESSION["email"] = $email;
}
public function usuarioLogueado()
{
  // if(chequeaste "recordarme"){
  //     setcookie();
  // } Crear cookie.
  return isset($_SESSION["email"]);
}
}