<?php


$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$p = $_GET["p"];
if($p != $token["Token"])
    return;
?>

<html>
<script type="text/javascript">

function submitData()
{
    let url = "http://"+location.host+":3000/Message"; 
    let data = {};
    data.Message = document.getElementById('messageField').value;
    let b = JSON.stringify(data);
    alert(b);
    fetch(url, { method: "POST", body: b, headers: {
            "Content-Type": "application/json"
          }});
}


</script>
<link rel="stylesheet" href="admin.css">
<body id="body">

<div name="messageDiv">
    <textarea id="messageField" rows="4" cols="120"></textarea>
    </br>
    <button onclick="submitData()">Send</button>
</div>

</script>
</body>
</html>