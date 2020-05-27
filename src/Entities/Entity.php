<?php

declare(strict_types=1);

namespace Entities;

abstract class Entity {
    abstract public function add(array $params) : bool;
    abstract public function show() : void;
}