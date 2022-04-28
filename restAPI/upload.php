<!--    Autor:  MF              -->
<!--    File:   upload.php      -->
<?php
// Load sql config
include('../config.php');

// Get Data
$macaddress = makeReal_escape_string(($_GET["id"]));
$temperature = makeReal_escape_string(($_GET["temperature"]));
$humidity = makeReal_escape_string(($_GET["humidity"]));

if ($macaddress != null) {
    insertValues($macaddress, $temperature, $humidity );
}

// Make real_escape_string
function makeReal_escape_string($input) {
    if(is_array($input))
        return array_map(__METHOD__, $input);

    if(!empty($input) && is_string($input)) {
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $input);
    }

    return $input;
}

// Insert values in database
function insertValues($macaddress, $temperature, $humidity) 
{
    $mysql = new mysql();
    
    $result = $mysql->query('INSERT INTO fueby.TBL_Sensor (macaddress, temperature, humidity) VALUES ("' . strtoupper($macaddress) . '",' . $temperature . ',"' . $humidity . '")');

    if ($result) 
    {
        print("New record created successfully!");
    }
    else 
    {
        print("Something went wrong!</br>");
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.semanticui.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.8/semantic.min.css"/>
    <title>Sensor Data</title>
</head>
<body>
    <div class="headline" style="text-align:center">
        <h1>Sensor readings</h1>
    </div>
    <table id="tbl_sensordata" class="cell-border compact stripe" style="width:100%; text-align: center;">
        <thead>
            <tr>
                <th>MacAddress</th>
                <th>Temperature</th>
                <th>Humidity</th>
                <th>Time</th>
            </tr>
        </thead>
    </table>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
<script>
jQuery(document).ready(function($) {
    $('#tbl_sensordata').DataTable( {
        "processing": true,
        "ajax": {
                "url": "getData.php",
                "type": "GET"
            },
            "columns": [
                {data: 'macaddress'},
                {data: 'temperature'},
                {data: 'humidity'},
                {data: 'time'}
            ]
    } );
} );
</script>
</html>
