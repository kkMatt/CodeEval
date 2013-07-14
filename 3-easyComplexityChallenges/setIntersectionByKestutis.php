<?php
/**
 * @author - Kestutis ITDev
 * @date - 2013.07.13
 * @email - kestutis.itsolutions@gmail.com
 * @description - CodeEval Challenge #28, Set Intersection
 * @version - 1.0
*/

// is that is a linux command line interface?
$CLI = true;
$fileName = $CLI ? $argv[1] : "data28.txt";

// open the file
$fileHandler = fopen($fileName, "r");

$setsInFile = array();
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
		
		// Make sets
		$valueParts = explode(";", trim($value));
		$arrSetA = explode(",", $valueParts[0]);
		$arrSetB = explode(",", $valueParts[1]);
		
		// Put sets to array
		$setsInFile[] = array(
			"setA" => $arrSetA,
			"setB" => $arrSetB
		);
    }
    
    // Check if that is the end of file
    if (!feof($fileHandler))
    {
        kPrint("Error: bad end of file pointer got from fgets()", $CLI);
    }
    fclose ($fileHandler);
}

// Go over all set, and print out intersection
foreach($setsInFile AS $set)
{
	$arrIntersection = array_intersect($set['setA'], $set['setB']);
	$out = implode(",", $arrIntersection);
	kPrint($out, $CLI);
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