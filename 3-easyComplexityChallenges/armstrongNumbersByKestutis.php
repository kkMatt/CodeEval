<?php
/**
 * @author - Kestutis ITDev
 * @date - 2013.07.13
 * @email - kestutis.itsolutions@gmail.com
 * @description - CodeEval Challenge #29, Cheeck if number is Armstrong or not
 * @version - 1.0
*/

// is that is a linux command line interface?
$CLI = true;
$fileName = $CLI ? $argv[1] : "data29.txt";

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

// Go over all numbers, and check if the number is armstrong or not
foreach($numbersInFile AS $number)
{

	$out = "False";
	if(isArmstrongNumber($number))
	{
		$out = "True";
	}
	
	kPrint($out, $CLI);
}

// Function to check if it is an armstrong number
function isArmstrongNumber($number)
{
	// create an array containing the single digits
	$digits = str_split($number); 
	// the power every digit has to be raised to
	$power = count($digits);     
	$result = array_sum(
		array_map('pow', $digits, array_fill(0, $power, $power))
	);
	
	return $number == $result;
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