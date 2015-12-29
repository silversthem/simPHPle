<?php
/* The class used when making an entry in the log */

namespace handling\log;

class journal
{
  public static $log_dir;
  public static $store;

  const E_FRAMEWORK = 42;
  const INFO = 1337;

  public function __construct($log_dir,$store) // creates a journal
  {
    self::$log_dir = $log_dir;
    self::$store = $store;
  }
  public static function get_filename() // returns the filename for the day's log
  {
    $dir = date('Y/m');
    $dir = self::$log_dir.'/'.$dir;
    create_dirs($dir);
    $filename = $dir.'/'.date('d').'.log';
    if(!file_exists($filename))
    {
      file_put_contents($filename,'');
    }
    return $filename;
  }
  public static function write_error_message($type,$error,$file,$line,$context) // writes an error message
  {
    $nameType = '';
    switch($type) // converts the type into a string
    {
      case E_USER_ERROR:
        $nameType = 'PHP error :';
      break;
      case E_USER_WARNING:
        $nameType = 'Warning :';
      break;
      case E_USER_NOTICE:
        $nameType = 'Notice :';
      break;
      case journal::E_FRAMEWORK:
        $nameType = 'simPHPle error :';
      break;
      case journal::INFO:
        $nameType = 'Info :';
      break;
      default:
        $nameType = 'Unknown error :';
      break;
    }
    if(self::$store) // stores it
    {
      $file = journal::get_filename();
      if($line >= 0)
      {
        $content = '['.date('Y/m/d at H:i:s').'] '.$nameType.' (line:'.$line.', in file : '.$file.') '.$error;
      }
      else
      {
        $content = '['.date('Y/m/d at H:i:s').'] '.$nameType.' '.$error;
      }
      $lines = file($file);
      $lines[] = $content;
      $total = '';
      foreach($lines as $text)
      {
        if($text != "\n")
        {
          $text = rtrim($text,"\n");
          $total .= $text."\n";
        }
      }
      file_put_contents($file,$total);
    }
    else // shows it
    {
      // meh
    }
  }
  public static function write($message) // writes a message in today's log
  {
    self::write_error_message(journal::INFO,$message,-1,'');
  }
}
?>
