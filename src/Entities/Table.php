<?php

declare(strict_types=1);

namespace Entities;

class Table extends Entity {
    private $capacity;
    private $status;
    private $count = 0;

    public function add(array $params) : bool {
        $result = true;
        $count = $this->count;
        foreach ($params as $value) {
            $this->capacity[$this->count] = $value;
            $this->status[$this->count] = "free";
            $this->count++;
        }
        unset($value);
        if ($count == $this->count) {
            $result = false;
        }
        return $result;
    }

    public function show() : void {
        for ($i = 0; $i < $this->count; $i++) {
            echo PHP_EOL . 'Table '. $i . ' have capacity ' . $this->capacity[$i] . ' and it\'s ' . $this->status[$i];
        }
        echo PHP_EOL;
    }

    public function setStatus(int $id, string $status) : void {
        $this->status[$id] = $status;
    }

    public function getTable() : array {
        return $this->capacity;
    }

    public function getStatus(int $id) {
        return $this->status[$id];
    }
}