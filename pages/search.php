<?php
include("search_query.php");

$filters = [
    'brand'    => $_GET['brand'] ?? [],
    'min-year' => $_GET['min-year'] ?? '',
    'max-year' => $_GET['max-year'] ?? '',
    'color'    => $_GET['color'] ?? [], // array if multi-select
];
$results = getFilteredListings($db, $filters);
// Fetch items
// $results = $db->query('SELECT * FROM EV_Image I Join Listing L Where L.Listing_ID == I.Listing_ID AND I.is_main_image = 1');


// $items = [];
// while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
//     $items[] = $row;
// }

$brands_q = $db->query('SELECT Distinct Brand FROM Listing');
$brands = [];
while ($row = $brands_q->fetchArray(SQLITE3_ASSOC)) {
    $brands[] = $row['Brand'];
}

$colors_q = $db->query('SELECT Color_Name FROM Color');
$colors = [];
while ($row = $colors_q->fetchArray(SQLITE3_ASSOC)) {
    $colors[] = $row['Color_Name'];
}


ob_start()
    ?>

<form action="/search"  method="GET">
    <select name="brand[]" id="brand-filter" multiple>
        <!-- <option value="all">All Brands</option> -->
        <?php

        foreach ($brands as $brand) {
            echo '<option value="' . htmlspecialchars($brand) . '">' . htmlspecialchars($brand) . '</option>';
        }
        ?>
    </select>

    <label for="year">Min Year:</label>
    <input type="number" id="min-year" name="min-year" value="2000" min="1900" max="2100" step="1">


    <label for="max-year">Max Year:</label>
    <input type="number" id="max-year" name="max-year" value="2025" min="1900" max="2100" step="1">

    <select name="color[]" id="color-filter" multiple>
        <!-- <option value="all">All Colors</option> -->
        <?php

        foreach ($colors as $color) {
            echo '<option value="' . htmlspecialchars($color) . '">' . htmlspecialchars($color) . '</option>';
        }
        ?>
    </select>
    <select name="sort" id="sort-filter">
        <option value="">Ordering</option>
        <option value="newest">Newest Listings</option>
        <option value="oldest">Oldest Listings</option>
        <option value="brand-asc">Brand A-Z</option>
        <option value="brand-desc">Brand Z-A</option>
    </select>
    <input type="submit" value="Submit">
</form>

<script>
$(document).ready(function() {
  $('#brand-filter').select2({
    placeholder: "Select brand(s)",
    allowClear: true
  });

  $('#color-filter').select2({
    placeholder: "Select color(s)",
    allowClear: true
  });
});
</script>

<div class="search-grid">
    <?php foreach ($results as $item): ?>
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