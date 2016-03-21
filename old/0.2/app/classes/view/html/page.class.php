<?php
/* A html page */
namespace view\html;

class page
{
  public $template; // the template
  public $parser; // the html parser object

  const TAB = "    "; // tab used to indent

  public function __construct($template) // constructs an html page
  {
    $this->template = $template;
    $this->parser = new \view\html\parser($template);
  }
  protected function makeHead($element) // creates the header from the <head/> in the template
  {
    $c = '<head>'."\n";
    if($element->charset != false) // sets charset
    {
      $c .= page::TAB.'<meta charset="'.$element->charset.'"/>'."\n";
    }
    if($element->title != false) // sets page title
    {
      $c .= page::TAB.'<title>'.$element->title.'</title>'."\n";
    }
    if($element->css != false) // sets css
    {
      $c .= page::TAB.'<link rel="StyleSheet" href="'.$element->css.'"/>'."\n";
    }
    $c .= '</head>'."\n";
    return $c;
  }
  public static function compress($content) // compress $content (removes useless spaces and endlines between nodes)
  {

  }
  public function display() // displays the html page
  {
    $c = '<!DOCTYPE html>'."\n";
    $c .= '<html>'."\n";
    $head = $this->template->xml['head'];
    if($head !== false)
    {
      $c .= $this->makeHead($head);
    }
    else
    {
      // warning, no head found
    }
    $body = $this->template->xml['body'];
    if($body !== false)
    {
      $c .= page::TAB.$this->parser->parse($body)."\n";
    }
    else
    {
      // warning, no body found
    }
    $c .= '</html>';
    $c = $this->parser->parse($c);
    return $c;
  }
}
?>
