<?php

require_once 'Spreadsheet/Excel/Writer.php';
 
// Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();
 
/* Sending HTTP headers, this will popup a file save/open
dialog in the browser when this file is run
*/
$workbook->send('excelTest.xls');
 
// Create 2 worksheets
$worksheet1 =& $workbook->addWorksheet('worksheet 1');
$worksheet2 =& $workbook->addWorksheet('worksheet 2');
 
// Set header formating for Sheet 1
$header =& $workbook->addFormat();
$header->setBold();		// Make it bold
$header->setColor('black');	// Make foreground color black
$header->setFgColor("green");	// Set background color to green
$header->setHAlign('center');	// Align text to center
 
// Write some data on Sheet 1
$worksheet1->write(0, 0, 'Name', $header);
$worksheet1->write(0, 1, 'Age', $header);
$worksheet1->write(1, 0, 'Sameer Borate');
$worksheet1->write(1, 1, 30);
 
// Set header formating for Sheet 2
$header =& $workbook->addFormat();
$header->setBold();		// Make it bold
$header->setFgColor("red");	// Set background color to red
$header->setHAlign('center');	// Align text to center
 
// Write some data on Sheet 2
$worksheet2->write(0, 0, 'Name', $header);
$worksheet2->write(0, 1, 'Age', $header);
$worksheet2->write(1, 0, 'Tom Peters');
$worksheet2->write(1, 1, 30);
 
// Send the file to the browser
$workbook->close();
?>