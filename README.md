# BoltBuddy

BoltBuddy is a lightweight PHP project that provides a small web interface and includes `adminer.php` for database management. This repository contains basic files to run a local PHP site and a `data/` directory for application data using SQLite.

Our database is running on SQLite. Which means there is no external database server. The entire database is stored in one file, and any database transactions modify that file.

This repo has everything setup so that when you start the server on your local machine, the database tables are available to the app right away. 
## Contents
- `index.php` — application entry point.
- `adminer.php` — Adminer single-file database management tool (if present).
- `data/` — data directory used by the application.

## Requirements
- PHP 7.4+ (recommended)
    ```bash
    php -v
    ```
- SQLite is installed and enabled
    ```bash
    php -m | grep sqlite3
    ```
- data/ folder writable by web server (chmod 777 data for testing)
    ```bash
    chmod 777 data
    ```

## Quick Start (local PHP server)
1. Open a terminal in the project root (where `index.php` is located).
2. Start PHP's built-in server:

    ```bash
    php -S localhost:8000
    ```

    To load with hot-reload (changes made to your files automatically show up without refreshing your browser),run this in a separate terminal with the first one still running:
    ```bash
    npx browser-sync start --proxy "localhost:8000" --files "**/*.php"
    ```

3. Open `http://localhost:8000` (or `http://localhost:3000` for hot-reload) in your browser to view the app.

4. Open `http://localhost:8000/adminer.php` to access the Adminer UI for managing databases. At Login:
- Sytstem: SQLite
- Server: localhost
- Username: leave blank
- Password: leave blank 
- Database: data/mydb.sqlite

## Data directory
The `data/` directory may be used by the application to store runtime files. Make sure it is writable by the web server or the user running the PHP built-in server.

## Contributing
Feel free to open issues or submit pull requests. Keep changes focused and add a short description of any new behavior.