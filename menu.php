<?php
$host = '127.0.0.1';
$username = 'restaurant';
$pass = 'password';
$db = 'cafe';
$connection = new mysqli($host,$username,$pass,$db);

function addToMenu (string $name, int $price, mysqli $conn) {
    if($conn->query("INSERT INTO menu(name, price) VALUES (\"$name\",$price)")){
        echo "Entry [".$name .' '. $price ."] added to table\n";
    } else {
        echo "Entry [".$name .' '. $price ."] added to table\n";
    }
}

function showMenu (mysqli $conn) {
    $res = $conn->query("SELECT name, price FROM menu");
    while ($row = $res->fetch_assoc()) {
        echo PHP_EOL . $row['name'] . ' ' . $row['price'] ."\n";
    }
}

$names = array('chicken noodles','meat broth','steak','chicken legs','milk shake', 'coffee','tee');
$prices = array(110,150,220,120,80,150,50);

for ($i = 0; $i < 7; $i++) {
    addToMenu($names[$i],$prices[$i],$connection);
}
showMenu($connection);
$connection->close();