<?php

declare(strict_types=1);

namespace Entities;

class Restaurant
{
    private $menu;
    private $table;
    private $order;

    private function updateStatus(): void
    {
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

    public function addMenu(array $menu): bool
    {
        $result = false;
        if ($this->menu->add($menu)) {
            $result = true;
        }
        return $result;
    }

    public function showMenu(): void
    {
        $this->menu->show();
    }

    public function addTable(array $table): bool
    {
        $result = false;
        if ($this->table->add($table)) {
            $result = true;
        }
        return $result;
    }

    public function showTable(): void
    {
        $this->table->show();
    }

    public function addOrder(array $order): bool
    {
        $result = false;
        if ($this->order->add($order)) {
            $result = true;
            $this->updateStatus();
        }
        return $result;
    }

    public function showOrder(): void
    {
        $this->order->show();
    }

    public function getCheck(int $table): void
    {
        foreach ($this->order->getStatus() as $key => $value) {
            if ($key == $table && $value == "accepted") {
                echo "\t Order for $table\n";
                $menu = $this->order->getMenu($table);
                $count = $this->order->getCount($table);
                $total = 0;
                for ($i = 0; $i < count($menu); $i++) {
                    echo PHP_EOL . $menu[$i] . "\t\t" . $this->menu->getPrice($menu[$i]) . "*" . $count[$i];
                    $total = $total + $this->menu->getPrice($menu[$i]) * $count[$i];
                }
                echo PHP_EOL . "Total: \t" . $total . "\n";
                $this->order->setStatus($table, "completed");
                $this->table->setStatus($table, "free");
            }
        }
    }

    public function getMenu() : Menu {
        return $this->menu;
    }

    public function getTable() : Table {
        return $this->table;
    }

    public function getOrder() : Order {
        return $this->order;
    }
}