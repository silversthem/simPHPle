<?php
/*
* Example view
* Ticket view
*/

namespace views;

class Ticket implements \app\IView
{
  protected $template;

  public function __construct($template) // creates a ticket view
  {

  }
  public function init()
  {
    // loading template
  }
  public function print_ticket($ticket,$id)
  {
    // using template
  }
  public function print_tickets_page($tickets)
  {
    foreach($tickets as $id => $ticket)
    {
      $this->print_ticket($ticket,$id);
    }
  }
}
?>
