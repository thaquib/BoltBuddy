<?php
// Fetch items
$images = $db->query('SELECT * FROM EV_Image Where Listing_ID =='. $listing_id);
$images_items = [];
while ($row = $images->fetchArray(SQLITE3_ASSOC)) {
    $images_items[] = $row;
}
$listing_info = $db->query('SELECT * FROM Listing Where Listing_ID =='. $listing_id);
$listing_info = $listing_info->fetchArray(SQLITE3_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>BoltBuddy</title>
    <link rel="stylesheet" href="/pages/styles/listing.css">
</head>

<body>
 <!-- <?php echo json_encode($listing_info); ?> -->
<h1><?= $listing_info['Brand'] . ' ' . $listing_info['Model'] . ' (' . $listing_info['Model_Year'] . ')'?></h1>

<div class="slider">
    <div class="slider__item">
            <label class="slider__control">
                <input type="radio" name="slider" checked />
            </label>
            <div class="slider__content">
                <img src="<?= $images_items[0]['Image_URL'] ?>" alt="">
            </div>
        </div>
    <?php
    for ($i = 1; $i < count($images_items); $i++) {
        ?>
        <div class="slider__item">
            <label class="slider__control">
                <input type="radio" name="slider" />
            </label>
            <div class="slider__content">
                <img src="<?= $images_items[$i]['Image_URL'] ?>" alt="">
            </div>
        </div>
        <?php
    }
    ?>
  
</div>

   
</body>

</html>