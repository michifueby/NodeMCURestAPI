# NodeMCU-REST-API

## Database Structure
```sql
create table TBL_Sensor
(
    macaddress  varchar(100)                 null,
    temperature decimal(5, 2)                null,
    humidity    decimal(5, 2)                null,
    time        int default unix_timestamp() null
);
```

## Get Data from Sensor with GET
```php
($_GET["id"])
($_GET["temperature"])
($_GET["humidity"])
```

## Display data with data-tables
https://datatables.net

## Hardware

- Board:     NodeMCU Board
- Sensor:   DHT11

![alt text](https://github.com/michifueby/NodeMCURestAPI/blob/main/NodeMCUBoardWithDHT11.png?raw=true)

