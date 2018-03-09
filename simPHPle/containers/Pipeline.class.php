<?php
/*

*/

namespace containers;

class Pipeline {
  /* Attributes */
  protected $callables;
  protected $input;
  protected $output;
  /* Run time */
  protected $current;
  protected $over;

  public function __construct($input = NULL,...$callables) { // Creating a pipeline
    $this->input = $input;
    $this->callables = $callables;
  }
  public function add(...$callables) { // Adds a callable at the end of the pipeline
    $this->insert(-1,...$callables);
  }
  public function push(...$callables) { // Adds a callable at the beginning of the pipeline
    $this->insert(0,...$callables);
  }
  public function insert($position,...$callables) { // Pushes a function into the pipeline
    $len = count($callables);
    $position = ($position >= 0) ? $position : $len - $position;
    $this->callables[] = array_slice(0,$position) + $callable + array_slice($position,$len);
  }
  protected function run_call($call,&$input) { // Runs callable
    if(!is_callable($call)) {
      // @TODO Exception
    }
    if(!is_null($input)) {
      $input = (is_array($input)) ? $call(...$input) : $call($input);
    } else {
      $input = $call();
    }
  }
  private function caught($exception) { // Private function to handle base class exception case (from : run_call)
    // @TODO There should definetly be something here
    return $this->early_exit($exception);
  }
  protected function early_exit($exception) { // Called when exited through an exception --- Override when necessary ;)

  }
  public function run() { // Runs pipeline
    $input = $this->input;
    try {
      foreach($this->callables as $call) {
        $this->run_call($call,$input);
      }
    } catch (\Exception $exception) {
      $this->caught($exception);
    }
  }
  public function __invoke() { // alias of run, allows the pipeline to be a callable

  }
}
