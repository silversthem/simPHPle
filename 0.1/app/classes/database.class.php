<?php
/* Creates and use a sql database */
class database
{
  protected $pdo; // pdo object
  protected $connexion_infos = array('login' => '','password' => '','DSN' => '','options' => array()); // sql connexion infos and pdo object options

  public function __construct($dsn,$login,$password,$options = array()) // creates the object
  {

  }
}
?>
