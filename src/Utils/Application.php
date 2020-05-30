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
    echo PHP_EOL . "Table was added";
    }
    $table->show();
    $arrayOfOrder = array(2 => array ("menu" => array("meat broth","tee"), "count" => array(2,1)));
    $order = new \Entities\Order();
    if ($order->add($arrayOfOrder)) {
    echo PHP_EOL . "Order was added";
    }
    $order->show();
    }
}