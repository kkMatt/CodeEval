<?php
/**
 * @author - Kestutis ITDev
 * @date - 2013.07.07
 * @email - kestutis.itsolutions@gmail.com
 * @description - CodeEval Challenge #5, print a primes less than number X. Can be many lines of numbers
 * @version - 1.0
*/

// is that is a linux command line interface?
$CLI = true;
$fileName = $CLI ? $argv[1] : "data5.txt";

// open the file
$fileHandler = fopen($fileName, "r");

// Send number for primary processing
$primeManager = new PrimeNumberManager();

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
		// Update the prime's stack
		$primeManager->savePrimeNumbers($value);
    }
    
    // Check if that is the end of file
    if (!feof($fileHandler))
    {
        kPrint("Error: bad end of file pointer got from fgets()", $CLI);
    }
    fclose ($fileHandler);
}

// Print primes for all numbers
foreach($numbersInFile AS $number)
{
	$primeManager->printAllPrimeNumbersTill($number, $CLI);
}

/**
	@description - Prime numbers management/collection/counter class
	@author - Kestutis
*/
class PrimeNumberManager {
	protected $debug = false;
	private $primeNumbers = array(2);
	private $lastPrime = 2;
	private $totalPrimes = 1;
	private $maxNumber = 0;
	
	/**
	 * @description - constructor. Inialize the class
	 */
	function __construct()
	{
		// Do nothing
	}
	
	/**
	 * @description - Printer. Print all prime numbers less than $number
	 */
	public function printAllPrimeNumbersTill($number, $CLI = false)
	{
		// We already have these primes in database - just return them
		if($number <= $this->maxNumber)
		{
			$retPrimes = array();
			for($i=0;$i<$this->totalPrimes;$i++)
			{
				if($number >= $this->primeNumbers[$i])
				{
					$retPrimes[] = $this->primeNumbers[$i];
				} else
				{
					break;
				}
			}
			$glue = $CLI ? "," : ", ";
			$output = implode($glue, $retPrimes);
			$output .= $CLI ? "\n" : "<br /><br />";
			print $output;
		} else
		{
			// save enough numbers first, then print
			return false;
		}		
	}
	
	/**
	 * @description - Getter. Get all prime numbers less than $number
	 */
	public function getAllPrimeNumbersTill($number)
	{
		// We already have these primes in database - just return them
		if($number <= $this->maxNumber)
		{
			$retPrimes = array();
			for($i=0;$i<$this->totalPrimes;$i++)
			{
				if($number >= $this->primeNumbers[$i])
				{
					$ret[] = $this->primeNumbers[$i];
				} else
				{
					break;
				}
			}
		} else
		{
			// save enough numbers first, then get
			return false;
		}
	}
	
	/**
	 * @description - method to collect all prime numbers
	 */
	public function savePrimeNumbers($newMaxNumber)
	{
		// If that is not an integer or the number is less than two
		if((int)$newMaxNumber != $newMaxNumber || (int)$newMaxNumber < 2)
		{
			return false;
		}
		
		if($newMaxNumber > $this->maxNumber)
		{
			$this->maxNumber = $newMaxNumber;
		}
		
		$numberToStart = 3;
		if($newMaxNumber <= $this->lastPrime)
		{
			// Just take all existing primes
			return false;
		} else
		{
			if($newMaxNumber >= ($this->lastPrime+1) && $newMaxNumber > 3 && $this->lastPrime > 3)
			{
				// $newMaxNumber > $lastPrime
				$numberToStart = $this->lastPrime;
			}
		}

		/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ DEBUG: START ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */ 
		/***/ if($this->debug)
		/***/ {
		/***/ 	// check the range
		/***/ 	print "number to start: {$numberToStart}<br />";
		/***/ 	print "number to reach: {$newMaxNumber}<br />";
		/***/ }
		/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ DEBUG: END ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */ 



		// till Last prime
		for($ctr = $numberToStart; $ctr < $newMaxNumber; $ctr += 2)
		{
			$isPrimeNumber = true;
			foreach($this->primeNumbers AS $currPrimeNumber)
			{
				if($ctr % $currPrimeNumber == 0)
				{
					$isPrimeNumber = false;
					break;
				}
			}
			
			// If it is really prime number
			if($isPrimeNumber)
			{
				// Add it to the list
				$this->primeNumbers[] = $ctr;
				$this->lastPrime = $ctr;
				$this->totalPrimes = sizeof($this->primeNumbers);
			}
		}

		/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ DEBUG: START ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */ 
		/***/ if($this->debug)
		/***/ {
		/***/ 	// check the cache
		/***/ 	print_r($this->primeNumbers);
		/***/ 	print "<br /><br />";
		/***/ }
		/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ DEBUG: END ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */ 		
	}
}

?>