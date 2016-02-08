<?php
/*
*	simPHPle 0.4 result.trait.php : Trait
*	Handles results from multiple sources
*/

trait Result
{
	protected $results = array(); // the results

	protected $INCREMENT = 'increment';
	protected $END			 = 'end';
	protected $START		 = 'start';

	public function set_up($defaultkeys = array()) // creates a result array
	/* defaultkeys = defaults to fill the array easily */
	{
		foreach($defaultkeys as $pile)
		{
			$this->results[$pile] = array();
		}
	}
	public function result_exists($key) // test the existence of a result
	{
		return array_key_exists($key,$this->results);
	}
	public function get_result($key) // gets the result of something
	{
		if(array_key_exists($key,$this->results))
		{
			return $this->results[$key];
		}
		return false;
	}
	public function set_result($key,$value) // adds a result
	{
		$this->results[$key] = $value;
	}
	public function create_pile($pile,$array = array()) // creates a pile
	{
		$this->results[$pile] = $array;
	}
	public function merge_pile($pile,$array) // adds value from an array to a pile
	{
		if(array_key_exists($pile,$this->results))
		{
			if(is_array($array))
			{
				$this->results[$pile] = array_merge_recursive($this->results[$pile],$array);
			}
			else
			{
				$this->add_to_pile($pile,$array);
			}
		}
		else
		{
			$this->results[$pile] = $array;
		}
	}
	public function add_to_pile($pile,$value,$key = 'increment') // adds something to a pile
	{
		if(array_key_exists($pile,$this->results))
		{
			if($key == $this->INCREMENT)
			{
				$this->results[$pile][] = $value;
			}
			elseif($key == $this->END)
			{
				array_push($this->results[$pile],$value);
			}
			elseif($key == $this->START)
			{
				array_unshift($this->results[$pile],$value);
			}
			else
			{
				$this->results[$pile][$key] = $value;
			}
		}
		else // creating the pile
		{
			$this->results[$pile] = array();
			if($key == $this->INCREMENT || $key == $this->END || $key == $this->START)
			{
				$this->results[$pile][0] = $value;
			}
			else
			{
				$this->results[$pile][$key] = $value;
			}
		}
	}
	public function get_pile($pile) // returns result from a pile
	{
		return $this->get_result($pile);
	}
	public function get_pile_element($pile,$key) // gets a certain element from a pile
	{
		$pile = $this->get_pile($pile);
		if($pile !== false)
		{
			return (array_key_exists($key,$pile)) ? $pile[$key] : false;
		}
		return false;
	}
	public function delete($key) // deletes a result, or a pile
	{
		if($this->result_exists($key))
		{
			unset($this->results[$key]);
			return true;
		}
		return false;
	}
	public function unset_pile_element($pile,$key) // deletes an element from a pile
	{
		if(array_key_exists($pile,$this->results))
		{
			if(array_key_exists($key,$this->results[$pile]))
			{
				unset($this->results[$pile][$key]);
				return true;
			}
		}
		return false;
	}
	public function __get($r) // gets a result or a pile
	{
		return $this->get_result($r);
	}
	public function __set($r,$v) // sets a result or a pile
	{
		$this->set_result($r,$v);
	}
	public function get_results() // returns result array
	{
		return $this->results;
	}
	public function results_merge($other) // merges two results
	{
		if(is_object($other) && method_exists($other,'get_results'))
		{
			$r = $other->get_results();
			$this->results = array_merge_recursive($this->results,$r);
		}
		elseif(is_array($other))
		{
			$this->results = array_merge_recursive($this->results,$other);
		}
	}
}
?>
