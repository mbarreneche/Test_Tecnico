<?php
include_once 'clases/dbmysql.php';
class Validator {
  public static function validarRegistro($datos)
  {
    global $dbMysql;

    
    $errores = [];
    $datosTrim = [];
    
    foreach ($datos as $posicion => $valor) {
      $datosTrim[$posicion] = trim($valor);
    }
    if (strlen($datosTrim["name"]) == 0) {
      $errores["name"] = "El nombre no puede estar vacio";
     
    } else if (ctype_alpha($datosTrim["name"]) == false) {
      $errores["name"] = "El nombre debe contener solo letras";
    }
   
    if (strlen($datosTrim["lastname"]) == 0) {
      $errores["lastname"] = "El apellido no puede estar vacio";
    
    } else if (ctype_alpha($datosTrim["lastname"]) == false) {
      $errores["lastname"] = "El apellido debe contener solo letras";
    }
    
    if (strlen($datosTrim["email"]) == 0) {
      $errores["email"] = "El email no puede estar vacio";
    } else if (filter_var($datosTrim["email"], FILTER_VALIDATE_EMAIL) == false) {
      $errores["email"] = "El formato del email no es valido";
    } else if ($dbMysql->existeUsuario($datosTrim["email"])) {
      $errores["email"] = "El email ya esta registrado";
    }
    
    if (strlen($datos["pwd"]) == 0) {  
      $errores["pwd"] = "La contraseña no puede estar vacia";
    } else if ($datos["pwd"] !== $datos["retypepwd"]) { 
      $errores["pwd"] = "Las contraseñas no coinciden";
    }
         
    if (strlen($datosTrim["ciudad1"]) == 0) {
      $errores["ciudad1"] = "La primer ciudad no puede estar vacia";
    
    } else if (ctype_alpha($datosTrim["ciudad1"]) == false) {
      $errores["ciudad1"] = "La primer ciudad no debe contener numeros";
    }

    if (strlen($datosTrim["ciudad2"]) == 0) {
      $errores["ciudad2"] = "La segunda ciudad no puede estar vacia";
    
    } else if (ctype_alpha($datosTrim["ciudad2"]) == false) {
      $errores["ciudad2"] = "La segunda ciudad no debe contener numeros";
    }

    if (strlen($datosTrim["ciudad3"]) == 0) {
      $errores["ciudad3"] = "La tercera ciudad no puede estar vacia";
    
    } else if (ctype_alpha($datosTrim["ciudad3"]) == false) {
      $errores["ciudad3"] = "La tercera ciudad no debe contener numeros";
    }
    
    
    return $errores;
  }
  public static function validarLogin($datos)
  {
    global $dbMysql;
    $errores = [];
    $datosTrim = [];
    foreach ($datos as $posicion => $valor) {
      $datosTrim[$posicion] = trim($valor);
    }
    //EMAIL
    if (strlen($datosTrim["email"]) == 0) {
      $errores["email"] = "El email no puede estar vacio";
    } else if (filter_var($datosTrim["email"], FILTER_VALIDATE_EMAIL) == false) {
      $errores["email"] = "El formato del email no es valido";
    } else if (!$dbMysql->existeUsuario($datosTrim["email"])) {
      $errores["email"] = "El email no se encuentra registrado";
    }
    //Password
    if(strlen($datosTrim["pwd"]) == 0){
      $errores["pwd"] = "Campo obligatorio";
    } else {
      $usuario = $dbMysql->buscarPorEmail($datosTrim["email"]);
      if (password_verify($datosTrim["pwd"], $usuario->getPassword()) == false) {
      $errores["pwd"] = "Por favor verifique su contraseña.";
      }
    }
    return $errores;
  }
}
?>