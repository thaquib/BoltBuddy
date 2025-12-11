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
    <title>Search Page</title>
    <link rel="stylesheet" href="/pages/styles/search.css">
</head>

<body>
    <h1>Search Page</h1>
    <p>Reading Listing and Image table and rendering grid</p>

        <div class="search-grid">
            <?php foreach ($items as $item): ?>

                <!-- item: {"Image_ID":1,"Listing_ID":1,"Image_URL":"\/images\/tesla-model3-front.jpg","is_main_image":1,"Seller_ID":1,"Price":38999,"Brand":"Tesla","Model":"Model 3","Model_Year":2021,"Color":"4","Battery_Range":263,"Charging_Type":"CCS"} -->
                <div class="search-grid-item">
                    <img src="<?= $item['Image_URL'] ?>" alt="">
                    <h3><?= htmlspecialchars($item['Brand'] . ' ' . $item['Model'] . ' (' . $item['Model_Year'] . ')') ?></h3>
                </div>
            <?php endforeach; ?>
        </div>
</body>

</html>