<?php
class Usuario {
  protected $id;
  protected $name;
  protected $lastname;
  protected $email; 
  protected $password;
  protected $ciudad1;
  protected $ciudad2;
  protected $ciudad3;
  function __construct(Array $datos){
    if(isset($datos["id"])){
      $this->id = $datos["id"];
      $this->password = $datos["password"];
    } else {
      $this->id = NULL;
      $this->password = password_hash($datos["pwd"], PASSWORD_DEFAULT);
    }
    $this->name = $datos["name"];
    $this->lastname = $datos["lastname"];
    $this->email = $datos["email"];
    $this->ciudad1 = $datos["ciudad1"];
    $this->ciudad2 = $datos["ciudad2"];
    $this->ciudad3 = $datos["ciudad3"];
  }
  public function getId(){
    return $this->id;
  }
  public function getName(){
    return $this->name;
  }
  public function getLastName(){
    return $this->lastname;
  }
  public function getEmail(){
    return $this->email;
  }
  public function getPassword(){
    return $this->password;
  }
  public function getCiudad1(){
    return $this->ciudad1;
  }
  public function getCiudad2(){
    return $this->ciudad2;
  }
  public function getCiudad3(){
    return $this->ciudad3;
  }
  public function setId($id){
    $this->id=$id;
    return $this;
  }
  public function setName($name){
    $this->name=$name;
    return $this;
  }
  public function setLastName($lastname){
    $this->lastname=$lastname;
    return $this;
  }
  public function setEmail($email){
    $this->email=$email;
    return $this;
  }
  public function setPassword($password){
    $this->password=$password;
    return $this;
  }
  public function setCiudad1($ciudad1){
    $this->ciudad1=$ciudad1;
    return $this;
  }
  public function setCiudad2($ciudad2){
    $this->ciudad2=$ciudad2;
    return $this;
  }
  public function setCiudad3($ciudad3){
    $this->ciudad3=$ciudad3;
    return $this;
  }
}
?>