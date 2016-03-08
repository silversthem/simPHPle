<?php
/*
  Static Class
  Handles files
*/

namespace handlers\files;

class File
{
  const END_FILE = -1; // custom cursor position in file : end file

  use \Referencial; // makes the class great again

  /* Methods */
  // @TODO Non static class use : optimisation
  /* Static methods */
  public static function read($filename) // opens a file
  {
    if(!file_exists($filename) || !is_readable($filename)) // can't open file
    {
      throw new \fException('File',\fException::ERROR,'Tried to open non-existant file',$filename);
    }
    return file_get_contents($filename);
  }
  public static function write($filename,$content,$mode,$cursor_position = 0) // writes in a file using classic c type options
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
  public static function delete($filename) // deletes a file
  {
    if(!@unlink($filename)) // error while deleting
    {
      throw new \fException('File',\fException::ERROR,'Unable to delete file',$filename);
    }
  }
  public static function append($filename,$content) // adds content at file's end
  {
    self::write($filename,$content,'a');
  }
  public static function prepend($filename,$content) // adds content at file's beginning, without erasing previous content
  {
    $context = stream_context_create();
    if($handler = @fopen($filename,'r',1,$context)) // creating a pointer to file we want to prepend
    {
      $tmp = tempnam(dirname($filename),''); // creating a temporary file
      if(@file_put_contents($tmp,$content)) // adding new content
      {
        file_put_contents($tmp,$handler,FILE_APPEND); // appending stream
        fclose($handler); // closing stream
        $perms = fileperms($filename); // conserving permissions
        self::delete($filename);
        rename($tmp,$filename); // replacing with new one
        chmod($filename,$perms);
      }
      else // Couldn't create temp file, error
      {
        throw new \fException('File',\fException::ERROR,'Unable to create temporary file,Can\'t prepend in file',$filename);
      }
    }
    elseif(!file_exists($content)) // file doesn't exist, so we just write the stuff
    {
      self::save($filename,$content);
    }
    else // error
    {
      throw new \fException('File',\fException::ERROR,'Can\'t prepend in file',$filename);
    }
  }
}
?>
