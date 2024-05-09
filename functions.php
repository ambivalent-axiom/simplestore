<?php
function newClient(string $name, int $money, array $shoppingCart, string $status): stdClass {
    $client = new stdClass();
    $client->name = $name;
    $client->money = $money;
    $client->shoppingCart = $shoppingCart;
    $client->status = $status;
    return $client;
}
function addProduct(string $name, int $quantity, int $price): stdClass {
    $ware = new stdClass();
    $ware->name = $name;
    $ware->quantity = $quantity;
    $ware->price = $price;
    return $ware;
}
function colorize(string $string, int $color): string {
    return "[{$color}m{$string}[0m";
}
function whatHeCanAfford(array $stock, stdClass $client): array {
    $canBuy = [];
    foreach ($stock as $ware) {
        if ($client->money >= $ware->price) {
            $canBuy[] = $ware;
        }
    }
    return $canBuy;
}
function writeStockToFile(array $stock): void {
    $json_data = json_encode($stock);
    file_put_contents('stock.json', $json_data);
}
function printStock(array $stock): void {
    echo colorize("┌", 0) .  colorize(str_repeat("─",73), 0) . "┐\n";
    echo " ► ind ◄▄▀▄▀▄▀▄▀▄▀►   Product   ◄▄▀▄▀▄▀▄▀▄▀► Stock ◄▄▀▄▀▄▀▄▀▄▀►  Price   ◄" . "\n";
    for($i=0; $i<count($stock); $i++) {
        echo " ► " . colorize($i, 35) . str_repeat(" ", 4 - strlen($i)) . "◄";
        echo "▄▀▄▀▄▀▄▀▄▀";
        echo "► " .
            str_repeat(" ",floor((11 - strlen($stock[$i]->name))/2)) .
            colorize($stock[$i]->name, 33) .
            str_repeat(" ",ceil((11 - strlen($stock[$i]->name))/2)) .
            " ◄";
        echo "▄▀▄▀▄▀▄▀▄▀";
        echo "► " . str_repeat(" ",5 - strlen($stock[$i]->quantity)) . colorize($stock[$i]->quantity, 31) . " ◄";
        echo "▄▀▄▀▄▀▄▀▄▀";
        echo "►  " . "€" .
            colorize(formatPrice($stock[$i]->price), 32) .
            str_repeat(" ",7 - strlen(formatPrice($stock[$i]->price))) .
            "◄ ";
        echo "\n";
    }
    echo colorize("╚", 0) .  colorize(str_repeat("═",73), 0) . "╝\n";
}
function printCart(array $cart, string $name): void {
    echo colorize("┌", 0) .  colorize(str_repeat("─",73), 0) . "┐\n";
    echo " ► ind ◄▄▀▄▀▄►   Product   ◄▄▀▄▀▄►  Qtt  ◄▄▀▄▀▄►  Price  ◄▄▀▄▀▄►   Sum   ◄" . "\n";
    $total = 0;
    for($i=0; $i<count($cart); $i++) {
        $total += $cart[$i]->price * $cart[$i]->quantity;
        echo " ► " . colorize($i, 35) . str_repeat(" ", 4 - strlen($i)) . "◄";
        echo "▄▀▄▀▄";
        echo "► " .
            str_repeat(" ",floor((11 - strlen($cart[$i]->name))/2)) .
            colorize($cart[$i]->name, 33) .
            str_repeat(" ",ceil((11 - strlen($cart[$i]->name))/2)) .
            " ◄";
        echo "▄▀▄▀▄";
        echo "► " . str_repeat(" ",5 - strlen($cart[$i]->quantity)) . colorize($cart[$i]->quantity, 31) . " ◄";
        echo "▄▀▄▀▄";
        echo "► " . "€" .
            colorize(number_format($cart[$i]->price/100, 2, ',', ''), 32) .
            str_repeat(" ",7 - strlen(formatPrice($cart[$i]->price))) .
            "◄";
        echo "▄▀▄▀▄";
        echo "► " . "€" .
            colorize(number_format(($cart[$i]->price * $cart[$i]->quantity)/100, 2, ',', ''), 32) .
            str_repeat(" ",7 - strlen(formatPrice($cart[$i]->price * $cart[$i]->quantity))) .
            "◄";
        echo "\n";
    }
    echo colorize("╚", 0) .  colorize(str_repeat("═",73), 0) . "╝\n";
    echo "   {$name}'s shopping cart" . str_repeat("჻",39 - strlen($name)) . "Total: €" .
        number_format(($total/100), 2, ',', '') . "\n";
}
function printLogo(): void {
    echo "                                                                                     \n";
    echo "         ,--.                                                                        \n";
    echo "       ,--.'|                                                                        \n";
    echo "   ,--,:  : |                                                                        \n";
    echo ",`--.'`|  ' :             __  ,-.                                             ,---,  \n";
    echo "|   :  :  | |           ,' ,'/ /|    .---.           .--.--.              ,-+-. /  | \n";
    echo ":   |   \ | :  ,--.--.  '  | |' |  /.  ./|  ,---.   /  /    '     ,---.  ,--.'|'   | \n";
    echo "|   : '  '; | /       \ |  |   ,'.-' . ' | /     \ |  :  /`./    /     \|   |  ,'' | \n";
    echo "'   ' ;.    ;.--.  .-. |'  :  / /___/ \: |/    /  ||  :  ;_     /    /  |   | /  | | \n";
    echo "|   | | \   | \__\/: . .|  | '  .   \  ' .    ' / | \  \    `. .    ' / |   | |  | | \n";
    echo "'   : |  ; .' ,\" .--.; |;  : |   \   \   '   ;   /|  `----.   \'   ;   /|   | |  |/ \n";
    echo "|   | '`--'  /  /  ,.  ||  , ;    \   \  '   |  / | /  /`--'  /'   |  / |   | |--'   \n";
    echo "'   : |     ;  :   .'   \---'      \   \ |   :    |'--'.     / |   :    |   |/       \n";
    echo ";   |.'     |  ,     .-./           '---\" \   \  /   `--'---'   \   \  /'---'       \n";
    echo "'---'        `--`---'                      `----'                `----'              \n";
    echo "                                                                                     \n";
}
function printMenu(): void {
    echo colorize("╔", 0) .  colorize(str_repeat("═",73), 0) . "╗\n";
    $items = ['Exit', 'Register', 'Show Stock', 'Show Cart', 'Add to Cart', 'Checkout'];
    for($i=0; $i<count($items); $i++) {
        $color = random_int(31, 39);
        $string = $i . " " . $items[$i];
        echo " ׂ   ╰┈➤ " . colorize($string, $color) . str_repeat(" ", 15 - strlen($string));
        if($i == 2) {
            echo "\n";
        }
    }
    echo "\n";
    echo colorize("╚", 0) .  colorize(str_repeat("═",73), 0) . "╝\n";


}
function formatPrice($price): string {
    return number_format($price/100, 2, ',', '');
}
function getCartSum(array $cart): int {
    $total = 0;
    for($i=0; $i<count($cart); $i++) {
        $total += $cart[$i]->price * $cart[$i]->quantity;
    }
    return $total;
}
function printClientStats(stdClass $client=null): void {
    if(isset($client)) {
        $name = $client->name;
        $balance = $client->money;
        $cart = getCartSum($client->shoppingCart);
    } else {
        $name = "Unregistered";
        $balance = 0;
        $cart = 0;
    }
    echo colorize("   Client: ", 0) .
        colorize($name, 33) .
        str_repeat(" ",20 - strlen($name)) .
        "Balance: €" . formatPrice($balance) .
        str_repeat(" ",15 - strlen(formatPrice($balance))) .
        "In cart: €" . formatPrice($cart ) . "\n";
}
function cls(): void {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        system('cls');
    } else {
        system('clear');
    }
}
function register(): stdClass {
    while(true) {
        $name = readline("Please choose Your name or alias 0-10 chars: ");
        if(strlen($name) <= 10) {
            break;
        }
        echo colorize("Input must be no longer then 10 chars!\n", 31);
    }
    while(true) {
        $money = (int) readline("How much money would you like to spend in Euros (1-1000): ");
        if($money >= 1 && $money <= 1000) {
            break;
        }
        echo colorize("Input must be integer between 1 and 1000\n", 31);
    }
    return newClient($name, $money*100, [], 'shopper');
}
function addToCart(array $stock): stdClass {
    $stockLen = count($stock) - 1;
    while(true) {
        $select = readline("Please choose the product ID (0-$stockLen): ");
        if(is_numeric($select) && $select >= 0 && $select <= $stockLen) {
            if($stock[$select]->quantity <= 0) {
                echo colorize("Sorry, this product is currently out of stock!\n", 31);
                continue;
            }
            break;
        }
        echo colorize("Input must be an integer type digit from 0-$stockLen!\n", 31);
    }
    $inStock = $stock[$select]->quantity;
    while(true) {
        $quantity = readline("Please select the quantity (0-$inStock): ");
        if(is_numeric($quantity) && $quantity >= 0 && $quantity <= $inStock) {
            break;
        }
        echo colorize("Input must be an integer type digit from 0-$inStock!\n", 31);
    }
    $stock[$select]->quantity -= $quantity;
    return addProduct($stock[$select]->name, $quantity, $stock[$select]->price);
}
function printMenuAndStats($client = null) {
    cls();
    printHeading("MENU");
    printMenu();
    if(isset($client)) {
        printClientStats($client);
    } else {
        printClientStats();
    }
}
function checkOut(array $stock, stdClass $client): string {
    $sum = getCartSum($client->shoppingCart);
    $formatedSum = formatPrice($sum);
    $confirm = readline("Are you sure you want to check out? It will be €$formatedSum in total y?: ");
    if(strtolower($confirm) === 'y' || strtolower($confirm) === 'yes') {
        if($client->money >= $sum) {
            $client->money -= $sum;
            $client->shoppingCart = [];
            return colorize("Thank You for Your purchase!", 32);
        } else {
            return colorize("Sorry, You don't have enough funds!\n", 31);
        }
    } else {
        return colorize("Checkout aborted by user input!\n", 31);
    }
}
function printHeading(string $string): void {
    echo " " . str_repeat("░",floor((73 - strlen($string))/2)) .
        colorize($string, 33) .
        str_repeat("░",ceil((73 - strlen($string))/2)) . "\n";
}