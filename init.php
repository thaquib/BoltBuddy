<!-- This File Intitializes the DB by creating the tables -->
<?php
// Path to SQLite database file
$db_file = __DIR__ . '/data/mydb.sqlite';

if (!file_exists($db_file)) {
    $db = new SQLite3($db_file);

        // Enable foreign keys
    $db->exec('PRAGMA foreign_keys = ON;');

    // --- Create tables if they do not exist ---

    // Seller
    $db->exec("
    CREATE TABLE IF NOT EXISTS Seller (
        Seller_ID     INTEGER PRIMARY KEY,
        First_Name    TEXT,
        Last_Name     TEXT,
        Email         TEXT,
        Phone_Number  TEXT,
        Zip_Code      TEXT
    )");

    // Customer
    $db->exec("
    CREATE TABLE IF NOT EXISTS Customer (
        Customer_ID   INTEGER PRIMARY KEY,
        First_Name    TEXT,
        Last_Name     TEXT,
        Email         TEXT,
        Phone_Number  TEXT,
        Zip_Code      TEXT
    )");

    // Tax_Benefit
    $db->exec("
    CREATE TABLE IF NOT EXISTS Tax_Benefit (
        Tax_Benefit_ID INTEGER PRIMARY KEY,
        Benefit_Type   TEXT,
        Amount         REAL,
        Description    TEXT
    )");

    // Listing
    $db->exec("
    CREATE TABLE IF NOT EXISTS Listing (
        Listing_ID      INTEGER PRIMARY KEY,
        Seller_ID       INTEGER NOT NULL,
        Price           REAL,
        Brand           TEXT,
        Model           TEXT,
        Model_Year      INTEGER,
        Color           TEXT,
        Battery_Range   INTEGER,
        Charging_Type   TEXT,
        FOREIGN KEY (Seller_ID) REFERENCES Seller(Seller_ID)
    )");

    // EV_Image
    $db->exec("
    CREATE TABLE IF NOT EXISTS EV_Image (
        Image_ID       INTEGER PRIMARY KEY,
        Listing_ID     INTEGER NOT NULL,
        Image_URL      TEXT,
        is_main_image  INTEGER NOT NULL DEFAULT 0,
        FOREIGN KEY (Listing_ID) REFERENCES Listing(Listing_ID)
    )");

    // Listing ↔ Tax_Benefit
    $db->exec("
    CREATE TABLE IF NOT EXISTS Listing_Tax_Benefit (
        Listing_ID      INTEGER NOT NULL,
        Tax_Benefit_ID  INTEGER NOT NULL,
        PRIMARY KEY (Listing_ID, Tax_Benefit_ID),
        FOREIGN KEY (Listing_ID) REFERENCES Listing(Listing_ID),
        FOREIGN KEY (Tax_Benefit_ID) REFERENCES Tax_Benefit(Tax_Benefit_ID)
    )");

    // Reviewer
    $db->exec("
    CREATE TABLE IF NOT EXISTS Reviewer (
        Review_ID     INTEGER PRIMARY KEY,
        Seller_ID     INTEGER NOT NULL,
        Customer_ID   INTEGER NOT NULL,
        Review        TEXT,
        Review_Date   TEXT,
        FOREIGN KEY (Seller_ID) REFERENCES Seller(Seller_ID),
        FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
    )");

    // Color
    $db->exec("
    CREATE TABLE IF NOT EXISTS Color (
        Color_ID      INTEGER PRIMARY KEY,
        Color_Name    TEXT
    )");

} else {
    $db = new SQLite3($db_file);
}

