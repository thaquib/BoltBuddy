<?php
// Fetch items
$images = $db->query('SELECT * FROM EV_Image Where Listing_ID =='. $listing_id);
$images_items = [];
while ($row = $images->fetchArray(SQLITE3_ASSOC)) {
    $images_items[] = $row;
}
$listing_info = $db->query('SELECT * FROM Listing Where Listing_ID =='. $listing_id);
$listing_info = $listing_info->fetchArray(SQLITE3_ASSOC);

$color = $db->query('SELECT Color_Name FROM Color Where Color_ID =='. $listing_info['Color'])->fetchArray(SQLITE3_ASSOC)['Color_Name'] ?? null;

$tax_benefits_q = $db->query('SELECT * FROM Tax_Benefit T Join Listing_Tax_Benefit L  On  L.Tax_Benefit_ID == T.Tax_Benefit_ID Where L.Listing_ID =='.$listing_id);
$tax_benefits = [];
while ($row = $tax_benefits_q->fetchArray(SQLITE3_ASSOC)) {
    $tax_benefits[] = $row;
}



$seller_info = $db->query('SELECT * FROM Seller Where Seller_ID =='. $listing_info['Seller_ID']);
$seller_info = $seller_info->fetchArray(SQLITE3_ASSOC);

ob_start()
?>


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

<div class="listing-details">
    <p class="listing-price"><strong>Price</strong>: $<?=$listing_info['Price']?></p>
    <br>
    <div class="details-section">
        <div class="listing-info">
            <h3>Listing Information</h3>
            <p class="listing-color"><strong>Color</strong>: <?=$color?></p>
            <p class="listing-range"><strong>Battery Range</strong>: <?=$listing_info['Battery_Range']?> miles</p>
            <p class="listing-charging-type"><strong>Charging Type</strong>: <?=$listing_info['Charging_Type']?></p>
            <br>
            <h4>Tax Benefits</h4>
            <ul class="tax-benefits-list">
                <?php
                foreach ($tax_benefits as $benefit) {
                    echo '<li><strong>' . htmlspecialchars($benefit['Benefit_Type']) . '</strong>: $' . htmlspecialchars($benefit['Amount']) . '</li>';
                }
                ?>
        </div>
        <br>
        <div class="seller-info">
            <h3>Seller Information</h3>
            <p class="seller-name"><strong>Name</strong>:  <?=$seller_info['First_Name']?> <?=$seller_info['Last_Name']?></p>
            <p class="seller-email"><strong>Email</strong>:  <?=$seller_info['Email']?></p>
            <p class="seller-phone"><strong>Phone</strong>:  <?=$seller_info['Phone_Number']?></p>
            <p class="seller-zip"><strong>Zip Code</strong>:  <?=$seller_info['Zip_Code']?></p>
            <div class="cta">
                 <a href="/seller/<?= $seller_info['Seller_ID'] ?>"><i class="bi bi-person navicon"></i> Seller Profile</a>
            </div>
        </div>
    </div>
</div>

   
<?php
$content = ob_get_clean();

$style_sheets = ['/pages/styles/listing.css', '/pages/styles/button.css'];
include './templates/starter-page.php';