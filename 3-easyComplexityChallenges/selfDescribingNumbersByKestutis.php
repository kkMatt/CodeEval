<?php
/**
 * @author - Kestutis ITDev
 * @date - 2013.07.07
 * @email - kestutis.itsolutions@gmail.com
 * @description - CodeEval Challenge #10, check if this is a self-descibing number
 * @version - 1.0
*/

$GLOBALS['debug'] = false;
// is that is a linux command line interface?
$CLI = true;
$fileName = $CLI ? $argv[1] : "data10.txt";

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

// Go over each number and print if it is a self-describing number or not
foreach($numbersInFile AS $number)
{
	$isSelfDesribing = checkIfSelfDescribingNumber($number);
	kPrint($isSelfDesribing, $CLI);
}

// Function to check if the number is self describing or not
function checkIfSelfDescribingNumber($number)
{
	// Ret = 1 - self-describing, 0 - not
	$ret = 1;
	
	// Transform number int - just to avoid any spaces even if there is any after number
	$number = (int) $number;
	// Then we make a string
	$strNumber = (string) $number;
	// And get the corrent length of our string
	$length = strlen($strNumber);
	
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ DEBUG: START ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */ 
	/***/ if($GLOBALS['debug']) { echo "<br />Number: &#39;{$number}&#39;<br />Length: {$length}<br />"; }
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ DEBUG: END ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	
	// Go over each char in string
	for($i = 0; $i < $length; $i++)
	{
		// how many of times i-th digit must occur to be a self describing number
		$timesToOccur = $strNumber[$i];
		/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ DEBUG: START ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */ 
		/***/ if($GLOBALS['debug']) { echo "Has to occur &#39;{$timesToOccur}&#39; times<br />"; }
		/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ DEBUG: END ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */ 

		$ctr = 0;
		// Go over each char in string (2nd counter)
		for($j = 0; $j < $length; $j++)
		{
			$tmp = $strNumber[$j];
			if($tmp == $i)
			{
				$ctr++;
			}
			if ($ctr > $timesToOccur)
			{
				// Not a self-describing
				$ret = 0;
			}
		}
		
		if($ctr != $timesToOccur)
		{
			// Not a self-describing
			$ret = 0;
		}
	}

	
	return $ret;
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