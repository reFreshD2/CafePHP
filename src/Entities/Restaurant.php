<?php

declare(strict_types=1);

namespace Entities;

class Restaurant
{
    private $menu;
    private $table;
    private $order;

    private function updateStatus() : void {
        foreach ($this->order->getStatus() as $key => $value) {
            if ($value == "accepted") {
                $this->table->setStatus($key, "served");
            }
        }
        unset($key);
        unset($value);
    }

    public function __construct(Menu $menu, Table $table, Order $order)
    {
        $this->menu = $menu;
        $this->table = $table;
        $this->order = $order;
        $this->updateStatus();
    }

    public function addMenu(array $menu) : bool {
        $result = false;
        if ($this->menu->add($menu)) {
            $result = true;
        }
        return $result;
    }

    public function showMenu() : void {
        $this->menu->show();
    }

    public function addTable(array $table) : bool {
        $result = false;
        if ($this->table->add($table)) {
            $result = true;
        }
        return $result;
    }

    public function showTable() : void {
        $this->table->show();
    }

    public function addOrder(array $order) : bool {
        $result = false;
        if ($this->order->add($order)) {
            $result = true;
            $this->updateStatus();
        }
        return $result;
    }

    public function showOrder() : void {
        $this->order->show();
    }

    public function getCheck(int $id) {
        
    }
}