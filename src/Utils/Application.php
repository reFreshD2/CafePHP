<?php

declare(strict_types=1);

namespace Utils;

class Application {

public function run(): void
    {
        $menu = new \Entities\Menu();
        $arrayOfMenu = array(200 => "chicken noodles",
        150 => "meat broth",
        80 => "tee");
        if ($menu->add($arrayOfMenu)) {
            echo PHP_EOL . "Menu was added";
        }
        $menu->show();
        $table = new \Entities\Table();
        $arrayOfTable = array(1,3,2,1);
        if ($table->add($arrayOfTable)) {
            echo PHP_EOL . "Tables were added";
        }
        $table->show();
        $arrayOfOrder = array(2 => array ("menu" => array("meat broth","tee"), "count" => array(2,1)));
        $order = new \Entities\Order();
        if ($order->add($arrayOfOrder)) {
            echo PHP_EOL . "Orders were added";
        }
        $order->show();
        $restaurant = new \Entities\Restaurant($menu,$table,$order);
        echo PHP_EOL . "We're in restaurant";
        $restaurant->showMenu();
        $coffee = array (140 => "espresso",
        180 => "latte");
        if ($restaurant->addMenu($coffee)){
            echo PHP_EOL . "Coffee was added to menu";
        }
        $restaurant->showMenu();
        $restaurant->showTable();
        $newTable = array (4,2);
        if ($restaurant->addTable($newTable)){
            echo PHP_EOL . "New tables were added";
        }
        $restaurant->showTable();
        $restaurant->showOrder();
        $newOrder = array (4 => array ("menu" => array("latte"), "count" => array(4)));
        if ($restaurant->addOrder($newOrder)) {
            echo PHP_EOL . "New order was added";
        }
        $restaurant->showOrder();
        $restaurant->showTable();
        $restaurant->getCheck(2);
        $restaurant->showOrder();
        $restaurant->showTable();
        echo PHP_EOL . "We're in database";
        $db = new \Databases\Database("Pyatachok", $restaurant);
        $db->showMenu();
        $db->showTable();
        $db->showOrder();
        $newMenu = array (50 => "nachos",
        75 => "rise");
        if ($db->addMenu($newMenu)) {
            echo PHP_EOL . "New menu was added to db";
        }
        $db->showMenu();
        $someTable = array (3,1);
        if ($db->addTable($someTable)) {
            echo PHP_EOL . "Some table were added to db";
        }
        $db->showTable();
        $newOrder = array (1 => array ("menu" => array("chicken noodles","rise"), "count" => array(1,1)));
        if ($db->addOrder($newOrder)) {
            echo PHP_EOL . "New order was added to db";
        }
        $db->showOrder();
        $db->getCheck(5);
        $db->showTable();
        $db->showOrder();
    }
}