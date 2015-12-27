<?php
/* The parser specific to html elements */
namespace view\html;

class parser
{
  public $template; // the template, where to pull the vars from
  protected $infos = array(); // things like specific actions to do

  public function __construct($template) // creates a parser
  {
    $this->template = $template;
  }
  public function parse($content) // parses it
  {
    $content = $this->template->parse($content); // regular parser first
    // html specifics
    if(preg_match_all('#makeurl\((.+)\)#isU',$content,$matches,PREG_SET_ORDER)) // make an url
    {
      if(defined('BASE_DIRECTORY')) // if base directory is defined
      {
        foreach($matches as $match)
        {
          $content = preg_replace('#'.preg_quote($match[0]).'#isU','/'.BASE_DIRECTORY.$match[1],$content);
        }
      }
    }
    return $content;
  }
}
?>
