<?php
// Fetch items
$results = $db->query('SELECT * FROM EV_Image I Join Listing L Where L.Listing_ID == I.Listing_ID AND I.is_main_image = 1');
$items = [];
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    $items[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Listing Page</title>
    <link rel="stylesheet" href="./styles/search.css">
</head>

<body>
    <h1>Listing Page</h1>
    <p>Reading List and Image table and rendering grid</p>

    <ul>
        <div class="search-grid">
            <?php foreach ($items as $item): ?>
                <div class="search-grid-item">
                    <li><?php echo json_encode($item); ?></li>
                    <img src="<?= $item['Image_URL'] ?>" alt="">
                </div>
            <?php endforeach; ?>
        </div>
    </ul>

</body>

</html>