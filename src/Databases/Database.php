<?php

declare(strict_types=1);

namespace Databases;

use mysqli;
use Entities\Restaurant;
use Entities\Order;

class Database
{
    private $nameDB;
    private $restaurant;

    private function initDB(): void
    {
        $host = '127.0.0.1';
        $username = 'super';
        $pass = 'password';
        $connection = new mysqli($host, $username, $pass);
        $name = mysqli_real_escape_string($connection, $this->nameDB);
        $connection->query("CREATE DATABASE $name");
        mysqli_close($connection);
        $connection = $this->setConnection();
        $connection->query("CREATE TABLE menu(id INT AUTO_INCREMENT,name VARCHAR(20) NOT NULL,price INT NOT NULL,primary key (id))");
        $connection->query("CREATE TABLE tables(id INT AUTO_INCREMENT,capacity INT NOT NULL,status VARCHAR(20) NOT NULL DEFAULT 'free',primary key (id))");
        $connection->query("CREATE TABLE status(id_order INT AUTO_INCREMENT,id_table INT NOT NULL,status VARCHAR(20) NOT NULL DEFAULT 'accepted',primary key (id_order),FOREIGN KEY (id_table)  REFERENCES tables (id))");
        $connection->query("CREATE TABLE orders(id INT NOT NULL,id_menu INT NOT NULL,count INT NOT NULL,FOREIGN KEY (id_menu)  REFERENCES menu (id),FOREIGN KEY (id)  REFERENCES status (id_order))");
        mysqli_close($connection);
    }

    private function setConnection(): \mysqli
    {
        $host = '127.0.0.1';
        $username = 'super';
        $pass = 'password';
        return new mysqli($host, $username, $pass, $this->nameDB);
    }

    private function fillInDB(): void
    {
        $menu = $this->restaurant->getMenu();
        $name = $menu->getName();
        $array = array();
        foreach ($name as $value) {
            $array[$menu->getPrice($value)] = $value;
        }
        unset($value);
        $this->addMenu($array);
        $table = $this->restaurant->getTable();
        $this->addTable($table->getTable());
        for ($i = 0; $i < count($table->getTable()); $i++) {
            if ($table->getStatus($i) != "free") {
                $this->setTableStatus($i + 1, $table->getStatus($i));
            }
        }
        $order = $this->restaurant->getOrder();
        $this->fillOrder($order);
    }

    private function fillOrder(Order $order): void
    {
        $connection = $this->setConnection();
        foreach ($order->getOrder() as $table => $array) {
            $status = $order->getStatus()[$table];
            $status = mysqli_real_escape_string($connection, $status);
            $connection->query("INSERT INTO status(id_table, status) VALUES ($table+1, \"$status\")");
            $id = $connection->query("SELECT COUNT(*) FROM status")->fetch_assoc()['COUNT(*)'];
            $menu = $array["menu"];
            $count = $array["count"];
            for ($i = 0; $i < count($menu); $i++) {
                $escOfMenu = mysqli_real_escape_string($connection, $menu[$i]);
                $food = $connection->query("SELECT id FROM menu WHERE name=\"$escOfMenu\"")->fetch_assoc()['id'];
                $connection->query("INSERT INTO orders(id,id_menu,count) VALUES ($id,\"$food\",$count[$i])");
            }
        }
        unset($table);
        unset($array);
        mysqli_close($connection);
    }

    private function setTableStatus(int $table, string $status): void
    {
        $connection = $this->setConnection();
        $status = mysqli_real_escape_string($connection, $status);
        $connection->query("UPDATE tables SET status=\"$status\" where id=$table");
        mysqli_close($connection);
    }

    private function setOrderStatus(int $id, string $status): void
    {
        $connection = $this->setConnection();
        $status = mysqli_real_escape_string($connection, $status);
        $connection->query("UPDATE status SET status=\"$status\" where id_table=$id");
        mysqli_close($connection);
    }

    public function __construct(string $name, Restaurant $restaurant)
    {
        $this->nameDB = $name;
        $this->restaurant = $restaurant;
        $this->initDB();
        $this->fillInDB();
    }

    public function addMenu(array $menu): bool
    {
        $connection = $this->setConnection();
        $result = false;
        foreach ($menu as $key => $value) {
            $value = mysqli_real_escape_string($connection, $value);
            if ($connection->query("INSERT INTO menu(name, price) VALUES (\"$value\",$key)")) {
                $result = true;
            }
        }
        mysqli_close($connection);
        return $result;
    }

    public function showMenu(): void
    {
        $connection = $this->setConnection();
        $res = $connection->query("SELECT name, price FROM menu");
        while ($row = $res->fetch_assoc()) {
            echo PHP_EOL . $row['name'] . ' ' . $row['price'];
        }
        echo PHP_EOL;
        mysqli_close($connection);
    }

    public function addTable(array $capacity): bool
    {
        $connection = $this->setConnection();
        $result = false;
        for ($i = 0; $i < count($capacity); $i++) {
            if ($connection->query("INSERT INTO tables(capacity) VALUES ($capacity[$i])")) {
                $result = true;
            }
        }
        mysqli_close($connection);
        return $result;
    }

    public function showTable(): void
    {
        $connection = $this->setConnection();
        $res = $connection->query("SELECT * FROM tables");
        while ($row = $res->fetch_assoc()) {
            echo PHP_EOL . $row['id'] . ' ' . $row['capacity'] . ' ' . $row['status'];
        }
        echo PHP_EOL;
        mysqli_close($connection);
    }

    public function addOrder(array $order): bool
    {
        $connection = $this->setConnection();
        $result = false;
        foreach ($order as $table => $array) {
            $connection->query("INSERT INTO status(id_table) VALUES ($table)");
            $this->setTableStatus($table, "served");
            $id = $connection->query("SELECT COUNT(*) FROM status")->fetch_assoc()['COUNT(*)'];
            $menu = $array["menu"];
            $count = $array["count"];
            for ($i = 0; $i < count($menu); $i++) {
                $escOfMenu = mysqli_real_escape_string($connection, $menu[$i]);
                $food = $connection->query("SELECT id FROM menu WHERE name=\"$escOfMenu\"")->fetch_assoc()['id'];
                if ($connection->query("INSERT INTO orders(id,id_menu,count) VALUES ($id,\"$food\",$count[$i])")) {
                    $result = true;
                }
            }
        }
        unset($table);
        unset($array);
        mysqli_close($connection);
        return $result;
    }

    public function showOrder()
    {
        $connection = $this->setConnection();
        $res = $connection->query("SELECT * FROM status");
        while ($row = $res->fetch_assoc()) {
            echo PHP_EOL . $row['id_order'] . ' ' . $row['id_table'] . ' ' . $row['status'];
        }
        echo PHP_EOL;
        mysqli_close($connection);
    }

    public function getCheck(int $table)
    {
        echo "\t Order $table\n";
        $total = 0;
        $connection = $this->setConnection();
        $res = $connection->query("SELECT id_order FROM status where id_table= $table and status=\"accepted\"");
        $id = $res->fetch_assoc()['id_order'];
        $res = $connection->query("SELECT name,price,count FROM menu join orders on menu.id=orders.id_menu WHERE orders.id=$id");
        while ($row = $res->fetch_assoc()) {
            echo $row['name'] . "\t" . $row['price'] . '*' . $row['count'] . "\n";
            $total = $total + $row['price'] * $row['count'];
        }
        echo "Total: \t" . $total . "\n";
        $this->setOrderStatus($table, "completed");
        $this->setTableStatus($table, "free");
        mysqli_close($connection);
    }
}