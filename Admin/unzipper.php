<?php
phpinfo();

$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$zip = new ZipArchive; 
  
// Zip File Name 
if ($zip->open('../JsonArc/json_2021-02-13.zip') === TRUE) { 
  
    // Unzip Path 
    $zip->extractTo('../'); 
    $zip->close(); 
    echo 'Unzipped Process Successful!'; 
} else { 
    echo 'Unzipped Process failed'; 
} 

?>