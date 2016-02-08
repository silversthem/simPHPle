<?php
/*
*	simPHPle 0.4 journal.class.php : Class
*	Handles errors in your app : showing them (development) or storing them (production)
*/

namespace handlers;

class Journal
{
	public static $mode; // the mode, production/development
	public static $dir; // the dir where to write the log, if in development
	public static $production_error_handler = NULL; // a function that does something in case of fatal error
	public static $developmentLinesShown = 4; // In developpement, shows x lines before and after the error
	public static $showWarnings = true; // show warnings in developpement
	public static $showNotices  = true; // show notices in developpement

	const FRAMEWORK_FATAL_ERROR = "Framework fatal error"; // when something goes wrong in the framework
	const FRAMEWORK_WARNING 	  = "Framework warning"; // something that works but shouldn't be done
	const FRAMEWORK_ERROR 			= "Framework error"; // an error that doesn't make the framework crash
	const FRAMEWORK_NOTICE 			= "Info"; // framework info

	public function __construct($mode,$dir)
	{
		self::$mode = $mode;
		self::$dir = $dir;
	}
	public static function write($message) // writes a message in the log
	{
		$file = self::get_filename();
		try
		{
			create_dirs_recursively(dirname($file));
		}
		catch(Exception $e)
		{
			self::exception_catcher($e,true);
		}
		try
		{
			Json::add($file,$message);
		}
		catch(Exception $e)
		{
			self::exception_catcher($e,true);
		}
	}
	public static function parseColor($content) // basic parsing for lines error
	{
		// @TODO better parser
		$content = preg_replace(array(
			"#\".+\"#isU","#'.+'#isU"
		),'<span style="color:rgb(100,160,100);">$0</span>',$content);
		$content = preg_replace('#\$\w+#is','<span style="color:blue;">$0</span>',$content);
		$content = preg_replace(
			array('#public#','#include#','#function#','#static#','#protected#','#private#')
			,'<span style="color:rgb(255,60,0);">$0</span>',$content);
			$content = preg_replace(
				array('#class#','#interface#','#trait#','#namespace#'),'<span style="color:rgb(200,60,100);">$0</span>',$content);
			$content = preg_replace(
				array('#'.preg_quote(htmlspecialchars('<')).'\?php#','#\?'.preg_quote(htmlspecialchars('>')).'#')
				,'<span style="background-color:yellow;">$0</span>',$content);
		return $content;
	}
	public static function displayCode($start,$end,$lines,$line) // displays the code
	{
		$text = '';
		for($i = $start;$i < $end;$i++)
		{
			$displayId = $i + 1;
			if($displayId == $line) // actual error line
			{
				$text .= '<span style="color:white;background-color:red;">'.$displayId.'. '.htmlspecialchars($lines[$i])."</span>\n";
			}
			else
			{
				$text .= $displayId.'. '.self::parseColor(htmlspecialchars($lines[$i]))."\n";
			}
		}
		return $text;
	}
	public static function cell($a,$b) // creates a cell for display
	/* a = first cell element
	 	 b = second cell element */
	{
		$style = 'border:1px solid black;padding:5px;';
		return '<tr><td style="'.$style.'"><b>'.$a.'</b></td><td style="'.$style.'">'.$b.'</td></tr>';
	}
	public static function display($type,$content,$file,$line,$context) // displays an error, in a cool, development friendly way
	{
		if(($type == 'Warning' && self::$showWarnings == false) || ($type == 'Notice' && self::$showNotices == false)) // not showing the error for some reason
			return NULL; // not doing anything
		echo '<table style="border-collapse:collapse;margin:10px;">';
		echo self::cell($type.' :',$content);
		if($file !== NULL)
		{
			echo self::cell('File :',$file);
		}
		if($line !== NULL)
		{
			echo self::cell('Line :',$line);
		}
		if($context !== NULL)
		{
			// @TODO handling context
			echo self::cell('Context :',$context);
		}
		if(file_exists($file)) // opens a file view to see debug
		{
			$lines = file($file);
			$text = '<pre>';
			$testStartLine = self::$developmentLinesShown + 1;
			if($line < $testStartLine) // printing all lines from the start
			{
				$printingLines = $line + self::$developmentLinesShown;
				if($printingLines >= count($lines)) // number of lines inferior to number of line method should print
					$printingLines = count($lines); // printing everything until the end
				$text .= self::displayCode(0,$printingLines,$lines,$line);
			}
			else
			{
				$maxNormalLine = count($lines) - self::$developmentLinesShown;
				if($line >= $maxNormalLine) // more line to print than the last line
				{
					$printingLines = count($lines);
					$startingLine = $line - self::$developmentLinesShown - 1;
					if($startingLine < 0) $startingLine = 0; // negative starting line will be set to one
					$text .= self::displayCode($startingLine,$printingLines,$lines,$line);
				}
				else // normal case
				{
					$startingLine = $line - self::$developmentLinesShown - 1;
					$endindLine = $line + self::$developmentLinesShown;
					$text .= self::displayCode($startingLine,$endindLine,$lines,$line);
				}
			}
			$text .= '</pre>';
			echo self::cell("Code :",$text);
		}
		echo '</table>';
	}
	public static function exception_catcher($exception,$cantSave = false) // handles uncaught exceptions
	/* cantSave = We tried to write something in the log, didn't work */
	{
		if(self::$mode == 'DEVELOPMENT' || $cantSave === true)
		{
			die('<b>Uncaught exception : </b>'.$exception->getMessage());
		}
		else
		{
			self::error(E_USER_WARNING,'Uncaught exception : '.$exeption->getMessage(),$exeption->getFile(),$exeption->getLine(),$exeption->getCode());
		}
	}
	public static function get_filename() // if in production, gets the file of the day's log
	{
		return self::$dir.'/'.date('Y/m/d').'.json';
	}
	public static function error($errorType,$errorContent,$errorFile = NULL,$errorLine = NULL,$errorContext = NULL) // handles a php error
	{
		$typeText = 'Unknown error';
		switch($errorType)
		{
			case E_USER_ERROR:
				$typeText = 'Fatal error';
			break;
			case E_USER_WARNING:
				$typeText = 'Warning';
			break;
			case E_USER_NOTICE:
				$typeText = 'Notice';
			break;
			default:
				$typeText = $errorType;
			break;
		}
		if(self::$mode == 'DEVELOPMENT') // development = showing the error
		{
			// @TODO handling context
			self::display($typeText,$errorContent,$errorFile,$errorLine,NULL);
		}
		else // production
		{
			if(LOG) // storing it
			{
				$time = date('H:i:s');
				if($errorFile === NULL) // no arguments after the second one
				{
					Journal::write('['.$time.'] '.$typeText. ' : '.$errorContent);
				}
			else
				{
					Journal::write('['.$time.'] '.$typeText. ' : '.$errorContent.' | (in File '.$errorFile.' , Line : '.$errorLine.')');
				}
			}
			else
			{
				if(is_callable(self::$production_error_handler))
				{
					self::$production_error_handler();
				}
			}
		}
	}
}
?>
