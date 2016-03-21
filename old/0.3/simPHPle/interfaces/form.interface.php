<?php
/* Methods all custom form controllers must have */

interface iform
{
  public function valid(); // checks if the form is valid
  public function get_result($case); // what to do when the form is valid
}
?>
