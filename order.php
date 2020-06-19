<?php
$host = '127.0.0.1';
$username = 'restaurant';
$pass = 'password';
$db = 'cafe';
$connection = new mysqli($host, $username, $pass, $db);

function changeStatus(int $id, string $status, mysqli $conn)
{
    if ($conn->query("UPDATE status SET status=\"$status\" where id_order=$id")) {
        echo "Status of order $id was changed to $status\n";
    } else {
        echo "Status of order $id wasn't changed to $status\n";
    }
}

function addOrder(array $menu, array $count, int $table, mysqli $conn)
{
    $conn->query("INSERT INTO status(id_table) VALUES ($table)");
    $conn->query("UPDATE tables SET status=\"served\" where id=$table");
    $id = $conn->query("SELECT COUNT(*) FROM status")->fetch_assoc()['COUNT(*)'];
    for ($i = 0; $i < count($menu); $i++) {
        $food = $conn->query("SELECT id FROM menu WHERE name=\"$menu[$i]\"")->fetch_assoc()['id'];
        $conn->query("INSERT INTO orders(id,id_menu,count) VALUES ($id,\"$food\",$count[$i])");
    }
}

function showOrder(mysqli $conn)
{
    $res = $conn->query("SELECT * FROM status");
    while ($row = $res->fetch_assoc()) {
        echo PHP_EOL . $row['id_order'] . ' ' . $row['id_table'] . ' ' . $row['status'] . "\n";
    }
}

function getCheck(int $id, mysqli $conn)
{
    echo "\t Order $id\n";
    $total = 0;
    $res = $conn->query("SELECT name,price,count FROM menu join orders on menu.id=orders.id_menu WHERE orders.id=$id");
    while ($row = $res->fetch_assoc()) {
        echo $row['name'] . "\t" . $row['price'] . '*' . $row['count'] . "\n";
        $total = $total + $row['price'] *$row['count'];
    }
    echo "Total: \t". $total ."\n";
    if ($conn->query("UPDATE status SET status=\"completed\" where id_order=$id")) {
        echo "Status of order $id was changed to \"completed\"\n";
    } else {
        echo "Status of order $id wasn't changed to \"completed\"\n";
    }
    $table = $conn->query("SELECT id_table FROM status where id_order=$id")->fetch_assoc()['id_table'];
    if ($conn->query("UPDATE table SET status=\"free\" where id_order=$table")) {
        echo "Status of table  was changed to \"free\"\n";
    } else {
        echo "Status of table  wasn't changed to \"free\"\n";
    }
}

$food = array('chicken noodles','tee');
$count = array(1,2);
addOrder($food,$count,1,$connection);
showOrder($connection);
getCheck(9,$connection);