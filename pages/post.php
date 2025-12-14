<?php

$colors_q = $db->query('SELECT * FROM Color');
$colors = [];
while ($row = $colors_q->fetchArray(SQLITE3_ASSOC)) {
    $colors[] = $row;
}
$sellers_q = $db->query('SELECT * FROM Seller');
$sellers = [];
while ($row = $sellers_q->fetchArray(SQLITE3_ASSOC)) {
    $sellers[] = $row;
}

ob_start()
?>
<form id="listing-form" action="/pages/post-handler.php" method="POST" enctype="multipart/form-data">
    <h1>Post a New Listing</h1>

    <label for="seller">Seller:</label>
  <select name="seller" id="seller">
        <?php
        foreach ($sellers as $seller) {
            echo '<option value="' . htmlspecialchars($seller['Seller_ID']) . '">' . htmlspecialchars($seller['First_Name'] . ' ' . $seller['Last_Name']) . '</option>';
        }
        ?>
    </select>

    <label for="battery-range">Battery Range:</label>
    <input type="number" id="battery-range" name="battery-range" >

    <label for="charging-type">Charging Type:</label>
    <input type="text" id="charging-type" name="charging-type" >

    <label for="brand">Brand:</label>
    <input type="text" id="brand" name="brand" >

    <label for="model">Model:</label>
    <input type="text" id="model" name="model" >

    <label for="model-year">Model Year:</label>
    <input type="number" id="model-year" name="model-year" >

    <label for="color">Color:</label>
    <select name="color" id="color">
        <?php
        foreach ($colors as $color) {
            echo '<option value="' . htmlspecialchars($color['Color_ID']) . '">' . htmlspecialchars($color['Color_Name']) . '</option>';
        }
        ?>
    </select>

    <label for="price">Price:</label>
    <input type="number" id="price" name="price" >

    <label for="image-url">Image URL:</label>
    <input type="file" id="file" name="files[]"  >

    <input type="submit" value="Submit Listing">
</form>

<?php
$content = ob_get_clean();
$style_sheets = ['/pages/styles/post.css'];
include './templates/starter-page.php';

