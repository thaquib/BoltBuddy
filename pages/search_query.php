<?php
function getFilteredListings($db, $filters = [])
{
    $brand = $_GET['brand'] ?? [];
    $minYear = $_GET['min-year'] ?? '';
    $maxYear = $_GET['max-year'] ?? '';
    $colors = $_GET['color'] ?? []; // array of colors
    $sort = $_GET['sort'] ?? 'newest';

    // Base query
    $sql = "SELECT * FROM EV_Image I 
        JOIN Listing L ON L.Listing_ID = I.Listing_ID
        WHERE I.is_main_image = 1";

    // Brand filter
    if (!empty($brand)) {
        $brandList = "'" . implode("','", $brand) . "'"; // e.g., 'Red','Blue'
        $sql .= " AND L.Brand IN ($brandList)";
    }

    // Min year filter
    if ($minYear !== '') {
        $sql .= " AND L.Model_Year >= $minYear";
    }

    // Max year filter
    if ($maxYear !== '') {
        $sql .= " AND L.Model_Year <= $maxYear";
    }

    // Colors filter (multi-select)
    if (!empty($colors)) {
        $colorList = "'" . implode("','", $colors) . "'"; // e.g., 'Red','Blue'
        $sql .= " AND L.Color IN ($colorList)";
    }


// Sorting
switch ($sort) {
    case 'oldest':
        $sql .= " ORDER BY L.Model_Year ASC";
        break;
    case 'brand-asc':
        $sql .= " ORDER BY L.Brand ASC";
        break;
    case 'brand-desc':
        $sql .= " ORDER BY L.Brand DESC";
        break;
    case 'newest':
    default:
        $sql .= " ORDER BY L.Model_Year DESC";
        break;
}

    // Execute
    $results = $db->query($sql);

    // Fetch results
    $items = [];
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
        $items[] = $row;
    }
    return $items;
}