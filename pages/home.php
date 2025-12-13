<?php
ob_start()
?>

<h1>Welcome to BoltBuddy</h1>

<?php
$content = ob_get_clean();
include './templates/starter-page.php';

