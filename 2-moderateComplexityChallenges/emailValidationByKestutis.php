<?php
/*
 * @author - Kestutis ITDev
 * @date - 2013.07.06
 * @email - kestutis.itsolutions@gmail.com
 * @description - CodeEval Challenge #2, e-mail validator, stackprint
 * @version - v1.4
*/
// is that is a linux command line interface?
$CLI = true;
$fileName = $CLI ? $argv[1] : "data2.txt";

// open the file
$fileHandler = fopen($fileName, "r");

// Check if file is open
if ($fileHandler)
{
    while (true)
	{
        $value = fgets($fileHandler);
        if($value == false)
        {
            // break loop if we reached end of file
            break;
        }
        //kDebug($value, $CLI);
		
		// Trim ending space, and apply basic security
		$email = htmlspecialchars(trim($value));
	
		// Verify email
		$ret = isEmail($email) ? "true" : "false";
		// Print out the result;
		kPrint($ret, $CLI);
	}
}
	
// Custom preg-match function with not-array check
function preg_check($expression, $value) {
	if (!is_array($value)) {
		return preg_match($expression, $value);
	} else {
		return false;
	}
}
		
// Check if that is an correct e-mail address		
function isEmail($emailAddress)
{
	if (preg_check("/^[-0-9A-Z_\.]{1,50}@([-0-9A-Z_\.]+\.){1,50}([0-9A-Z]){2,4}$/i", $emailAddress))
	{
		return true;
	} else {
		return false;
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

// Print based on interface
function kDebug($variable, $CLI = false)
{
	print "[DEBUG]: (";
	var_dump($variable);
	$output = $CLI ? ")\n" : ")<br />";
	print $output;
}
?>