<?php

declare(strict_types=1);

function my_autoloader($className)
{
    require_once __DIR__ . '/src/' . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
}

spl_autoload_register('my_autoloader');