<?php
$host = '127.0.0.1';
$username = 'restaurant';
$pass = 'password';
$db = 'cafe';
$connection = new mysqli($host,$username,$pass,$db);

function addTable (int $capacity, mysqli $conn) {
    if($conn->query("INSERT INTO tables(capacity) VALUES ($capacity)")){
        echo "Entry [$capacity] added to table\n";
    } else {
        echo "Entry [$capacity] added to table\n";
    }
}

function showTables(mysqli $conn) {
    $res = $conn->query("SELECT * FROM tables");
    while ($row = $res->fetch_assoc()) {
        echo PHP_EOL . $row['id'] . ' ' . $row['capacity'] .' '. $row['status']."\n";
    }
}

$capacity = array(2,5,4,2,4,1,1);
for ($i = 0; $i < 7; $i++) {
    addTable($capacity[$i],$connection);
}
showTables($connection);
$connection->close();