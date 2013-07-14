<?php
/**
 * @author - Kestutis ITDev
 * @date - 2013.07.13
 * @email - kestutis.itsolutions@gmail.com
 * @description - CodeEval Challenge #25, Cheeck if number is happy or not
 * @version - 1.0
*/

// is that is a linux command line interface?
$CLI = true;
$fileName = $CLI ? $argv[1] : "data25.txt";

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
		$numbersInFile[] = (int) $value;
    }
    
    // Check if that is the end of file
    if (!feof($fileHandler))
    {
        kPrint("Error: bad end of file pointer got from fgets()", $CLI);
    }
    fclose ($fileHandler);
}

// Go over all numbers, and check if the number is happy or not
foreach($numbersInFile AS $number)
{

	$out = "0";
	if(isHappyNumber($number))
	{
		$out = "1";
	}
	
	kPrint($out, $CLI);
}

// Function to check if the number is happy or not
// A happy number is defined by the following process.
// Starting with any positive integer, replace the number by the sum of the squares of its digits,
// and repeat the process until the number equals 1 (where it will stay), or it loops endlessly
// in a cycle which does not include 1. Those numbers for which this process ends in 1 are happy numbers,
// while those that do not end in 1 are unhappy numbers.
function isHappyNumber($number)
{
	// security interations counter
	$i = 0;
	$past = array();
    while (true)
	{
		
		// First - sum all squares of numbers digits
        $sumOfAllNumberDigitsSquares = 0;
        while ($number > 0)
		{
            $sumOfAllNumberDigitsSquares += pow(($number % 10), 2);
            $number /= 10;
			
			// Security break to don't get infinity loop
			if($i > 100000)
			{
				return false;
			}
			$i++;
        }
		
        if ($sumOfAllNumberDigitsSquares == 1)
		{
			// it is happy number
            return true;
		}
		
        if (in_array($sumOfAllNumberDigitsSquares, $past))
		{
			// it is not a happy number
            return false;
		}
		
        $number = $sumOfAllNumberDigitsSquares;
        $past[] = $sumOfAllNumberDigitsSquares;
		
		// Security break to don't get infinity loop
		if($i > 100000)
		{
			return false;
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