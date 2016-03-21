<?php
/*
*	simPHPle 0.4 pattern.class.php : Class
*	A pattern for an url
*/

namespace handlers\routing;

class Pattern implements \IHandler
{
	public $handler; // loader handler
	protected $patterns = array(); // the pattern
	protected $get_options = array(); // options for the $_GET variables
	protected $loader; // loader created

	public function __construct($patterns = array()) // creates a pattern
	{
		$this->handler = new \Handler();
		$this->loader = new \Loader();
		if(is_array($patterns))
		{
			$this->patterns = $patterns;
		}
		else
		{
			$this->patterns[] = $patterns;
		}
	}
	public function set_get_option($get,$regex) // sets a regex type option for get variables
	{
		$this->get_options[$get] = $regex;
	}
	public function set_get_options($a) // sets get options from array
	{
		foreach($a as $get => $regex)
		{
			$this->set_get_option($get,$regex);
		}
	}
	public function add_pattern($p) // adds a pattern
	{
		$this->patterns[] = $p;
	}
	public function get_patterns() // returns patterns array
	{
		return $this->patterns;
	}
	public static function create($a,$name,$inPattern = false) // creates a pattern object from an array
	{
		if(is_string($a) && !$inPattern) // just a pattern
		{
			return new \Pattern($a);
		}
		elseif(is_string($a) && $inPattern)
		{
			return $a;
		}
		elseif(is_array($a)) // array
		{
			$pattern = new \Pattern();
			if(array_key_exists('get',$a)) // get options
			{
				$pattern->set_get_options($a['get']);
			}
			if(array_key_exists('pattern',$a)) // pattern
			{
				if(is_array($a['pattern'])) // array
				{
					foreach($a['pattern'] as $p)
					{
						$pattern->add_pattern(\Pattern::create($p,$name,true));
					}
				}
				elseif(is_string($a['pattern'])) // string
				{
					$pattern->add_pattern(\Pattern::create($a['pattern'],$name,true));
				}
			}
			if(array_key_exists('couple',$a)) // couple
			{
				$pattern->handler->set_default_loader(\Loaders\Module::create($a,$name,true));
			}
			return $pattern;
		}
	}
	public static function test($url,$pattern,$create_gets = true,$get_options = array()) // tests the pattern
	{
		if(preg_match_all('#\{(\w+)\}#isU',$pattern,$names,PREG_SET_ORDER)) // vars
		{
			$testpattern = preg_quote($pattern);
			$get_names = array(); // names for $_GET
			foreach($names as $name)
			{
				$testpattern = preg_replace('#'.preg_quote(preg_quote($name[0])).'#isU','(.+)',$testpattern);
				$get_names[] = $name[1];
			}
			if(preg_match_all('#^'.$testpattern.'$#isU',$url,$gets)) // testing if url matches
			{
				unset($gets[0]); // deleting first value
				if(count($gets) == count($get_names)) // same amount of gets and names
				{
					if($create_gets == false && count($get_options) == 0)
					{
						return true;
					}
					foreach($get_names as $k => $name)
					{
						$value = $gets[$k+1][0];
						if(array_key_exists($name,$get_options))
						{
							if(!preg_match('#^'.$get_options[$name].'$#isU',$value)) // get option not valid
							{
								return false;
							}
						}
						if($create_gets)
						{
							$_GET[$name] = $value;
						}
					}
					return true;
				}
			}
		}
		else
		{
			return ($url == $pattern);
		}
		return false;
	}
	public function valid($url,$create_gets = true) // if the pattern is valid
	{
		foreach($this->patterns as $pattern)
		{
			if(is_string($pattern)) // just a string
			{
				if(self::test($url,$pattern,$create_gets,$this->get_options)) // test passed
				{
					return true;
				}
			}
			elseif($pattern instanceof \Pattern)
			{
				if($pattern->valid($url,true)) // if pattern is valid
				{
					$this->loader->merge($pattern->get());
					return true;
				}
			}
		}
		return false;
	}
	public function get() // returns the loader for this pattern
	{
		$loader = $this->handler->get();
		$loader->merge($this->loader);
		return $loader;
	}
}
?>
