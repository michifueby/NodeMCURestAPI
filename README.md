# NodeMCU-REST-API

## Database Structure
```sql
create table TBL_Sensor
(
    macaddress  varchar(100)                 null,
    temperature decimal(5, 2)                null,
    humidity    varchar(100)                 null,
    time        int default unix_timestamp() null
);
```

## Get Data from Sensor with GET
```php
$macaddress = ($_GET["id"]);
$temperature = ($_GET["temperature"]);
$humidity = ($_GET["humidity"]);
```

## Display data with data-tables
https://datatables.net

## Hardware

![alt text](https://github.com/michifueby/NodeMCURestAPI/blob/main/NodeMCUBoardWithDHT11.png?raw=true)

