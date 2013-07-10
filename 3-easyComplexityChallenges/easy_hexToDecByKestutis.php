<?php
/*
 * @author - Kestutis ITDev
 * @date - 2013.07.07
 * @email - kestutis.itsolutions@gmail.com
 * @description - CodeEval Challenge #3, hex to decimal converter
*/
// is that is a linux command line interface?
$CLI = true;
$fileName = $CLI ? $argv[1] : "data3.txt";

// open the file
$fileHandler = fopen($fileName, "r");

// Check if file is open
if ($fileHandler)
{
    while (true) {
        $value = fgets($fileHandler);
        if($value == false)
        {
            // break loop if we reached end of file
            break;
        }
        //kDebug($value, $CLI);
		
        // Convert to hex number
        $hexNumber = hexdec($value);
        kPrint($hexNumber, $CLI);
    }
    
    // Check if that is the end of file
    if (!feof($fileHandler))
    {
        kPrint("Error: bad end of file pointer got from fgets()", $CLI);
    }
    fclose ($fileHandler);
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

// Print based on interface
function kDebug($variable, $CLI = false)
{
	print "[DEBUG]: ";
	var_dump($variable);
	$output = $CLI ? "\n" : "<br />";
	print $output;
}
?>