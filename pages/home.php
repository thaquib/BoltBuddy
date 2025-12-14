<?php
ob_start()
?>

<h1>Welcome to BoltBuddy</h1>
<div class="cta">
    <a href="/search"><i class="bi bi-search navicon"></i> Search</a>
    <a href="/post"><i class="bi bi-plus-circle navicon"></i> Post Listing</a>
</div>
<?php
$content = ob_get_clean();
$style_sheets = ['/pages/styles/home.css', '/pages/styles/button.css'];
include './templates/starter-page.php';

