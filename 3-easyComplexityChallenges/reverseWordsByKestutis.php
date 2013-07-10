<?php
/**
 * @author - Kestutis ITDev
 * @date - 2013.07.07
 * @email - kestutis.itsolutions@gmail.com
 * @description - CodeEval Challenge #14, reverse words in sentences
 * @version - 1.0
*/

// is that is a linux command line interface?
$CLI = true;
$fileName = $CLI ? $argv[1] : "data14.txt";

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

		$sentencesInFile[] = $value;
    }
    
    // Check if that is the end of file
    if (!feof($fileHandler))
    {
        kPrint("Error: bad end of file pointer got from fgets()", $CLI);
    }
    fclose ($fileHandler);
}

// Go over each sentece and print the sentence in reversed words order
foreach($sentencesInFile AS $sentence)
{
	//print $sentence;
	$reversedArrayOfWords = array_reverse(explode(" ", $sentence));
	$reversedSentence = implode(" ", $reversedArrayOfWords);

	// Remove trailing spaces, and "\n"
	$reversedSentence = trim($reversedSentence);
	$reversedSentence = str_replace(array("\n", "\r\n"), array("", ""), $reversedSentence);
	
	$firstChar = $reversedSentence[0];
	$lastChar = $reversedSentence[strlen($reversedSentence)-1];
	
	// Remove space from begging if there is any
	if(!preg_match('/[A-Za-z0-9]/', $firstChar))
	{
		$reversedSentence = substr($reversedSentence, 1, 0);
	}
	// Remove space from end if there is any
	if(!preg_match('/[A-Za-z0-9]/', $lastChar))
	{
		$reversedSentence = substr($reversedSentence, 0, -1);
	}
	// Print only if it is not an empty line
	if(preg_match('/[A-Za-z0-9]/', $reversedSentence))
	{
		kPrint($reversedSentence, $CLI);
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