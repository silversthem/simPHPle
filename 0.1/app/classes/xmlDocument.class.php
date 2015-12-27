<?php
/* Handles a xml/html type of document */
function parse_with_tabs($t) // parse a node with tabs before showing it as a string
{
  $count = ceil(count(explode(' ',$t[1]))/2);
  $count--;
  $r = "\n";
  for($i = 0;$i < $count;$i++)
  {
    $r .= "\t";
  }
  $r .= $t[2];
  return $r;
}
class xmlDocument implements ArrayAccess,Iterator
{
  protected $filename; // the name of the xml/html file
  protected $dom; // dom object
  protected $main_node; // the main node, the one containing all others
  protected $main_node_str; // useful to change nodes later
  protected $has_parents = false; // if the xmlDocument is the root or isn't
  protected $xmlDocument_parent = NULL; // the root object
  protected $node_index = 0; // key for using foreach
  protected $currentNode; // current node (foreach)

  const DEFAULT_FILENAME = 1; // to make code clearer

  public function __construct($file = false,$main_node = false) // creates the object
  {
    $this->dom = new DOMDocument('1.0');
    if($file != false)
    {
      $this->filename = $file;
      $this->dom->load($file);
      if($main_node != false)
      {
        $this->main_node($main_node);
      }
    }
  }
  public function main_node($main_node) // sets the main node
  {
    $m = $this->dom->getElementsByTagName($main_node);
    $this->main_node = $m->item(0);
    $this->main_node_str = $main_node;
  }
  public function getAttributes() // returns the node's attributes
  {
    $a = array();
    $attributes = $this->main_node->attributes;
    foreach($attributes as $k => $attribute)
    {
      $a[$k] = $attribute->nodeValue;
    }
    return $a;
  }
  /* Interfaces methods */
  public function offsetExists($node) // if node exists
  {
    $nodes = $this->main_node->childNodes;
    if($nodes->length != 0)
    {
      foreach($nodes as $child)
      {
        if($child->nodeName == $node)
        {
          return true;
        }
      }
    }
  }
  public function offsetGet($node) // returns $node or all the nodes $node
  {
    $nodes = $this->main_node->childNodes;
    $correspondingNodes = array();
    if($nodes->length != 0)
    {
      foreach($nodes as $child)
      {
        if($child->nodeName == $node)
        {
          $d = new xmlDocument();
          $d->load_from_node($child,$this->dom);
          $d->main_node($node);
          $correspondingNodes[] = $d;
        }
      }
    }
    if(count($correspondingNodes) == 1) // if there's only one node $node
    {
        return $correspondingNodes[0];
    }
    else // if there's a bunch of nodes, returning an array of nodes $node
    {
      return $correspondingNodes;
    }
  }
  public function offsetSet($node,$value) // sets $node to $value
  {
    $nodes = $this->main_node->childNodes;
    if($nodes->length != 0)
    {
      foreach($nodes as $child)
      {
        if($child->nodeName == $node)
        {
          $child->nodeValue = $value;
        }
      }
    }
    else
    {
      $this->main_node->nodeValue = $value;
    }
  }
  public function offsetUnset($node) // deletes $node
  {
    $nodes = $this->dom->getElementsByTagName($node);
    foreach($nodes as $child)
    {
      $child->removeChild($child->firstChild);
    }
  }
  /* Iterator related methods */
  public function test()
  {
    var_dump($this->dom->C14N());
  }
  public function current() // current element
  {
    $this->currentNode  = $this->main_node->childNodes->item($this->node_index);
    $d = new xmlDocument();
    $d->load_from_node($this->currentNode,$this->dom);
    $d->main_node($this->currentNode->nodeName);
    return $d;
  }
  public function key() // current key (node name)
  {
    return $this->currentNode->nodeName;
  }
  public function next() // go forward
  {
    $this->node_index++;
  }
  public function rewind() // go back to start
  {
    $this->node_index = 0;
  }
  public function valid() // checking before reading
  {
    if($this->node_index < $this->main_node->childNodes->length)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  /* Regular methods */
  public function __set($attr,$value) // set the attribute $attr to $value
  {
    $this->main_node->setAttribute($attr,$value);
  }
  public function __get($attr) // get the attribute $attr if it exists
  {
    if($this->main_node->hasAttribute($attr))
    {
      return $this->main_node->getAttribute($attr);
    }
    else
    {
      return false;
    }
  }
  public function firstChild() // returns the first child of the node
  {
    $d = $this->main_node->childNodes;
    if($d->length == 1) // if there's only one node
    {
      return $d->item(0);
    }
    foreach($d as $node)
    {
      if($node->nodeName != '#text' && $node->nodeName != '#comment')
      {
        $b = new xmlDocument();
        $b->load_from_node($node,$this->dom);
        $b->main_node($node->nodeName);
        return $b;
      }
    }
  }
  public function value() // shows the textcontent of the node
  {
    $value = $this->main_node->C14N();
    $value = preg_replace_callback('#\\n( +)(\S)#isU','parse_with_tabs',$value);
    return $value;
  }
  public function getElementById($id) // finds a child with the id selected
  {
    $children = $this->main_node->childNodes;
    foreach($children as $node)
    {
      if($node->nodeName != '#text' && $node->nodeName != '#comment') // if it's not just text
      {
        if($node->hasAttribute('id'))
        {
          if($node->getAttribute('id') == $id)
          {
            $d = new xmlDocument();
            $d->load_from_node($node,$this->dom);
            $d->main_node($node->nodeName);
            return $d;
          }
        }
      }
    }
  }
  public function __toString() // same as the value() function
  {
    return $this->value();
  }
  public function __call($name,$args) // when user calls a function that doesn't exist
  {
    if(method_exists($this->dom,$name)) // if the method exists in the DOMDocument class
    {
      $a = '';
      foreach($args as $arg)
      {
        $a .= $arg.',';
      }
      $a = rtrim($a,',');
      eval('$b = $this->dom->'.$name.'('.$a.');');
      if($b !== NULL)
      {
        return $b;
      }
    }
    elseif(method_exists('DOMElement',$name))
    {

    }
  }
  public function open($filename) // opens a file
  {

  }
  public function load($content) // loads xml/html content
  {

  }
  public function load_from_node($node,$xmlDoc = false) // load from a single node
  {
    $this->dom->loadXML($node->C14N());
    if($xmlDoc != false)
    {
      $this->has_parents = true;
      $this->xmlDocument_parent = $xmlDoc;
    }
  }
  public function save($filename = xmlDocument::DEFAULT_FILENAME) // saves the file
  {

  }
}
?>
