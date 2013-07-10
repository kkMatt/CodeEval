<?php
/**
 * @author - Kestutis ITDev
 * @date - 2013.07.07
 * @email - kestutis.itsolutions@gmail.com
 * @description - CodeEval Challenge #16, fibonacci counter
 * @version - 1.0
*/

// is that is a linux command line interface?
$CLI = true;
$fileName = $CLI ? $argv[1] : "data16.txt";

// open the file
$fileHandler = fopen($fileName, "r");

$numbersInFile = array();
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

		$numbersInFile[] = $value;
    }
    
    // Check if that is the end of file
    if (!feof($fileHandler))
    {
        kPrint("Error: bad end of file pointer got from fgets()", $CLI);
    }
    fclose ($fileHandler);
}

$fibCounter = new FibonacciCounter();

// Go over all numbers and print n-th fibonacci number
foreach($numbersInFile AS $number)
{
	$nthFibonacci = $fibCounter->getFibonacci($number);
	kPrint($nthFibonacci, $CLI);
}

/**
	@description - Class to count and cache Fibonacci numbers
	@author - Kestutis
*/
class FibonacciCounter {
	private $fibonacciStack = array(0, 1, 2);
	private $fibonacciStackSize = 3;
	
	/**
	 * @description - Just a fib constructor
	 */
	function __contruct()
	{
		//Do nothing
	}
	
	/**
	 * @description - Memory-optimal Fib counter
	 * adds already counter numbers to memory, and only counts the rest
	 * @return - fibonacci number
	 */
	public function getFibonacci($fibNumber)
	{ 
		if((int)$fibNumber < $this->fibonacciStackSize)
		{
			$ret = $this->fibonacciStack[$fibNumber-1];
		} else
		{
			$this->countFibonacci($fibNumber);
			if($this->fibonacciStackSize >= $fibNumber)
			{
				$ret = $this->fibonacciStack[$fibNumber-1];
			} else
			{
				$ret = "Element out of Fibonacci stack range";
			}
		}
		
		return $ret;
	}

	/**
	 * @description - Count fibonacci number
	 */	
	private function countFibonacci($fibNumber)
	{
		$prev = $this->fibonacciStack[$this->fibonacciStackSize-2];
		$curr = $this->fibonacciStack[$this->fibonacciStackSize-1];

		$fib = $curr;
		while($fib < 100000000 && $this->fibonacciStackSize < $fibNumber)
		{
			$fib = $prev + $curr;
			$this->fibonacciStack[] = $fib;
			$this->fibonacciStackSize = $this->fibonacciStackSize+1; 
			$prev = $curr;
			$curr = $fib;
		}
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