<?php
/**
 * @author - Kestutis ITDev
 * @date - 2013.07.13
 * @email - kestutis.itsolutions@gmail.com
 * @description - CodeEval Challenge #26, Swap case in sentence
 * @version - 1.0
*/

// is that is a linux command line interface?
$CLI = true;
$fileName = $CLI ? $argv[1] : "data26.txt";

// open the file
$fileHandler = fopen($fileName, "r");

$sentencesInFile = array();
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
		$sentencesInFile[] = trim($value);
    }
    
    // Check if that is the end of file
    if (!feof($fileHandler))
    {
        kPrint("Error: bad end of file pointer got from fgets()", $CLI);
    }
    fclose ($fileHandler);
}

// Go over all sentences, and swap case
foreach($sentencesInFile AS $sentence)
{
	$length = strlen($sentence);
	$newSentence = "";
	// Go over each char in sentence
	for($i = 0; $i < $length; $i++)
	{
		$newSentence .= swapCase($sentence[$i]);
	}
	
	// Print new sentence
	kPrint($newSentence, $CLI);
}

// Function to swap char case
function swapCase($char)
{
	if(strtoupper($char) === $char)
	{
		return strtolower($char);
	} else
	{
		return strtoupper($char);
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