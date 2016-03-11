<?php
/*
  Class
  Handles files
*/

namespace handlers\files;

class File
{
  protected $filename; // file name
  protected $file; // the file ressource
  protected $method; // method the file is opened in

  use \Referencial; // makes the class great again
  use \ComponentException; // Handles object exception

  /* Methods */
  public function __construct($filename = NULL,$method = 'c+') // creates a new file object
  {
    $this->exception_set_up('File');
    $this->filename = $filename;
    $this->method = $method;
    if(!is_null($filename))
    {
      $this->ref_open($filename,$method);
    }
  }
  protected function ref_delete() // deletes filename
  {
    try
    {
      $this->ref_close();
    }
    finally
    {
      if(!unlink($this->filename))
      {
        $this->exception('Can\'t delete file',$file);
      }
    }
  }
  protected function apply_file_function($func,$args) // applies a function to the file ressource
  {
    if(is_callable($func))
    {
      return call_user_func_array($func,array_merge(array($this->file),$args));
    }
    else
    {
      $this->exception('Tried to call non file function in File class',array('function' => $func,'filename' => $this->filename));
    }
  }
  public function __call($method,$args) // when calling a non-existant method, either use referencial or try a f_method
  {
    try
    {
      $result = $this->referencial_call('ref_'.$method,$args); // trying referencial
    }
    catch(\fException $e) // can't, so trying f_method
    {
        $result = $this->apply_file_function('f'.$method,$args);
    }
    return $result;
  }
  public function read() // reads the file
  {
    $r = fread($this->file,filesize($this->file));
    if($r === false)
    {
      $this->exception('Couldn\'t read file',$this->filename);
    }
    return $r;
  }
  /* Referencial methods */
  protected function ref_open($filename,$method = 'c+') // opens a file
  {
    if(!($this->file = @fopen($filename,$method))) // trying to open the file
    {
      if(!file_exists($filename))
      {
        $this->exception('Tried to open file, but failed',$this->filename);
      }
    }
  }
  protected function ref_close() // closes the file
  {
    if(!fclose($this->file))
    {
      $this->exception('Tried to open file, but failed',$this->filename);
    }
  }
  protected function ref_write($content) // writes in the file from cursor
  {
    if(fwrite($this->file,$context) === false) // trying to write
    {
      $this->exception('Tried to write in file, but failed',$this->filename);
    }
  }
  protected function ref_seek($position,$whence = SEEK_SET) // puts elsewhere the internal file cursor
  {
    if(fseek($this->file,$position,$whence) == -1) // if it failed
    {
      $this->exception('Tried to seek cursor in file, but failed',$this->filename);
    }
  }
  protected function ref_prepend($content) // Tries to write at the beginning of the file
  {
    $tempfile = tempnam(dirname($this->filename),'');
    if(!@file_put_contents($tempfile,$content)) // trying to write in the temp file
    {
      $this->exception('Tried to write in temp file for prepend, but failed',$this->filename);
    }
    $this->ref_seek(0,SEEK_SET);
    file_put_contents($tempfile,$this->file,FILE_APPEND);
    chmod($tempfile,fileperms($this->filename));
    $this->ref_delete();
    rename($tempfile,$this->filename);
    $this->ref_open($this->filename,$this->method);
  }
  protected function ref_append($content) // Tries to write at the end of file
  {
    $this->ref_seek(0,SEEK_END);
    $this->ref_write($content);
  }
  /* Static methods */
  public static function ref_static_read($filename) // opens a file
  {
    if(!file_exists($filename) || !is_readable($filename)) // can't open file
    {
      throw new \fException('File',\fException::ERROR,'Tried to open non-existant file',$filename);
    }
    return file_get_contents($filename);
  }
  public static function ref_static_write($filename,$content,$mode,$cursor_position = 0) // writes in a file using classic c type options
  {
    if($handler = @fopen($filename,$mode))
    {
      fwrite($handler,$content);
      fclose($handler);
    }
    else // error
    {
      throw new \fException('File',\fException::ERROR,'Unable to write in file',$filename);
    }
  }
  public static function save($filename,$content) //saves content in a file
  {
    self::write($filename,$content,'w');
  }
  public static function ref_static_delete($filename) // deletes a file
  {
    if(!@unlink($filename)) // error while deleting
    {
      throw new \fException('File',\fException::ERROR,'Unable to delete file',$filename);
    }
  }
  public static function ref_static_append($filename,$content) // adds content at file's end
  {
    self::write($filename,$content,'a');
  }
  public static function ref_static_prepend($filename,$content) // adds content at file's beginning, without erasing previous content
  {
    $file = new \File($filename);
    $file->prepend($content)->close();
  }
}
?>
