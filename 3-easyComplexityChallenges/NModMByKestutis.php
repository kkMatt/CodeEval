<?php
/**
 * @author - Kestutis ITDev
 * @date - 2013.07.13
 * @email - kestutis.itsolutions@gmail.com
 * @description - CodeEval Challenge #27, N mod M without modulus operator
 * @version - 1.0
*/

// is that is a linux command line interface?
$CLI = true;
$fileName = $CLI ? $argv[1] : "data27.txt";

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
		$valueParts = explode(",",trim($value));
		$numbersInFile[] = array(
			"N" => (int) $valueParts[0],
			"M" => (int) $valueParts[1]
		);
    }
    
    // Check if that is the end of file
    if (!feof($fileHandler))
    {
        kPrint("Error: bad end of file pointer got from fgets()", $CLI);
    }
    fclose ($fileHandler);
}

// Go over all numbers, and get modulus without using modulus operator
foreach($numbersInFile AS $number)
{
	$closestMultiple = getClosestMultiple($number['M'], $number['N']);
	$modulus = $number['N'] - $closestMultiple;
	if($modulus < 0)
	{
		$modulus = $number['N'];
	}
	//kPrint("closestMultiple: {$closestMultiple}", $CLI);
	kPrint($modulus, $CLI);
}

// Function to get the closest number multiplication to $limit
function getClosestMultiple($number, $limit)
{
	$maxNumber = 0;
	if($number > 0)
	{
		$maxNumber = $number;
		do
		{
			if($maxNumber+$number > $limit)
			{
				break;
			} else
			{
				$maxNumber = $maxNumber+$number;
			}
		} while(true);
	}
	return $maxNumber;
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