<?php
/* The index view */

class index
{
  use methods;

  protected $articles;
  protected $pages;
  protected $template;

  public function __construct()
  {
    $this->template = new \view\template('index');
    $this->template->title = 'Best website ever 10/10';
    $this->template->display = 'hello world !';
    $this->template->style = 'index.css';
  }
  public function exec()
  {
    echo $this->template->display();
  }
}
?>
