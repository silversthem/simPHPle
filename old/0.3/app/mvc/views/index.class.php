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
    $this->template->style = 'index.css';
  }
  public function exec()
  {
    $m = $GLOBALS['index']->model('article');
    $this->template->display = $m['getLastArticles'] . ' This is page number : ' .$m['getPageAmount'];
    echo $this->template->display();
  }
}
?>
