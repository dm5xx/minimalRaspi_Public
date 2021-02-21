<?php
$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$p = $_GET["p"];
if($p != $token["Token"])
    return;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Unzip a zip file to the webserver</title>
</head>
<style>
body{
    background-color: black;
}

div {
    font-size:18px;
    color: white;
}

</style>
<body onLoad="document.getElementById('myForm').reset();">

<?php 
$path = '/home/shares/ubs/public/update/';  // absolute path to the directory where zipper.php is in
$isSuccess = false;

if($_FILES["zip_file"]["name"]) {
    $filename = $_FILES["zip_file"]["name"];
    $source = $_FILES["zip_file"]["tmp_name"];
    $type = $_FILES["zip_file"]["type"];

    $name = explode(".", $filename);
    $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
    foreach($accepted_types as $mime_type) {
        if($mime_type == $type) {
            $okay = true;
            break;
        } 
    }

    $continue = strtolower($name[1]) == 'zip' ? true : false;
    if(!$continue) {
        $message = "The file you are trying to upload is not a .zip file. Please try again.";
    }

  $targetzip = $path . "update.zip"; // target zip file

  if(move_uploaded_file($source, $targetzip)) {
      $message = "Upload OK";
      exec("sudo chmod 777 ".$targetzip);
      $isSuccess = true;
  } else {    
      $message = "There was a problem with the upload. Please try again.";
  }
}
    echo "<div>Current directory information:</div>";
    echo "<div>";
    $r = exec("sudo ls -l ".$path);
    $a = explode("\n", $r);
    foreach($a as $key => $value)
    {
        echo "$value</br>";
    }
    echo "</div>";
?>
<?php if($message) echo "<p>$message</p>"; 

if(!$isSuccess)
{
    echo "<form enctype=\"multipart/form-data\" method=\"post\" id=\"myForm\" action=\"\">";
    echo "<div>Choose a zip file to upload: <input type=\"file\" name=\"zip_file\" /></div>";
    echo "<br />";
    echo "<input type=\"submit\" name=\"submit\" value=\"Upload\" />";
    echo "</form>";
    echo "</br>";
}
echo "<button onclick=\"location.href='up.php?p=".$p."'\">Reload</button>";
echo "<button onclick=\"location.href='unzipper_custom.php?p=".$p."'\">Unzip</button>";
?>
</body>
</html>