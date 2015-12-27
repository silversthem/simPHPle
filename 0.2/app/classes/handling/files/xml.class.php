<?php
/* The xml class */
namespace handling\files;

class xml implements \Iterator,\ArrayAccess
{
  public $dom; // The DOMDocument object associated to the xml
  public $parent_dom = false; // If the current xml is a part of a document
  protected $filename; // the filename associated to the document
  protected $main_node_str; // the node containing all other
  public $main_node; // the DOMElement object
  protected $current_node; // the current node being read (Iterator)
  protected $id; // the item number (Iterator)
  protected $nodeList; // the list of nodes being read

  public function __construct() // creates a xml object
  {
    $this->dom = new \DOMDocument('1.0');
    $this->dom->formatOutput = true;
    $this->main_node = new \DOMElement('name');
    $this->current_node = new \DOMElement('name');
    $this->nodeList = new \DOMNodelist();
  }
  public function __toString() // displays the xml
  {
    return $this->main_node->C14N();
  }
  public function __set($key,$value) // sets the attribute $key to $value
  {
    $this->main_node->setAttribute($key,$value);
  }
  public function __get($key) // gets the value of the $key attribute
  {
    if($this->main_node->hasAttribute($key))
    {
      return $this->main_node->getAttribute($key);
    }
    return false;
  }
  public function getAttributes() // returns an associative array containing all the attributes
  {
    if($this->main_node->hasAttributes())
    {
      $attributes = $this->main_node->attributes;
      $a = array();
      foreach($attributes as $attr)
      {
        $a[$attr->name] = $attr->value;
      }
      return $a;
    }
    return false;
  }
  public function get_elements_by_attribute($attribute,$value = NULL) // search through the children of the main node and selects them by attribute
  {
    $nodes = $this->main_node->childNodes;
    $found = array();
    foreach($nodes as $node)
    {
      if(get_class($node) == 'DOMElement') // if $node is an xml element (not a comment or random text)
      {
        if($node->hasAttribute($attribute))
        {
          if(($value !== NULL && $node->getAttribute($attribute) == $value) || $value === NULL) // if we should test the $value and it matches
          {
            $found[] = $this->make_xml($node,$node->nodeName);
          }
        }
      }
    }
    if(count($found) == 1)
    {
      return $found[0];
    }
    return $found;
  }
  public function set_main_node($node) // sets the main node
  {
    $this->main_node_str = $node;
    $nodes = $this->dom->getElementsByTagName($node);
    if($nodes instanceof \DOMNodelist)
    {
      foreach($nodes as $node)
      {
        $this->main_node = $node;
      }
    }
  }
  public function set_main_node_str($str) // sets the main node name
  {
    $this->main_node_str = $str;
  }
  public function load($file) // loads a file
  {
    $this->filename = $file;
    if(file_exists($file))
    {
      $this->dom->load($file);
    }
  }
  public function load_str($str) // loads from a string
  {
    $this->dom->loadXML($str);
  }
  public function load_html($html) // loads from a html string
  {
    $this->dom->loadHTML($html);
  }
  public function load_html_page($page) // loads from a html page
  {
    $this->dom->loadHTMLFile($page);
  }
  public function save($file = false) // saves the xml in the file
  {

  }
  public function get_str($indent = 0) // get the xml as a string, $indent telling the initial indent
  {

  }
  public function set_filename($filename) // sets the file name used
  {
    $this->filename = $filename;
  }
  protected function inherit($object) // transfer the infos to a child
  {
    if($this->parent_dom == false) // original
    {
      $object->parent_dom = $this->dom;
    }
    else // part to part
    {
      $object->parent_dom = $this->parent_dom;
    }
    $object->set_filename($this->filename);
    return $object;
  }
  protected function quick_create($element,$main_node_str) // creates an xml from a DOMElement
  {
    $object = new \handling\files\xml();
    $object->main_node = $element;
    $object->set_main_node_str($main_node_str);
    return $object;
  }
  protected function make_xml($element,$main_node_str) // creates the xml to return
  {
    $object = $this->quick_create($element,$main_node_str);
    return $this->inherit($object);
  }
  /* Iterator methods */
  public function fetch($node) // creates the dom node list
  {
    $this->nodeList = $this->main_node->getElementsByTagName($node);
  }
  public function current() // the current node
  {
    $this->current_node = $this->nodeList->item($this->id);
    return $this->current_node;
  }
  public function key() // the node name
  {
    return $this->current_node->nodeName;
  }
  public function next() // next node
  {
    $this->id++;
  }
  public function rewind() // starts the foreach
  {
    $this->id = 0;
    $this->current_node = $this->nodeList->item(0);
  }
  public function valid() // if can keep going
  {
    if($this->id < $this->nodeList->length)
    {
      return true;
    }
    return false;
  }
  /* ArrayAccess methods */
  public function offsetGet($key) // read the element $key
  {
    $node = $this->main_node->getElementsByTagName($key);
    if($node->length == 1) // only one element
    {
      return $this->make_xml($node->item(0),$node->item(0)->nodeName);
    }
    elseif($node->length == 0) // nothing
    {
      return false;
    }
    else // creates an array of the xml elements
    {
      $nodes = array();
      foreach($node as $child)
      {
        $c = $this->make_xml($child,$child->nodeName);
        $nodes[] = $c;
      }
      return $nodes;
    }
  }
  public function offsetSet($key,$value) // sets the element $key with $value
  {

  }
  public function offsetExists($key) // if $key exists
  {

  }
  public function offsetUnset($key) // deletes the element $key
  {

  }
}
?>
