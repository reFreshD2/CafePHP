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
    $menu->add($arrayOfMenu);
    $menu->show();
    $table = new \Entities\Table();
    $arrayOfTable = array(1,3,2,1);
    $table->add($arrayOfTable);
    $table->show();
    }
}