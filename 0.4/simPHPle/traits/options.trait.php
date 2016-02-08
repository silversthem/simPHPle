<?php
/*
*	simPHPle 0.4 options.trait.php : Trait
*	Handles options in array
*/

trait Options
{
	protected $options = array(); // options

	public function create_options($options) // sets up options
	{
		if(is_array($options))
		{
			foreach($options as $key => $option)
			{
				if(is_string($key))
				{
					$this->set_option($key,$option);
				}
				else
				{
					$this->create_option($key);
				}
			}
		}
		elseif(is_string($options)) // only one option
		{
			$this->create_option($options);
		}
	}
	public function create_option($option) // creates an empty option
	{
		$this->options[$option] = NULL;
	}
	public function set_option($option,$value) // sets an option
	{
		$this->options[$option] = $value;
	}
	public function get_option($option) // gets an option, if existing
	{
		if($this->option_exists($option))
		{
			return $this->options[$option];
		}
	}
	public function option_exists($option) // if an option exists
	{
		return array_key_exists($option,$this->options);
	}
	public function delete_option($option) // deletes an option
	{
		if($this->option_exists($option))
		{
			unset($this->options[$option]);
		}
	}
	public function get_options() // returns options array
	{
		return $this->options;
	}
	public function get_options_keys() // returns all options available
	{
		return array_keys($this->options);
	}
	protected function merge_options_array($a,$replace) // merges options array
	{
		foreach($a as $option => $value)
		{
			if(!$replace) // no replacing of existing values
			{
				if(!$this->option_exists($option) || is_null($this->options[$option]))
				{
					$this->options[$option] = $value;
				}
				elseif(is_array($this->options[$option]))
				{
					$this->options[$option] = array_merge_recursive($this->options[$option],$value);
				}
			}
			else // replacing
			{
				$this->options[$option] = $value;
			}
		}
	}
	public function merge_options($options,$replace = true) // merges options
	{
		if(is_array($options))
		{
			$this->merge_options_array($options,$replace);
		}
		elseif(is_object($options) && method_exists($options,'get_options'))
		{
			$this->merge_options_array($options->get_options(),$replace);
		}
	}
}
?>
