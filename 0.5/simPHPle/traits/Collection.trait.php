<?php
/*
  Trait
  Handles collections of datas in an array
  Can be used with ArrayAccessor
  Piles are arrays inside the collection
  It is not possible to put collections in collections, that's not what the class is for
  Even though it would work with something that implements ArrayAccess, but don't
  Used for options arrays and results
  Note : Don't use this when a database is clearly a better option, that's nasty
  Other note : This is a very inefficient way of handling datas that's not configuration or result of any sort
  Other Other note : There is no way to secure the data stored, that's not what this trait is for
*/

trait Collection
{
  protected $collection = array(); // Datas
  protected $addable = true; // if datas can be added
  protected $modifiable = true; // if datas can be written over

  public function set_up_collection(/* Default keys */) // sets up a collection, arguments can be supplied for default values
  {
    $args = func_get_args();
    foreach($args as $arg) // adding each argument to the collection
    {
      if(is_string($arg)) // simple key
      {
        $this->create($key);
      }
      elseif(is_array($arg)) // array of keys
      {
        $this->create_from_array($arg);
      }
    }
  }
  /* Permissions Settings */
  public function collection_addable($addable) // sets if collection is addable
  {
    $this->addable = $addable;
  }
  public function collection_modifiable($modifiable) // sets if collection is modifiable
  {
    $this->modifiable = $modifiable;
  }
  /* Creating */
  public function create($key,$default = NULL) // creates an element to be filled
  {
    $this->collection[$key] = $default;
  }
  public function create_from_array($array) // creates elements from array
  {
    foreach($array as $key => $value)
    {
      if(is_string($key)) // key is a string, it's the key and value the default data
      {
        $this->create($key,$value);
      }
      else // value is the key
      {
        $this->create($value);
      }
    }
  }
  public function create_pile($name,$pile = array()) // creates a new pile
  {
    $this->collection[$name] = $pile;
  }
  /* Adding */
  public function add($key,$element) // adds an element to a collection
  {
    $this->writable($key,true,'tried to add value in collection, but denied',array('attempted value' => $element));
    $this->collection[$key] = $element;
  }
  public function add_to_pile($pile,$element,$key = -1) // adds an element to a pile, -1 means increment
  {
    $k = ($key == -1) ? 'Last' : $k;
    $this->writable($pile,true,'tried to add to pile ',array('attempted value' => $element,'attempted position' => $k));
    if($key == -1) // incrementing
    {
      $this->collection[$pile][] = $element;
    }
    else // writing at an other position
    {
      $this->collection[$pile][$key] = $element;
    }
  }
  /* Setting */
  public function set($key,$value) // sets a value to key
  {
    $this->writable($pile,false,'tried to set a value in collection, but denied',array('attempted value' => $element));
    $this->collection[$key] = $value;
  }
  /* Getting */
  public function get_collection() // returns the collection
  {
    return $this->collection;
  }
  public function get($key) // gets a key or a pile
  {
    if($this->exists($key))
    {
      return $this->collection[$key];
    }
    else
    {
      $this->exception($key,'Trying to get non existant key in collection');
    }
  }
  public function get_from_pile($pile,$key) // gets a key from a pile
  {
    $pile_array = $this->get($key);
    if(array_key_exists($key,$pile_array))
    {
      return $pile_array[$key];
    }
    else
    {
      $this->exception($key,'Trying to get non existant key in pile',array('pile_key' => $key,'pile' => $pile));
    }
  }
  /* Deleting */
  public function delete($key) // deletes a key
  {

  }
  public function delete_from_pile($pile,$key) // deletes a key from a pile
  {
    
  }
  /* Operations */
  public function merge($collection,$replace = true,$add = true) // merges two collections together
  {

  }
  public function exists($key) // if keys exists
  {
    return array_key_exists($key,$this->collection);
  }
  public function is_writable($key,$adding = true) // can we write in key ? let's find out
  {
    if($this->addable) // if we can add things to the collection
    {
      return ($this->exists($key)) ? $this->modifiable : true; // if the key exists, the array has to be modifiable as well
    }
    return (!$adding) ? ($this->modifiable && $this->exists($key)) : false; // if we're not adding, we check if we can modify and if the key exists
  }
  public function exception($key,$err,$err_context = array(),$err_type = \fException::ERROR) // throw component exception
  {
    $context = array_merge(array(
      'class' => __CLASS__,'modifiable' => $this->modifiable,'addable' => $this->addable,'key' => $key,'key_exists' => $this->exists($key)),
    $err_context);
    throw new \fException('Collection Trait',$err,$err_context,$err_type);
  }
  public function writable($key,$adding,$err,$err_context,$err_type = \fException::ERROR) // checks if key is writable, and if not, throws exception
  {
    return (!$this->is_writable($key,$adding)) ? $this->exception($key,$err,$err_context,$err_type) : true;
  }
  /* Magic method */
  public function __get($key) // alias of get
  {

  }
  public function __set($key,$value) // alias of set and add
  {

  }
}
?>
