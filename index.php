<!-- This file sets the routing, aka the valid URLs of our app (/home, /listing, etc)-->
<?php
// PHP setup
require __DIR__ . '/init.php';

$db_file = __DIR__ . '/data/mydb.sqlite';

// --- Routing ---
$routes = [
    '/'         => 'home.php',
    '/home'     => 'home.php',
    '/listing'  => 'listing.php',
    '/search'   => 'search.php',
    '/details'  => 'details.php',
    '/about'    => 'about.php',
];

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (array_key_exists($path, $routes)) {
    require __DIR__ . '/pages/' . $routes[$path];
} else {
    http_response_code(404);
    echo "<h1>404 Not Found</h1>";
}

?>
