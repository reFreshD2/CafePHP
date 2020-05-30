<?php

declare(strict_types=1);

namespace Entities;

class Order extends Entity {
    private $countOfOrder = 0;
    private $order;
    private $status;

    public function add(array $params) : bool {
        $result = true;
        $count = $this->countOfOrder;
        foreach ($params as $key => $value) {
            $this->order[$key] = $value;
            $this->status[$key] = "accepted";
            $this->countOfOrder++;
        }
        if ($count == $this->countOfOrder) {
            $result = false;
        }
        return $result;
    }

    public function show() : void {
        foreach ($this->order as $key => $value) {
            echo PHP_EOL . "Order for table " . $key . ' ' . $this->status[$key];
            for ($i = 0; $i < count($value["menu"]); $i++) {
                echo PHP_EOL . $value["menu"][$i] . "\t" . $value["count"][$i];
            }
        }
        echo PHP_EOL;
        unset($key);
        unset($value);
    }

    public function getStatus() : array {
        return $this->status;
    }
}