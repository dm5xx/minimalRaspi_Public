<?php


$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$p = $_GET["p"];
if($p != $token["Token"])
    return;
?>

<html>
<script type="text/javascript">
<?php

$result = $_GET;

if(count($result) < 1 || $result['file'] == null)
    return;

$string = file_get_contents("../JSON/".$result['file'] . ".json");
$json_a = json_decode($string, true);

echo "var fileName = \"" . "../JSON/".$result['file'] . "\";\n";

echo "var config={";
    
foreach ($json_a as $key => $value){

    $temp = $value;

    if(is_array($value))
        $temp = json_encode($value);

    echo  '"'. $key . '":' . '"'. $temp . '",'. "\n";
}
echo "};\n";
?>
</script>
<link rel="stylesheet" href="admin.css">
<body id="body">
    <div id="formcontainer"></div>

<script>
     // Create a form synamically 
const form = document.createElement("form");
form.setAttribute("name", "form_datasets"); 
form.setAttribute("id", "myForm"); 
form.setAttribute("method", "post"); 
form.setAttribute("action", "submit.php"); 

const table = document.createElement("table");

let a = 0;

// create elements <table> and a <tbody>
var tbl = document.createElement("table");

var tblBody = document.createElement("tbody");

var entries = Object.entries(config);
var dataSets = entries.length;

var baseName = "";
var baseValue = "";
var baseNameIsDisabled = false;

if(fileName.endsWith("Disable_sc"))
{
    baseName = "disable";
    baseNameIsDisabled = true;
    baseValue = "[]";
    submitKey = baseName+dataSets;
}

if(fileName.endsWith("config"))
{
    submitKey = "Change";
}


for (const [key, value] of entries) 
{
    var row = document.createElement("tr");
    row.setAttribute("id", "row_"+key);
    
    var cell = document.createElement("td");
    var elem = document.createElement('a');
    elem.setAttribute("href", "#");
    elem.setAttribute('onClick', "deleteEntry('"+key+"'); return false;");
    elem.innerHTML = key + ": ";        
    cell.appendChild(elem);
    row.appendChild(cell);

    var cell = document.createElement("td");
    var temp = document.createElement("input"); 
    temp.setAttribute("type", "text"); 
    temp.setAttribute("name", key);
        
    if(value == 0)
        temp.setAttribute("value", '0');
    else 
    {
        if(!Array.isArray(value))
            temp.setAttribute("value", value);
        else
            temp.setAttribute("value", value.join(','));
    }
    cell.appendChild(temp);
    row.appendChild(cell);
    tblBody.appendChild(row);
}

tbl.appendChild(tblBody);
form.append(tbl);  

var s = document.createElement("input"); 
s.setAttribute("type", "hidden"); 
s.setAttribute("name", "File"); 
s.setAttribute("value", fileName); 
form.append(s);  

var p = document.createElement("input"); 
p.setAttribute("type", "hidden"); 
p.setAttribute("name", "p"); 
p.setAttribute("value", "<?php echo $p;?>"); 
form.append(p);  

var b = document.createElement('button');
b.setAttribute('onClick', "addEntry(); return false;");
b.setAttribute('id', 'add');
b.setAttribute('class', 'glow-on-hover');
b.textContent = 'add Entry';
form.append(b);

var c = document.createElement('button');
c.setAttribute('onClick', "refresh(); return false;");
c.setAttribute('class', 'glow-on-hover');  
c.textContent = 'undo';
form.append(c);

var s = document.createElement("button"); 
s.setAttribute('onClick', "submitValue(); return false;");
s.setAttribute('class', 'glow-on-hover');
s.textContent = 'Submit';
form.append(s); 
    
document.getElementById('formcontainer').appendChild(form);

function deleteEntry(key)
{
    if(dataSets == 1)
    {
        alert("You are not allowed to remove the last remaining entry");
        return;
    }

    var toDelete = document.getElementById('row_'+key);
    toDelete.remove();
    dataSets--;
}

function addEntry()
{
    let button = document.getElementById("add");
    button.style.visibility ="hidden";

    let key = submitKey;
    var row = document.createElement("tr");
    row.setAttribute("id", "row_"+key);
    
    var cell = document.createElement("td");
    var temp = document.createElement("input");
    temp.setAttribute("type", "text"); 
    if(baseNameIsDisabled)
        temp.setAttribute("readonly", "readonly"); 
    temp.setAttribute("name", "Unknown");        
    temp.setAttribute("value", key + ":");
    cell.appendChild(temp);
    row.appendChild(cell);
    
    var cell = document.createElement("td");
    var temp = document.createElement("input"); 
    temp.setAttribute("type", "text"); 
    temp.setAttribute("name", key);        
    temp.setAttribute("value", baseValue);
    
    cell.appendChild(temp);
    row.appendChild(cell);
    tblBody.appendChild(row);

    dataSets++;
}

function submitValue()
{
    var inputFields = document.forms["form_datasets"].getElementsByTagName("input");

    var unknownElement = document.getElementsByName("Unknown");
    var unknownElementValue = document.getElementsByName("Change");

    if(unknownElement.length == 1)
    {
        newTitle = unknownElement[0].value.replace(":", "");

        unknownElement[0].value = unknownElementValue[0].value.replace(":", "");
        unknownElement[0].name = newTitle;

        unknownElementValue[0].remove();
    }

    let isValid = true;

    for(let a = 0; a < inputFields.length; a++)
    {
        if(inputFields[a].type != "hidden")
        {
            // if(baseName == "disable")
            // {
            //     if(inputFields[a].readOnly == true)
            //         continue;

            //     let isStartEndValid = (inputFields[a].value.startsWith("[") && inputFields[a].value.endsWith("]"));

            //     if(isStartEndValid)
            //     {
            //         var array = [];

            //         try 
            //         {
            //             array = JSON.parse(inputFields[a].value);
            //         } 
            //         catch(e) 
            //         {
            //             isValid = false;
            //             alert("Entry " + inputFields[a].name + " contains invalid sequence!!");
            //             return;
            //         }
                    
            //         if(Array.isArray(array))
            //         {
            //             let zeroLength = array.length > 0
            //             let tooLong = array.length < 17
            //             let dupe = (new Set(array).size == array.length);
            //             let notNumber = (array.every(e => !isNaN(parseInt(e, 10)) && (e >=0 && e < 17)));


            //             let isNumberValid = zeroLength && tooLong && dupe && notNumber;

            //             if(isNumberValid)
            //                 continue;
            //             else
            //             {
            //                 isValid = false;
            //                 alert("Entry " + inputFields[a].name + " contains invalid sequence!!\n - Not allowed just [].\n- Must start/end with [ and ].\n- Seperated by comma, Values betwenn 0 and 16.\n- No duplicated values.");
            //                 return;
            //             }
            //         }
            //     }
            //     else {
            //         isValid = false;
            //         alert("Entry " + inputFields[a].name + " contains invalid sequence!!");
            //         return;
            //     }
            // }
        }
    }

    if(isValid)
    {
        document.getElementById("myForm").submit();
        return;
    }

    alert("Validation not successful");
}

function refresh()
{
    location.reload();
}


</script>
</body>
</html>
