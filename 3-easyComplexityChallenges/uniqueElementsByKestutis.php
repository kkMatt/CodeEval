<?php
/**
 * @author - Kestutis ITDev
 * @date - 2013.07.07
 * @email - kestutis.itsolutions@gmail.com
 * @description - CodeEval Challenge #17, remove all copies of numbers in each line
 * @version - 1.0
*/

// is that is a linux command line interface?
$CLI = true;
$fileName = $CLI ? $argv[1] : "data17.txt";

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

// Go over all number lines and update the line to leave only unique arrays
foreach($numbersInFile AS $numbersLine)
{
	$uniqueNumbersArray = array_unique(explode(",",$numbersLine),SORT_NUMERIC);
	$uniqueNumbersLine = implode(",", $uniqueNumbersArray);
	kPrint($uniqueNumbersLine, $CLI);
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