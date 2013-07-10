<?php
/**
 * @author - Kestutis ITDev
 * @date - 2013.07.07
 * @email - kestutis.itsolutions@gmail.com
 * @description - CodeEval Challenge #20, print 2nd from end word
 * @version - 1.0
*/

// is that is a linux command line interface?
$CLI = true;
$fileName = $CLI ? $argv[1] : "data9.txt";

// open the file
$fileHandler = fopen($fileName, "r");

$sentenceList = array();
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

		$sentenceList[] = $value;
    }
    
    // Check if that is the end of file
    if (!feof($fileHandler))
    {
        kPrint("Error: bad end of file pointer got from fgets()", $CLI);
    }
    fclose ($fileHandler);
}

// Go over all sentences and print second from end word in each line
foreach($sentenceList AS $sentence)
{
	$words = explode(" ", $sentence);
	kPrint($words[sizeof($words)-2], $CLI);
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