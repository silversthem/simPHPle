<?php
/* a basic parser */

namespace view;

class parser
{
  protected $template; // the template linked to the parser

  public function __construct() // creates a parser
  {

  }
  public function set_template($template) // sets the template
  {
    $this->template = $template;
  }
  protected function replace_var($var) // replaces a var
  {
    if(preg_match('#^\w+$#',$var)) // a simple text var
    {
      $r = $this->template->get_var($var);
      if($r !== false)
      {
        return $r;
      }
    }
    return ''; // if there's nothing, we just erase the var
  }
  protected function replace_command($command,$var) // replaces a command
  {
    return ''; // if there's nothing, we just erase the var
  }
  public function parse($content) // parses the content
  {
    if(preg_match_all('#\{\{(.+)\}\}#isU',$content,$matches,PREG_SET_ORDER)) // vars
    {
      foreach($matches as $match)
      {
        $content = preg_replace('#'.preg_quote($match[0]).'#isU',$this->replace_var($match[1]),$content);
      }
    }
    if(preg_match_all('#\{(\w+)\{(.+)\}\}#isU',$content,$matches,PREG_SET_ORDER)) // command
    {
      foreach($matches as $match)
      {
        $content = preg_replace('#'.preg_quote($match[0]).'#isU',$this->replace_command($match[1],$match[2]),$content);
      }
    }
    return $content;
  }
}
?>
