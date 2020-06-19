<?php

declare(strict_types=1);

namespace MyRest\Utils;

class App
{
    private $twig;
    private $infoLogger;

    public function __construct()
    {
        $this->twig = new \Twig\Environment(
            new \Twig\Loader\FilesystemLoader([dirname(__DIR__, 2) . '/templates'])
        );
        $this->infoLogger = new \Monolog\Logger('SQL-logger');
        $this->infoLogger->pushHandler(new \Monolog\Handler\StreamHandler(dirname(__DIR__,2) . '/logs/SQL.log', \Monolog\Logger::INFO));
    }

    public function run(): void
    {
        $path = $_SERVER['REQUEST_URI'];
        echo $path;
        if ($path == '/addToMenu') {
            echo $this->twig->render('menuAdd.twig', ['title' => 'Menu', 'script' => dirname(__DIR__) . '/DB/Menu.php']);
        }
    }
}