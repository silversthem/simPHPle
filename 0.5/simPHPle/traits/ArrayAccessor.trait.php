<?php
/*
  Trait
  This traits contains all the methods of the array interfaces :
  ArrayAccess and Iterator
  Just link your class array in the set_up method
*/

trait ArrayAccessor
{
  protected $var_array; // name of the array used
  protected $array_modifiable; // if the array is modifiable

  public function set_up_array(array &$array,$modifiable = true) // sets up the accessor
  {
    $this->var_array = &$array;
    $this->array_modifiable = $modifiable;
  }
  public function array_modifiable($modifiable) // sets if array is modifiable
  {
    $this->array_modifiable = $modifiable;
  }
  public function is_modifiable($errorContext = NULL) // checks if the array is modifiable, and throws an exception if errorContext isn't NULL
  {
    if(is_null($errorContext)) return $this->array_modifiable;
    if(!$this->array_modifiable)
    {
      throw new \fException('ArrayAccessor trait',\fException::ERROR,'tried to modify an non modifiable array',
        array('array' => $this->var_array,'class' => __CLASS__,'context' => $errorContext));
      return false;
    }
    else
    {
      return true;
    }
  }
  /* Iterator methods */
  public function current() // returns element currently being read
  {
    return current($this->var_array);
  }
  public function key() // returns current element key
  {
    return key($this->var_array);
  }
  public function next() // returns next element
  {
    next($this->var_array);
  }
  public function rewind() // puts internal array pointer back to start
  {
    reset($this->var_array);
  }
  public function valid() // checks if current element is valid
  {
    return $this->offsetExists($this->key());
  }
  /* Array access methods */
  public function offsetExists($key) // checks if key is in array
  {
    return array_key_exists($key,$this->var_array);
  }
  public function offsetGet($key) // returns value associated with key
  {
    if(!$this->offsetExists($key))
    {
      throw new \fException('ArrayAccessor trait',\fException::ERROR,'tried to call inexistant key in array',
        array('key' => $key,'array' => $this->var_array,'class' => __CLASS__));
    }
    return $this->var_array[$key];
  }
  public function offsetSet($key,$value) // trying to set a value in an array
  {
    if($this->is_modifiable(array('key' => $key,'old value' => ($this->offsetExists($key)) ? $this->var_array[$key] : NULL,
      'new value tried' => $value))) // if the array is modifiable, else context for exception is given
    {
      $this->var_array[$key] = $value;
    }
  }
  public function offsetUnset($key) // trying to delete key
  {
    if($this->is_modifiable(array('tried deleting key' => $key,'value' => ($this->offsetExists($key)) ? $this->var_array[$key] : NULL)))
    // if the array is modifiable, else context for exception is given
    {
      if($this->offsetExists($key)) unset($this->var_array[$key]);
      else throw new \fException('ArrayAccessor trait',\fException::ERROR,'tried to delete inexistant key in array',
        array('key' => $key,'array' => $this->var_array,'class' => __CLASS__));;
    }
  }
}
?>
