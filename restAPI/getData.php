<!--    Autor:  MF              -->
<!--    File:   getData.php      -->
<?php
include('../config.php');

// fetch records
$mysql = new mysql();
$result = $mysql->get('select * from fueby.TBL_Sensor;');

$dataset = array(
    "echo" => 1,
    "totalrecords" => count($result),
    "totaldisplayrecords" => count($result),
    "data" => $result
);

echo json_encode($dataset);