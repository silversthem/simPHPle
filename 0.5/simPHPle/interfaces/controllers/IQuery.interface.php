<?php
/*
  Interface
  A query is a retrieval of information
  Usually just calling a method from the model
*/

namespace controllers;

interface IQuery extends \IHandler
{
  public function error(); // If there's something wrong with the query
}
?>
