<?php
$host = '127.0.0.1';
$username = 'restaurant';
$pass = 'password';
$db = 'cafe';
$connection = new mysqli($host,$username,$pass,$db);

if($connection->query("CREATE TABLE menu(
   id INT AUTO_INCREMENT,
   name VARCHAR(20) NOT NULL,
   price INT NOT NULL,
   primary key (id)
)")){
    echo "Table @menu created successfully\n";
} else {
    echo "Table @menu is not created successfully\n";
}

if($connection->query("CREATE TABLE tables(
   id INT AUTO_INCREMENT,
   capacity INT NOT NULL,
   status VARCHAR(20) NOT NULL DEFAULT 'free',
   primary key (id)
)")){
    echo "Table @tables created successfully\n";
} else {
    echo "Table @tables is not created successfully\n";
}

if($connection->query("CREATE TABLE status(
   id_order INT AUTO_INCREMENT,
   id_table INT NOT NULL,
   status VARCHAR(20) NOT NULL DEFAULT 'accepted',
   primary key (id_order),
   FOREIGN KEY (id_table)  REFERENCES tables (id)
)")){
    echo "Table @status created successfully\n";
} else {
    echo "Table @status is not created successfully\n";
}

if($connection->query("CREATE TABLE orders(
   id INT NOT NULL,
   id_menu INT NOT NULL,
   count INT NOT NULL,
   FOREIGN KEY (id_menu)  REFERENCES menu (id),
   FOREIGN KEY (id)  REFERENCES status (id_order)
)")){
    echo "Table @orders created successfully\n";
} else {
    echo "Table @orders is not created successfully\n";
}

$connection->close();
