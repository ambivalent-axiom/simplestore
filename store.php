<?php
//init
$json_data = file_get_contents('stock.json');
$stock = json_decode($json_data);
include 'functions.php';
$client = null;
cls();
printLogo();
printHeading("NARVESEN");
printMenu();
printClientStats();

//main loop
while(true) {

    while(true) {
        $select = readline("Please choose Your action (0-5): ");
        if(is_numeric($select) && $select >= 0 && $select <= 5) {
            break;
        }
        echo colorize("Input must be an integer type digit from 0-5!\n", 31);
    }

    switch($select) {

        case 0:
            echo "Exit chosen!\n";
            exit;

        case 1:
            cls();
            printHeading("REGISTRATION");
            $client = register();
            printMenuAndStats($client);
            echo colorize("User check-in successful!\n", 36);
            break;

        case 2:
            printMenuAndStats($client);
            printHeading("CURRENT STOCK");
            printStock($stock);
            break;

        case 3:
            if(isset($client)) {
                printMenuAndStats($client);
                printHeading("$client->name's Shopping Cart");
                printCart($client->shoppingCart, $client->name);
            } else {
                echo colorize("Unregistered user cannot shop. Please register first!\n", 31);
            }
            break;

        case 4:
            if(isset($client)) {
                cls();
                printHeading("ADD TO CART");
                printStock($stock);
                $client->shoppingCart[] = addToCart($stock);
                printMenuAndStats($client);
                echo colorize("Successfully added to cart!\n", 36);
            } else {
                echo colorize("Unregistered user cannot shop. Please register first!\n", 31);
            }
            break;

        case 5:
            if(isset($client)) {
                cls();
                printHeading("CHECKOUT");
                printCart($client->shoppingCart, $client->name);
                $result = checkOut($stock, $client);
                cls();
                printMenuAndStats($client);
                echo $result . "\n";
            } else {
                echo colorize("Unregistered user cannot shop. Please register first!\n", 31);
            }
            break;

        default:
            break;
    }
}


