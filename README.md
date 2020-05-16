init.php - creates tables "menu", "tables", "status", "orders"

menu.php -  addToMenu (string $name, int $price, mysqli $conn) - adds to the table "menu" record

            showMenu (mysqli $conn) - shows all the records in the table "menu"
            
order.php -  changeStatus(int $id, string $status, mysqli $conn) - changes order status

             addOrder(array $menu, array $count, int $table, mysqli $conn) - adds order
             
             showOrder(mysqli $conn) - shows all the records in the table "orders"
             
             getCheck(int $id, mysqli $conn) - completes the order and displays a check
             
table.php - addTable (int $capacity, mysqli $conn) - adds to the table "tables" record
            
            showTables(mysqli $conn) - shows all the records in the table "tables"
