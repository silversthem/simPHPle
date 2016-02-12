<?php
/*
* Example model
* Ticket model
*/

namespace models;

class Ticket implements \app\IModel
{
  protected $file;
  protected $content;

  static $TICKETS_PER_PAGE = 20;

  public function __construct($file) // creates a ticket model
  {
    $this->file = $file;
  }
  public function init()
  {
    $this->content = Json::open($this->file);
    if($this->content == false)
    {
      die('Couldn\'t open ticket file');
    }
  }
  protected function exists($id)
  {

  }
  public function new($ticket)
  {

  }
  public function edit($id,$content)
  {

  }
  public function delete($id)
  {

  }
  public function get_page($page)
  {

  }
  public function get_ticket($id)
  {

  }
  public function save()
  {
    Json::save($this->file,$this->content);
  }
}
?>
