<?php
/**
 * @author - Kestutis ITDev
 * @date - 2013.07.08
 * @email - kestutis.itsolutions@gmail.com
 * @description - CodeEval Challenge #20, find a specific letter rightmost position in each sentence
 * @version - 1.0
*/

// is that is a linux command line interface?
$CLI = true;
$fileName = $CLI ? $argv[1] : "data20.txt";

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

		$sentencesInFile[] = $value;
    }
    
    // Check if that is the end of file
    if (!feof($fileHandler))
    {
        kPrint("Error: bad end of file pointer got from fgets()", $CLI);
    }
    fclose ($fileHandler);
}

// Go over all sentences and print out the matching requested letter position
foreach($sentencesInFile AS $sentence)
{
	$sentenceParts = explode(",", $sentence);
	$charToFind = $sentenceParts[1][0];
	$sentenceToSeach = $sentenceParts[0];
	$position = strrpos($sentenceToSeach,$charToFind);
	if($position === false)
	{
		$position = "-1";
	}
	kPrint($position, $CLI);
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