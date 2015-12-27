<?php
/* Handles a module */
class module
{
  protected $name; // module name
  protected $tampon = false; // if true,display returns the text. if false, display justs prints the text
  protected $template; // the template object
  protected $html_id = false; // template display function arg
  protected $full_template = true; // same
  protected $loop = false; // if the template has to be displayed more than one time
  protected $loopVars = array(); // the vars in the loop
  protected $loopFunc = false; // the function eventually used to process the array
  protected $loopContainer = ''; // the thing the loop will be in (!NOT YET IMPLEMENTED)

  const ALL = 1; // makes code clearer
  const DISPLAY = 2; // same
  const ANY = 3; // same
  const TEMPLATE = 4; // same

  public function __construct($name) // creates a module
  {
    $this->name = $name;
  }
  public static function is_loaded($module,$as_sub = false) // test if a module is loaded $as_sub checks for modules linked to the main one
  {
    if(!$as_sub)
    {
      if(array_key_exists($module,$GLOBALS['modules_loaded']))
      {
        return true;
      }
      return false;
    }
    foreach($GLOBALS['modules_loaded'] as $modname => $submods)
    {
      if($module == $modname)
      {
        return true;
      }
      elseif(is_array($mod))
      {
        foreach($mod as $sub_mod)
        {
          if($sub_mod == $module)
          {
            return true;
          }
        }
      }
    }
    return false;
  }
  public static function exists($name,$file = false) // returns true if a module exists, if $file is defined, tells if the file exists
  {
    if(!$file)
    {
      if(is_dir('app/modules/'.$name))
      {
        return true;
      }
    }
    else
    {
      if(file_exists('app/modules/'.$name.'/'.$file))
      {
        return true;
      }
    }
    return false;
  }
  public function send($module,$info = module::DISPLAY,$templateName = false) // send info to another module, $templateName allows it to directly be replaced in the template
  {
    if(!array_key_exists($module,$GLOBALS['requests'])) // if nothing has been sent to $module
    {
      $GLOBALS['requests'][$module] = array();
    }
    if($templateName !== false) // if it's a template thing
    {
      if($info == module::DISPLAY) // if the thing sent is the module displays
      {
        $GLOBALS['requests'][$module][] = array('type' => 'templateContent','var' => $templateName,'content' => $this->run_template());
      }
      else
      {
        $GLOBALS['requests'][$module][] = array('type' => 'templateContent','var' => $templateName,'content' => $info);
      }
    }
    else // it's something else
    {
      if($info == module::DISPLAY) // if the thing sent is the module displays
      {
        $GLOBALS['requests'][$module][] = array('type' => 'text','content' => $this->run_template());
      }
      else
      {
        $GLOBALS['requests'][$module][] = array('type' => 'text','content' => $info);
      }
    }
  }
  public function get($module = module::ANY) // get the info from a module
  {
    if(array_key_exists($this->name,$GLOBALS['requests'])) // if something was sent
    {
      $toReturn = array();
      foreach($GLOBALS['requests'][$this->name] as $sent)
      {
        if($sent['type'] == 'templateContent') // if it's something for the templates
        {
          $this->template->add_vars(array($sent['var'] => $sent['content'])); // we add the thing
        }
        else // something else
        {
          $toReturn[] = $sent;
        }
      }
      return $toReturn; // return everything that's not template related
    }
    else
    {
      return false; // nothing
    }
  }
  public function get_text() // enable the tampon
  {
    $this->tampon = true;
  }
  public static function call($modName,$defining_filename = false) // calls another module (! not a linked module !) $defining_filename just calls a file from the $modName directory
  {
    if(!$defining_filename)
    {
      $file = 'app/modules/'.$modName.'/index.php';
    }
    else
    {
      $file = 'app/modules/'.$modName.'/'.$defining_filename;
    }
    if(file_exists($file))
    {
      include $file;
    }
  }
  public function load_template($template_main_file,$vars = array(),$template_dir = false,$template_custom_commands = false) // set up the template(s)
  {
    if(!$template_dir)
    {
      $template_dir = dirname($template_main_file);
    }
    $this->template = new template($template_main_file,$template_dir);
    $this->template->set_vars($vars);
  }
  public function __set($name,$value) // sets values for the template
  {
    $this->template->add_vars(array($name => $value));
  }
  public function __get($name) // returns $name (in the template vars array)
  {
    return $this->template->get_var($name);
  }
  public function __call($method,$args) // calling a nonexistent method will call that method in the template class
  {
    if(method_exists($this->template,$method)) // if the method exists in the template class
    {
      $template = $this->template;
      $b = call_user_method_array($method,$template,$args);
      $this->template = $template;
      if($b !== NULL)
      {
        return $b;
      }
    }
  }
  public function loop($loopVars,$loopFunc = false,$loopContainer = '') // defines a loop
  {
    $this->loop = true;
    $this->loopVars = $loopVars;
    $this->loopFunc = $loopFunc;
    $this->loopContainer = $loopContainer;
  }
  public function stop_loop() // stops the loop
  {
    $this->loop = false;
  }
  public function set_template_arguments($full_template,$html_id) // sets the arguments for the template
  {
    $this->full_template = $full_template;
    $this->html_id = $html_id;
  }
  protected function run_template() // displays the template
  {
    $d = '';
    if($this->loop)
    {
      if($this->loopFunc == false) // no function the read the elements
      {
        $d = $this->template->multiple_display($this->full_template,$this->html_id,$this->loopVars);
      }
      else
      {
        foreach($this->loopVars as $vars)
        {
          $v = call_user_func($this->loopFunc,$vars);
          $d .= $this->template->display_with_vars($this->full_template,$this->html_id,$v);
        }
      }
    }
    else
    {
      $d = $this->template->display($this->full_template,$this->html_id);
    }
    return $d;
  }
  public function run() // runs the module
  {
    if($this->tampon == true)
    {
      return $this->run_template();
    }
    else
    {
      echo $this->run_template();
    }
  }
}
?>
