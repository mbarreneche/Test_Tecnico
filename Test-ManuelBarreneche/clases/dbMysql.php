<?php
require_once("db.php");
require_once("usuario.php");
class DbMySql extends db {
  protected $connection;
  public function __construct()
  {
   
    $dsn = "mysql:host=127.0.0.1;dbname=evaluacion_db;port=3306";
    $user = "root";
    $pass = "";
    try {
      $this->connection = new PDO($dsn, $user, $pass);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (\Exception $e) {
      echo $e->getMessage();
      exit;
    }
  }
  
  public function guardarUsuario(Usuario $usuario){
    $stmt = $this->connection->prepare("INSERT INTO usuarios VALUES(default, :name, :lastname, :email, :password, :ciudad1, :ciudad2, :ciudad3)");
    $stmt->bindValue(":name", $usuario->getName());
    $stmt->bindValue(":lastname", $usuario->getLastName());
    $stmt->bindValue(":email", $usuario->getEmail());
    $stmt->bindValue(":password", $usuario->getPassword());
    $stmt->bindValue(":ciudad1", $usuario->getCiudad1());
    $stmt->bindValue(":ciudad2", $usuario->getCiudad2());
    $stmt->bindValue(":ciudad3", $usuario->getCiudad3());
    $stmt->execute();
  }
  function buscarPorEmail($email) {
    /* global $db; */
    $stmt = $this->connection->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->bindValue(":email", $email);
    $stmt->execute();
    $consulta = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($consulta == false){
      return NULL;
    } else {
      $usuario = new Usuario($consulta);
      return $usuario;
    }
  }
  public function existeUsuario($email){
    return $this->buscarPorEmail($email) !== null;
  }
}