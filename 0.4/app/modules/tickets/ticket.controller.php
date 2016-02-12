<?php
/*
* Controller example
* Ticket controller
*/

class Ticket implements \app\IController
{
  protected $model;
  protected $view;

  public function __construct()
  {

  }
  public function init() // initializing, mandatory
  {
    $this->model = \models\Ticket(BASE_DIRECTORY.'storage/ticket.json');
    $this->view  = \views\Ticket(BASE_DIRECTORY.'app/assets/templates/skeleton.tpl');
  }
  protected function form() // returns associated event form
  {

  }
  public function onAdd() // when adding form is filled
  {
    // ... reads state of the event form
  }
  public function onEdit($id) // when editing form is filled
  {

  }
  public function onDelete($id) // when deleting something
  {

  }
  public function onShowTicket($id) // showing a specific ticket
  {

  }
  public function onShow($page = 1) // when showing a page
  {

  }
  public function exec() // default event
  {
    $this->onShow();
  }
}
?>
