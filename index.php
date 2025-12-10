<?php ?>
<h1> Welcome to My Website</h1>
<p>This is the homepage of my awesome website. Stay tuned for more content!</p>

<?php
// --- Configuration ---
$db_file = __DIR__ . '/data/mydb.sqlite';

// --- Create database if it doesn't exist ---
if (!file_exists($db_file)) {
    $db = new SQLite3($db_file);
    $db->exec('CREATE TABLE items (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT)');
} else {
    $db = new SQLite3($db_file);
}

// --- Handle form submission (insert new item) ---
if (isset($_POST['name']) && $_POST['name'] !== '') {
    $stmt = $db->prepare('INSERT INTO items (name) VALUES (:name)');
    $stmt->bindValue(':name', $_POST['name'], SQLITE3_TEXT);
    $stmt->execute();
}

// --- Fetch all items ---
$results = $db->query('SELECT * FROM items');
$items = [];
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    $items[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Barebones PHP SQLite App</title>
<style>
body { font-family: Arial; margin: 40px; }
form { margin-bottom: 20px; }
ul { list-style-type: none; padding: 0; }
li { padding: 5px 0; }
</style>
</head>
<body>

<h1>Barebones PHP SQLite App</h1>

<form method="POST">
    <input type="text" name="name" placeholder="Item name" required>
    <button type="submit">Add Item</button>
</form>

<h2>Items</h2>
<ul>
<?php foreach($items as $item): ?>
    <li><?php echo htmlspecialchars($item['name']); ?></li>
<?php endforeach; ?>
</ul>

</body>
</html>