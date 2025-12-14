<?php
// Fetch items



$seller_info = $db->query('SELECT * FROM Seller Where Seller_ID ==' . $seller_id);
$seller_info = $seller_info->fetchArray(SQLITE3_ASSOC);

$reviews_q = $db->query('SELECT * FROM Reviewer R Join Seller S  On  S.Seller_ID == R.Seller_ID Join Customer C on R.Customer_ID == C.Customer_ID Where R.Seller_ID ==' . $seller_id);
$reviews = [];
while ($row = $reviews_q->fetchArray(SQLITE3_ASSOC)) {
    $reviews[] = $row;
}

$listings_q = $db->query('SELECT * FROM Listing L  JOIN EV_Image I ON L.Listing_ID = I.Listing_ID WHERE I.is_main_image = 1 AND Seller_ID ==' . $seller_id);
$listings = [];
while ($row = $listings_q->fetchArray(SQLITE3_ASSOC)) {
    $listings[] = $row;
}

ob_start()
    ?>


<div class="seller-info">
    <h2 class="seller-name"> <?= $seller_info['First_Name'] ?> <?= $seller_info['Last_Name'] ?></h2>
    <h4>Seller Information</h4>
    <p class="seller-email"><strong>Email</strong>: <?= $seller_info['Email'] ?></p>
    <p class="seller-phone"><strong>Phone</strong>: <?= $seller_info['Phone_Number'] ?></p>
    <p class="seller-zip"><strong>Zip Code</strong>: <?= $seller_info['Zip_Code'] ?></p>
</div>
<br>
<h4><?= $seller_info['First_Name'] ?>'s Current Listings</h4>
    <div class="listings">
        <div class="search-grid">
            <?php foreach ($listings as $item): ?>
                <a href='/listing/<?= $item['Listing_ID'] ?>'>

                    <div class="search-grid-item">
                        <img src="<?= $item['Image_URL'] ?>"
                            alt="<?= htmlspecialchars($item['Brand'] . ' ' . $item['Model']) ?>">
                        <h3>
                            <?= htmlspecialchars($item['Brand'] . ' ' . $item['Model'] . ' (' . $item['Model_Year'] . ')') ?>
                        </h3>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <br>
    <br>
<h4>Customer Reviews</h3>

    <div class="reviews">
        <?php
        if (count($reviews) === 0) {
            echo '<p>No reviews available for this seller.</p>';
        } else {
            foreach ($reviews as $review) {
                ?>
                <div class="review-item">
                    <h5 class="customer-name"><?= htmlspecialchars($review['First_Name'] . ' ' . $review['Last_Name']) ?></h5>
                    <p class="review"><i>"<?= htmlspecialchars($review['Review']) ?>"</i></p>
                    <p class="date">- <?= date('F j, Y', strtotime($review['Review_Date']));
                    ?></p>
                </div>
                <?php
            }
        }
        ?>
    </div>

    <?php
    $content = ob_get_clean();

    $style_sheets = ['/pages/styles/seller.css', '/pages/styles/button.css', '/pages/styles/search.css'];
    include './templates/starter-page.php';