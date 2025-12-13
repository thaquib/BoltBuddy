<?php
// Fetch items
$results = $db->query('SELECT * FROM EV_Image I Join Listing L Where L.Listing_ID == I.Listing_ID AND I.is_main_image = 1');
$items = [];
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    $items[] = $row;
}

ob_start()
    ?>


<div class="search-grid">
    <?php foreach ($items as $item): ?>
                <a href='/listing/<?= $item['Listing_ID'] ?>'>

        <div class="search-grid-item">
                <img src="<?= $item['Image_URL'] ?>" alt="<?= htmlspecialchars($item['Brand'] . ' ' . $item['Model']) ?>">
            <h3>
                    <?= htmlspecialchars($item['Brand'] . ' ' . $item['Model'] . ' (' . $item['Model_Year'] . ')') ?>
            </h3>
        </div>
        </a>
    <?php endforeach; ?>
</div>

<?php
$content = ob_get_clean();
$style_sheets = ['/pages/styles/search.css'];
include './templates/starter-page.php';
?>