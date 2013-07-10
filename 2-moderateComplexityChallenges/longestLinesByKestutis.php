<?php
/**
 * @author - Kestutis ITDev
 * @date - 2013.07.09
 * @email - kestutis.itsolutions@gmail.com
 * @description - CodeEval Challenge #21, print N longest lines from file with X lines, skip empty lines
 * @version - 1.1
*/

// is that is a linux command line interface?
$CLI = true;
$fileName = "data21.txt"; // local-test filename
if($CLI)
{
	$fileName = isset($argv[1]) ? htmlspecialchars($argv[1]) : "File Not Found";
}

// open the file
$fileHandler = fopen($fileName, "r");

// Initialize
$linesToPrint = 0;

$sentencesInFile = array();
// Check if file is open
if ($fileHandler)
{
	$inputLineCounter = 0;
    while (true)
	{
        $value = fgets($fileHandler);
        if ($value == false)
        {
            // break loop if we reached end of file
            break;
        }
		
		// Increment the line counter
		$inputLineCounter++;
		
		// If that is line one, save N number ('$linesToPrint')
		if($inputLineCounter == 1)
		{
			$linesToPrint = (int) $value;
		} else
		{
			//removeTrailingSpaces
			$value = trim($value);
			$sentenceLength = strlen($value);
			// Cache it on if it is not an empty line
			if(preg_match('/[A-Za-z0-9]/', $value))
			{
				$sentencesInFile[] = array(
					"length" => $sentenceLength,
					"sentence" => $value
				);
			}
		}
		
    }
    
    // Check if that is the end of file
    if (!feof($fileHandler))
    {
        kPrint("Error: bad end of file pointer got from fgets()", $CLI);
    }
    fclose ($fileHandler);
}

$length = array();
$sentence = array();
// Obtain a list of columns
foreach ($sentencesInFile as $key => $row) {
    $length[$key]  = $row['length'];
    $sentence[$key] = $row['sentence'];
}

// Sort the data with 'length' descending, 'sentence' ascending
// Add $data as the last parameter, to sort by the common key
array_multisort($length, SORT_DESC, $sentence, SORT_ASC, $sentencesInFile);


// Go over all sentences and print the first N
$printedLinesCounter = 0;
foreach($sentencesInFile AS $row)
{
	kPrint($row['sentence'], $CLI);	
	$printedLinesCounter++;
	if($printedLinesCounter >= $linesToPrint)
	{
		break;
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