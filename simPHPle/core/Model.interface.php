<?php
/*

*/

namespace core;

interface Model {
  /* Data access */
  public function data(); // Returns data
  public function key(); // Model key (identifier)
  /* Data manipulation */
  public function set($data); // Sets data
  /* Model manipulation */
  public function read($key); // Loads model content from identifier
  public function write(); // Saves model permanently
  public function delete(); // Deletes model permanently
}
