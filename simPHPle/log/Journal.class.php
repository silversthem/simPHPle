<?php

namespace Log;

class Journal {
  public $format_functions = ['message' => NULL,'exception' => NULL];
  public $write_function;
  public $state_functions = ['init' => NULL,'end' => NULL];

  protected $logged = [];

  public function __construct($write_function = NULL,$message_func = '\Log\Journal::format',$e_func = '\Log\Journal::format_exception') { // Creates a journal
    $this->format_functions = ['message' => $message_func,'exception' => $e_func];
    if(is_null($write_function)) {
      $this->write_function = function($message) {
        print $message;
      };
    } else {
      $this->write_function = $write_function;
    }
    $this->state_functions = [
        'init' => function() {
          return \Log\Journal::format('Started logging');
        },
        'end' => function() {
          return \Log\Journal::format('End of sesion')."\n".str_repeat('-',10)."\n";
        }
      ];
  }
  public function __destruct() { // End of execution, or at least end of logging
    if(!empty($this->logged)) {
      call_user_func_array($this->write_function,[$this->logged]);
    }
  }
  public function log($message) { // use this function to log a message
    $this->logged[] = $this->format_functions['message']($message);
  }
  public function catch_exception($exception) { // Catches an uncaught exception
    $this->logged[] = $this->format_functions['exception']($exception);
  }
  /* Default functions */
  public static function format_exception($e) { // Formats an exception
    return self::format(' [EXCEPTION !] '.$e);
  }
  public static function format($message) { // Formats a message to log it
    return '['.date('d/m/Y at H:i:s').'] - '.$message;
  }
  public static function write_in_file($file) { // Writes a message at the end of a file
    return function($logged = []) use($file) {
      $f = fopen($file,'a+');
      fwrite($f,"\n".join("\n",$logged));
      fclose($f);
    };
  }
  public static function write_in_dir($dir) { // Creates a file and writes in it
    $file = $dir.'/log-'.date('Y-m-d').'.txt';
    return self::write_in_file($file);
  }
}
