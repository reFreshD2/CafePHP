<?php

declare(strict_types=1);

namespace Entities;

class Menu extends Entity
{
    private $name;
    private $price;
    private $count = 0;

    public function add(array $params): bool
    {
        $result = true;
        $count = $this->count;
        foreach ($params as $key => $value) {
            $this->name[$this->count] = $value;
            $this->price[$this->count] = $key;
            $this->count++;
        }
        unset($value);
        unset($key);
        if ($count == $this->count) {
            $result = false;
        }
        return $result;
    }

    public function show(): void
    {
        for ($i = 0; $i < $this->count; $i++) {
            echo PHP_EOL . $this->name[$i] . ' cost ' . $this->price[$i];
        }
        echo "\n";
    }
}