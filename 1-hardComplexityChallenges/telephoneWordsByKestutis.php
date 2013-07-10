<?php
/**
 * @author - Kestutis ITDev
 * @date - 2013.07.07
 * @email - kestutis.itsolutions@gmail.com
 * @description - CodeEval Challenge #4, get all phone number char combinations from number
 * @version - 1.0
*/

// is that is a linux command line interface?
$CLI = true;
$fileName = $CLI ? $argv[1] : "data4.txt";

// open the file
$fileHandler = fopen($fileName, "r");

// Check if file is open
if ($fileHandler)
{
    while (true)
	{
        $value = fgets($fileHandler);
        if ($value == false)
        {
            // break loop if we reached end of file
            break;
        }
		
		// Send number for primary processing
		$telPrinter = new TelephonePrinter($value);
		
		// Create all combinations stack
		$telPrinter->createNumberToCharsCombinationsStack();
		
		// Print out the stack
		$telPrinter->printAllCombinations($CLI);
    }
    
    // Check if that is the end of file
    if (!feof($fileHandler))
    {
        kPrint("Error: bad end of file pointer got from fgets()", $CLI);
    }
    fclose ($fileHandler);
}


/**
	@description - Telephone print class
	@author - Kestutis
*/
class TelephonePrinter {
	private $maxCombinationsSecurityLimit = 100000;
	protected $debug = false;
	private $library = array(
		0 => "0",
		1 => "1",
		2 => "abc",
		3 => "def",
		4 => "ghi",
		5 => "jkl",
		6 => "mno",
		7 => "pqrs",
		8 => "tuv",
		9 => "wxyz"
	);
	private $usefulLibrary = array();
	private $usedCharsPositionsLibrary = array();
	private $usedCharsPositionsStackIniatized = false;
	private $number = "";
	private $combinationStack = array();
	private $stackLength = 0;

	/**
	 * @description - prepare number for further actions
	 * @param $number - a number for processing
	 */
	function __construct($number)
	{
		$this->number = $number;
		$this->stackLength = strlen($number);
		$this->createUsefulNumbersLibrary();
		$this->initializeUsedPositionLibrary();
	}
	
	/**
	 * @description - Function to make a "[4] => [3], array([g],[h],[i]), ..." stack"
	 * First element is number of chars in that line
	 * Second element is an array of chars in that line
	*/
	private function createUsefulNumbersLibrary()
	{
		// From 0 to 9
		for($i = 0; $i < $this->stackLength; $i++)
		{
			// Get i.e. '2' if number we read was '239'
			$currentNumberEl = $this->number[$i];
			// Get i.e. "abc"
			$currentElement = $this->library[$currentNumberEl];
			// Get the length of i.e. "abc" - it 3
			$currentElementLength = strlen($currentElement);
			
			// Make an array of that element chars, i.e. ['a','b','c']
			$usefulSubLibrary = array();
			for($j = 0; $j < $currentElementLength; $j++)
			{
				$usefulSubLibrary[] = $currentElement[$j];
			}
			
			// Put this to global array of used elements, i.e.
			// [0] = array(
			// 		'number_used' => '2'
			//  	'size' => 3,
			//	    'elements' => array(['a','b','c'])
			// ),
			// ...
			$this->usefulLibrary[] = array(
				"number_used" => $currentNumberEl,
				"size" => $currentElementLength,
				"elements" => $usefulSubLibrary
			);
		}
	}
	
	/**
	 * @description - Transform numbers to list of all possible combinations
	 */
	public function createNumberToCharsCombinationsStack()
	{
		$i = 0;
		$currCombination = "";
		
		// We don't want to kill server in any case
		while($i < $this->maxCombinationsSecurityLimit)
		{
			$i++;
			$prevCombination = $currCombination;
			$currCombination = $this->getCurrentCombination(); 
			if($currCombination != $prevCombination)
			{
				$this->combinationStack[] = $this->getCurrentCombination();
				$this->setNextElementCombinationInUsedPositionsLibrary();
			} else
			{
				break;
			}
		}

		// It is already sorted in process, we don't need to do that anymore
		//sort($this->combinationStack, SORT_STRING);
	}
	
	/**
	 * @description - Make a library of which characters in each line we currently use
	 */
	private function initializeUsedPositionLibrary()
	{
		if($this->usedCharsPositionsStackIniatized == false)
		{
			$this->usedCharsPositionsStackIniatized = true;
			
			// Initialize used chars postions stack
			for($i = 0; $i < $this->stackLength; $i++)
			{
				// At the very begging we go over the first elements in each line
				$this->usedCharsPositionsLibrary[] = array(
					"currentChar" => 1,
					"totalChars" => $this->usefulLibrary[$i]['size']
				);
			}
		}
	}
	
	/**
	 * @description - Setter. Has to be accessible from test/derived class
	 * This method makes a char lines postion moves
	 * i.e. '111' -> '112', ... '114' -> '121' 
	 */
	protected function setNextElementCombinationInUsedPositionsLibrary()
	{
		if($this->usedCharsPositionsStackIniatized != false)
		{
			$lastPos = $this->stackLength-1;
			// Go over used chars postions stack
			for($i = $lastPos; $i >= 0 ; $i--)
			{
				// Get i.e. last 3rd line in stack, with array:
				// array('currentChar' => 3, 'totalChars' => 4)
				$curr = $this->usedCharsPositionsLibrary[$i];
				
				/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ DEBUG: START ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */ 
				/***/ if($this->debug) { echo "I: {$i}, CMP : {$curr['currentChar']} < {$curr['totalChars']}<br />"; }
				/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ DEBUG: END ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */ 
				
				// check i.e. if we have list ['w','x','y','z'] and
				// we are in el. 1 ('w'), 2 ('x'), or 3 ('y'), not no. 4 ('z')
				if($curr['currentChar'] < $curr['totalChars'])
				{
					// Set current level element to next one
					$this->usedCharsPositionsLibrary[$i]['currentChar'] = $curr['currentChar']+1;
					
					// And set all next level elements to first positions
					$elementToStartChecking = $i+1;
					for($j = $elementToStartChecking; $j < $this->stackLength; $j++)
					{
						$this->usedCharsPositionsLibrary[$j]['currentChar'] = 1;
					}
					
					// And then break the cycle
					break;
				}
			}
		}
	}
	
	/**
	 * @description - Getter. Get current chars combination
	 * @return - current combination
	 */
	private function getCurrentCombination()
	{
		$combination = "";
		if($this->usedCharsPositionsStackIniatized != false)
		{
			
			for($i = 0; $i < $this->stackLength; $i++)
			{
				$currentCharPosAtElement = $this->usedCharsPositionsLibrary[$i]['currentChar']-1;
				$combination .= $this->usefulLibrary[$i]['elements'][$currentCharPosAtElement];
			}
		}
		
		return $combination;
	}

	/**
	 * @description - Print based on interface
	 * @param CLI - Command line interface
	 */
	public function printAllCombinations($CLI = false)
	{
		$glue = $CLI ? "," : "<br />";
		$output = implode($glue, $this->combinationStack);
		$output .= $CLI ? "\n" : "<br /><br />";
		print $output;
	}

	/**
	 * @description - Print function mostly used for testing and debug purposes
	 * @param $type - 'current | useful library'
	 */
	protected function printStatus($type="current")
	{

		$out = "";
		if($type == "current")
		{

			for($i = 0; $i < $this->stackLength; $i++)
			{
				$curr = $this->usedCharsPositionsLibrary[$i];
				$currComb = $this->getCurrentCombination();
				$out .= "LEVEL {$i}: {$curr['currentChar']} of {$curr['totalChars']}. [{$currComb}]<br />";
			}
		} else if($type == "useful library")
		{
			$out = "<big><strong>usefulLibrary:</strong></big><br />";
			$out .= "<strong>Number:</strong> &#39;{$this->number}&#39;<br />";
			$out .= "<strong>Stack Length:</strong> &#39;{$this->stackLength}&#39;<br />";
			foreach($this->usefulLibrary AS $elem)
			{
				$items = implode(", ", $elem['elements']);
				$out .= "N#&#39;<strong>{$elem['number_used']}</strong>&#39;, SIZE: {$elem['size']}, ITEMS: [{$items}]<br />";
			}
		}
		
		print "================================<br />";
		print $out;
		print "================================<br />";
	}
}

/** 
 * @description - Telephone printer class test
 * @author - Kestutis
 */
class TestTelephonePrinter extends TelephonePrinter {
	
	/**
	 *@description - call current class and parent class constructors
	 */
	function __construct()
	{
		parent::__construct("230");
		$this->printStatus("useful library");
	
		echo "<br />Default status:<br  />";
		$this->printStatus("current");
			
		$this->setNextElementCombinationInUsedPositionsLibrary();
		echo "<br />Moved by 1:<br  />";
		$this->printStatus("current");

		$this->setNextElementCombinationInUsedPositionsLibrary();
		echo "<br />Moved by 1:<br  />";
		$this->printStatus("current");
		
		$this->setNextElementCombinationInUsedPositionsLibrary();
		echo "<br />Moved by 1:<br  />";
		$this->printStatus("current");
				
		$this->setNextElementCombinationInUsedPositionsLibrary();
		echo "<br />Moved by 1:<br  />";
		$this->printStatus("current");
				
		$this->setNextElementCombinationInUsedPositionsLibrary();
		echo "<br />Moved by 1:<br  />";
		$this->printStatus("current");
				
		$this->setNextElementCombinationInUsedPositionsLibrary();
		echo "<br />Moved by 1:<br  />";
		$this->printStatus("current");

		$this->setNextElementCombinationInUsedPositionsLibrary();
		echo "<br />Moved by 1:<br  />";
		$this->printStatus("current");
		
		$this->setNextElementCombinationInUsedPositionsLibrary();
		echo "<br />Moved by 1:<br  />";
		$this->printStatus("current");
		
		// We ended all loops, result will be repeated
		$this->setNextElementCombinationInUsedPositionsLibrary();
		echo "<br />Moved by 1:<br  />";
		$this->printStatus("current");
	}
}


// Print based on interface
function kPrint($line, $CLI = false)
{
	if(strlen($line) > 0)
	{
		$output = $CLI ? $line."\n" : $line."<br />";
		print $output;
	}
}
?>