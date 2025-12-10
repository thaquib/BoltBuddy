<?php 
// Fetch items
$results = $db->query('SELECT * FROM Listing');
$items = [];
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    $items[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Listing Pages</title>
</head>
<body>
<h1>Welcome to My Website</h1>
<p>Reading Listing table and rendering list</p>

<ul>
<?php foreach($items as $item): ?>
    <li><?php echo json_encode($item); ?></li>
<?php endforeach; ?>
</ul>

</body>
</html>
