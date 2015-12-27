<?php
/* Class handling templates */
class template
{
  protected $main; // main template file location
  protected $dir; // main templates dir (where other templates linked will be pulled)
  protected $xml; // the xmlDocument object (the template)
  protected $vars; // vars to replace in the template
  protected $html; // the generated html

  public function __construct($file,$dir) // creates a template object
  {
    $this->main = $file;
    $this->dir = $dir;
    $this->xml = new xmlDocument($file,'template');
  }
  public function add_vars($vars) // add vars
  {
    foreach($vars as $key => $element)
    {
      $this->vars[$key] = $element;
    }
  }
  public function set_vars($vars) // set vars
  {
    $this->vars = $vars;
  }
  public function get_var($var) // get a var
  {
    if(array_key_exists($var,$this->vars))
    {
      return $this->vars[$var];
    }
    else
    {
      return false;
    }
  }
  protected function add_line($line,$tab = 0) // add a line to the html page
  {
    if($tab == 0)
    {
      $t = '';
    }
    else
    {
      $t = '';
      for($i = 0;$i < $tab;$i++)
      {
        $t .= "\t";
      }
    }
    $this->html .= $t.$line."\n";
  }
  protected function replace_var($varname) // replace a var by it's value
  {
    if(substr($varname,0,1) == '[') // array
    {
      $varname = trim($varname,'[]');
      $array = explode('|',$varname);
      if(array_key_exists($array[0],$this->vars))
      {
        $name = $array[0];
        unset($array[0]);
        return $this->array_explore($array,$this->vars[$name]);
      }
    }
    else // simple var
    {
      if(array_key_exists($varname,$this->vars))
      {
        return $this->vars[$varname];
      }
    }
    return '';
  }
  public function replace_var_in_parsing($varname) // same but in the parsing
  {
    return $this->replace_var($varname[1]);
  }
  public function replace_constants_in_parsing($varname) // replace constants in parsing
  {
    if(defined($varname[1]))
    {
      return constant($varname[1]);
    }
  }
  protected function var_array_count($a) // counts the amount of elements in the array $this->vars[$a]
  {
    $b = explode('|',$a);
    if(array_key_exists($b[0],$this->vars))
    {
      $array = $this->vars[$b[0]];
      unset($b[0]);
      if(count($b) != 0)
      {
        $c = count($b);
        unset($b[$c-1]);
        foreach($b as $key)
        {
          $array = $this->vars[$key];
        }
        return count($array);
      }
      else
      {
        return count($array);
      }
    }
    return 'false';
  }
  protected function replace($a,$b,$c) // replace something by something else
  {
    return preg_replace('#'.preg_quote($a).'#isU',$b,$c);
  }
  protected function execute($code,$vars,$testcond,$else,$display) // executes the command with the given parameters
  {
    if($display == 'attribute') // do for attributes
    {
      if($vars[3] == 'loaded') // test if a module is loaded
      {
        if(module::is_loaded($vars[2]) && $vars[4] != 'none') // if the module is loaded
        {
          return $this->replace($vars[0],$vars[1].'="'.$vars[4].'"',$code);
        }
        else // if it's not
        {
          if($else)
          {
            return $this->replace($vars[0],$vars[5],$code);
          }
          return $this->replace($vars[0],'',$code);
        }
      }
      if($vars[3] == 'count') // count the elements in an array
      {
        if($testcond) // if comparing it to a number
        {

        }
        else // just testing array's existence
        {

        }
      }
      if($vars[3] == 'exists') // if the var exists
      {
        $var = $this->replace_var($vars[2]);
        if($var == '') // inexistant
        {
          if($else)
          {
            return $this->replace($vars[0],$var[5],$code);
          }
          else
          {
            return $this->replace($vars[0],'',$code);
          }
        }
        else // replace the thing by the var
        {
          return $this->replace($vars[0],$var,$code);
        }
      }
    }
    elseif($display == 'text') // do for text
    {
      if($vars[2] == 'loaded') // is the module is loaded
      {

      }
      elseif($vars[2] == 'count') // test the amount of elements in an array
      {
        if($testcond)
        {
          $var = $this->var_array_count($vars[1]);
          $func = create_function('','if('.$var.' '.$vars[3].'){return true;}return false;');
          $result = $func();
          if($result)
          {
            $final = $this->replace('[R]',$var,$vars[4]);
            return $this->replace($vars[0],$vars[4],$code);
          }
          else
          {
            if($else)
            {
              $final = $this->replace('[R]',$var,$vars[5]);
              return $this->replace($vars[0],$final,$code);
            }
            else
            {
              return $this->replace($vars[0],'',$code);
            }
          }
        }
      }
      elseif($vars[2] == 'foreach') // execute something for each element of an array
      {
        $var = $this->replace_var($vars[1]);
        if(is_array($var))
        {
          $c = '';
          foreach($var as $element)
          {
            $final = preg_replace('#\[R\]#isU',$element,$vars[3]);
            $final = preg_replace_callback('#\[([\w|\|]+)\]#',array($this,'replace_var_in_parsing'),$final);
            $final = preg_replace_callback('#\$(\w+)#',array($this,'replace_constants_in_parsing'),$final);
            $c .= $final;
          }
          return $this->replace($vars[0],$c,$code);
        }
      }
    }
    return $code;
  }
  protected function parse($code) // parse the template code
  {
    if(preg_match_all('#\{(GLOBALS|POST|GET)\[(.+)\]\}#isU',$code,$matches)) // if user wants to read a native array
    {
      foreach($matches[1] as $matches_id => $array_name)
      {
        $array_keys = explode('|',$matches[2][$matches_id]);
        if($array_name == 'GLOBALS')
        {
          $value = $this->array_explore($array_keys,$GLOBALS);
        }
        elseif($array_name == 'POST')
        {
          $value = $this->array_explore($array_keys,$_POST);
        }
        elseif($array_name == 'GET')
        {
          $value = $this->array_explore($array_keys,$_GET);
        }
        $code = preg_replace('#'.preg_quote($matches[0][$matches_id]).'#isU',$value,$code);
      }
    }
    if(preg_match_all('#(\w+)="([\w|\|]+)\.(\w+) \? (\w+) : (\w+)"#isU',$code,$matches,PREG_SET_ORDER)) // commands for attributes with else
    {
      foreach($matches as $vars)
      {
        $code = $this->execute($code,$vars,false,true,"attribute");
      }
    }
    if(preg_match_all('#(\w+)="([\w|\|]+)\.(\w+) \? (\w+)"#isU',$code,$matches,PREG_SET_ORDER)) // commands for attributes
    {
      foreach($matches as $vars)
      {
        $code = $this->execute($code,$vars,false,false,"attribute");
      }
    }
    if(preg_match_all('#(\w+)="([\w|\|]+)\.(\w+) (.*) \? (\w+) : (\w+)"#isU',$code,$matches,PREG_SET_ORDER)) // commands for attributes with condtion and else
    {
      foreach($matches as $vars)
      {
        $code = $this->execute($code,$vars,true,true,"attribute");
      }
    }
    if(preg_match_all('#(\w+)="([\w|\|]+)\.(\w+) (.*) \? (\w+)"#isU',$code,$matches,PREG_SET_ORDER)) // commands for attributes with condtion
    {
      foreach($matches as $vars)
      {
        $code = $this->execute($code,$vars,true,false,"attribute");
      }
    }
    if(preg_match_all('#\{\{([\w|\|]+)\}\.(\w+) \? (.+) : (.+)\}#isU',$code,$matches,PREG_SET_ORDER)) // commands for text with else
    {
      foreach($matches as $vars)
      {
        $code = $this->execute($code,$vars,false,true,"text");
      }
    }
    if(preg_match_all('#\{\{([\w|\|]+)\}\.(\w+) \? (.+)\}#isU',$code,$matches,PREG_SET_ORDER)) // commands for text
    {
      foreach($matches as $vars)
      {
        $code = $this->execute($code,$vars,false,false,"text");
      }
    }
    if(preg_match_all('#\{\{([\w|\|]+)\}\.(\w+) (.*) \? (.+) : (.+)\}#isU',$code,$matches,PREG_SET_ORDER)) // commands for text with else with condition
    {
      foreach($matches as $vars)
      {
        $code = $this->execute($code,$vars,true,true,"text");
      }
    }
    if(preg_match_all('#\{\{([\w|\|]+)\}\.(\w+) (.*) \? (.+)\}#isU',$code,$matches,PREG_SET_ORDER)) // commands for text with condition
    {
      foreach($matches as $vars)
      {
        $code = $this->execute($code,$vars,true,false,"text");
      }
    }
    if(preg_match_all('#\{\$(\w+)\}#isU',$code,$matches,PREG_SET_ORDER)) // constants
    {
      foreach($matches as $vars)
      {
        if(defined($vars[1]))
        {
          $code = preg_replace('#'.preg_quote($vars[0]).'#isU',constant($vars[1]),$code);
        }
        else
        {
          $code = preg_replace('#'.preg_quote($vars[0]).'#isU','',$code);
        }
      }
    }
    return $code;
  }
  protected function array_explore($keys,$array) // search through an array with $keys being also an array
  {
    $a = $array;
    foreach($keys as $key)
    {
      if(array_key_exists($key,$a))
      {
        $a = $a[$key];
      }
      else
      {
        return '';
      }
    }
    return $a;
  }
  public function display_with_vars($full_template,$html_id,$vars) // displays the template but sets the vars according to $vars
  {
    $this->vars = $vars;
    return $this->display($full_template,$html_id);
  }
  public function multiple_display($full_template,$html_id,$vars) // displays multiple times the template depending on $vars
  {
    $final = '';
    if(count($this->vars) != 0) // if vars is already full, executing it first
    {
      $final .= $this->display($full_template,$html_id)."\n";
    }
    foreach($vars as $var)
    {
      $this->vars = $var;
      $final .= $this->display($full_template,$html_id)."\n";
    }
    $final = trim($final);
    return $final;
  }
  public function display($full_template = true,$html_id = false) // display the template
  {
    $this->html = ''; // resets the html content, in case it's been used before
    if($html_id !== false) // if we have to load a specific html in the template
    {
      if($full_template)
      {
        $html = $this->xml->getElementById($html_id);
      }
      else
      {
        $html = $this->xml->getElementById($html_id)->firstChild();
      }
    }
    else
    {
      $html = $this->xml['html'];
    }
    if($full_template) // if the template creates a whole html page
    {
      $head = $html['head'];
      $title = $head->title;
      $css = $head->css;
      $charset = $head->charset;
      $this->add_line('<!DOCTYPE html>');
      $this->add_line('<html>');
      $this->add_line('<head>',1);
      if($charset != false)
      {
        $this->add_line('<meta charset="'.$charset.'"/>',2);
      }
      if($title != false)
      {
        $this->add_line('<title>'.$title.'</title>',2);
      }
      if($css != false)
      {
        $this->add_line('<link rel="StyleSheet" href="'.$css.'"/>',2);
      }
      $this->add_line('</head>',1);
      if(isset($html['body']))
      {
        $this->add_line("\t".$html['body']->value());
      }
      $this->add_line('</html>');
    }
    else // if the template only has a fraction of page to load
    {
      $this->html = $html->value();
    }
    $this->html = $this->parse($this->html);
    if(preg_match_all('#\{\{([\w|\[|\]|\|]+)\}\}#isU',$this->html,$matches,PREG_SET_ORDER)) // a var
    {
      foreach($matches as $match)
      {
        $this->html = preg_replace('#'.preg_quote($match[0]).'#isU',$this->replace_var($match[1]),$this->html);
      }
    }
    return $this->html;
  }
}
?>
