<?php
// You're going to want to first execute the Select query to fetch the approriate data 
// and then store it in a PHP variable
$results = $db->query('SELECT * FROM Listing');
$items = [];
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    $items[] = $row;
}

// Then you can start the HTML output (from scratch or include a template from /templates)
?> 
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Example Page</title>
</head>
<body>
    <!-- Use PHP when you want to loop or do something programmatic like using a variable -->
<?php
foreach ($items as $item) {
    echo "<p>" . htmlspecialchars(json_encode($item)) . "</p>";
}
?>
<h1>Example Page</h1>
</body>
</html>
