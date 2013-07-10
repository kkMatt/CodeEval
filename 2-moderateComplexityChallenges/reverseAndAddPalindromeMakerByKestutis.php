<?php
/**
 * @author - Kestutis ITDev
 * @date - 2013.07.07
 * @email - kestutis.itsolutions@gmail.com
 * @description - CodeEval Challenge #6, check if number is palindrome and get iterations amount
 * @version - 1.0
*/

// is that is a linux command line interface?
$CLI = true;
$fileName = $CLI ? $argv[1] : "data6.txt";

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

// Go over each number, try to transform it to polindrome in up to 1000 loops
foreach($numbersInFile AS $number)
{
	// Send number for primary processing
	$palindromeMaker = new PalindromeMaker($number);
	$palindromeMaker->makePalindromeFromNumber();
	// Print 'iterations amount needed' and 'polindrome'
	$palindromeMaker->printIterationsNeededAndPalindrome($CLI);
	//$palindromeMaker->printNumberOfIternationsNeeded($CLI);
	//$palindromeMaker->printPalindrome($CLI);
}

/**
	@description - Class to make Palindromes
	@author - Kestutis
*/
class PalindromeMaker {
	// If we will not get a palindrome in 1000 loops we will break the loop
	private $loopLimitation = 1000;
	private $number = 0;
	private $palindrome = 0;
	private $totalIterationsNeeded = -1;

	/**
	 * @description - constructor. Inialize the class
	 * @param $number - number for processing
	 */
	function __construct($number)
	{
		$this->number = $number;
	}
	
	/**
	 * @description - method to make a palindrome from a number
	 */
	public function makePalindromeFromNumber()
	{
		$totalIterationsNeeded = -1;
		$currNumber = $this->number;
		for($i = 0; $i < $this->loopLimitation; $i++)
		{
			// Reverse the number in most effective way
			$reversedNumber = $this->getReversedNumber($currNumber, "strrev");
			if($currNumber == $reversedNumber)
			{
				// It is a palindrome
				$this->totalIterationsNeeded = $i;
				$this->palindrome = $currNumber;
				break;
			} else
			{
				// Add reversed number to current number
				$currNumber += $reversedNumber;
			}
		}
	}
	
	/**
	 * @description - Getter. How many loops done to get a palindrome from number
	 * @return - (int) amount of loops
	 */	
	public function getNumberOfIternationsNeeded()
	{
		return $this->totalIterationsNeeded;
	}
	
	/**
	 * @description - Printer. How many loops done to get a palindrome from number
	 */		
	public function printNumberOfIternationsNeeded($CLI = false)
	{
		$output = $this->totalIterationsNeeded;
		$output .= $CLI ? "\n" : "<br />";
		print $output;
	}
	
	/**
	 * @description - Getter. How many loops done to get a palindrome from number
	 * @return - (int) amount of loops
	 */	
	public function getPalindrome()
	{
		return $this->palindrome;
	}
	
	/**
	 * @description - Printer. How many loops done to get a palindrome from number
	 */		
	public function printPalindrome($CLI = false)
	{
		$output = $this->palindrome;
		$output .= $CLI ? "\n" : "<br />";
		print $output;
	}
	
		/**
	 * @description - Printer. How many loops done to get a palindrome from number
	 */		
	public function printIterationsNeededAndPalindrome($CLI = false)
	{
		$output = $this->totalIterationsNeeded." ".$this->palindrome;
		$output .= $CLI ? "\n" : "<br />";
		print $output;
	}
	
	/**
	 * @description - Getter. Method to reverse the number
	 * @note - (int)strrev($number) would do exactly the same
	 */
	private function getReversedNumber($number,$mode = "strrev")
	{
		if($mode == "strrev")
		{
			$reversedNumber = (int)strrev($number);
		} else
		{
			// This is a worldwide method to reverse the number. But it is WAY LESS memory efficient that "strrev" php model
			// Even for 100 loops it is already over 200 times faster, for 1000 times if will go over 30sec execution limit
			$reversedNumber = 0;
			
			// Reverse the number
			while($number > 0)
			{
				$restNumberPart = $number % 10;
				$reversedNumber = $reversedNumber * 10 + $restNumberPart;
				$number = ($number - $restNumberPart) / 10;
			}
		}
		return $reversedNumber;
	}
}

?>