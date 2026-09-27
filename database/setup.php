<?php
/**
 * =======================================================================
 * Happy Paws - Database Setup & Migration Script
 * =======================================================================
 * 
 * Description:
 *   Automated initialization script that connects to MySQL, creates the
 *   `happy_paws_db` database, runs the full schema definitions, and seeds
 *   realistic sample data for testing.
 * 
 * Usage:
 *   - Via CLI:     php database/setup.php
 *   - Via Browser: http://localhost/Happy-Paws/database/setup.php
 * =======================================================================
 */

// Load existing project configuration if available
$configFile = dirname(__DIR__) . '/config/config.php';
if (file_exists($configFile)) {
    require_once $configFile;
}

// Database configuration defaults with fallback
$host = defined('DB_HOST') ? DB_HOST : '127.0.0.1';
$port = defined('DB_PORT') ? DB_PORT : '3306';
$user = defined('DB_USER') ? DB_USER : 'root';
$pass = defined('DB_PASS') ? DB_PASS : '';
$dbname = defined('DB_NAME') ? DB_NAME : 'happy_paws_db';

$isCli = (php_sapi_name() === 'cli');

function outputMessage($text, $type = 'info') {
    global $isCli;
    if ($isCli) {
        $prefix = match ($type) {
            'success' => "[\033[32mSUCCESS\033[0m] ",
            'error'   => "[\033[31mERROR\033[0m] ",
            'warning' => "[\033[33mWARNING\033[0m] ",
            default   => "[\033[34mINFO\033[0m] ",
        };
        echo $prefix . $text . PHP_EOL;
    } else {
        $color = match ($type) {
            'success' => '#10b981',
            'error'   => '#ef4444',
            'warning' => '#f59e0b',
            default   => '#3b82f6',
        };
        echo "<div style='margin: 8px 0; padding: 10px 14px; border-radius: 6px; background: #f8fafc; border-left: 4px solid {$color}; font-family: sans-serif; font-size: 14px;'><strong>" . strtoupper($type) . ":</strong> {$text}</div>";
    }
}

if (!$isCli) {
    echo "<!DOCTYPE html><html><head><title>Happy Paws - DB Setup</title>";
    echo "<style>body{font-family: Inter, system-ui, sans-serif; max-width: 800px; margin: 40px auto; padding: 20px; background: #f1f5f9; color: #1e293b;} .card{background:#fff; border-radius:12px; padding:24px; box-shadow:0 4px 15px rgba(0,0,0,0.05);}</style></head><body><div class='card'>";
    echo "<h2 style='margin-top:0; color:#1a56b8;'>🐾 Happy Paws - Database Setup & Migration</h2>";
}

outputMessage("Connecting to MySQL server at {$host}:{$port} as user '{$user}'...");

$pdo = null;
$connectionErrors = [];

// Attempt 1: Connect via specified host and port
try {
    $dsn = "mysql:host={$host};port={$port};charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    $connectionErrors[] = "Host {$host}: " . $e->getMessage();
}

// Attempt 2: If 127.0.0.1 failed, try localhost
if (!$pdo && $host !== 'localhost') {
    try {
        $dsn = "mysql:host=localhost;charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        outputMessage("Connected successfully using 'localhost' socket.", 'info');
    } catch (PDOException $e) {
        $connectionErrors[] = "Localhost: " . $e->getMessage();
    }
}

// Attempt 3: Try XAMPP default unix socket on macOS if previous failed
if (!$pdo) {
    $xamppSocket = '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock';
    if (file_exists($xamppSocket)) {
        try {
            $dsn = "mysql:unix_socket={$xamppSocket};charset=utf8mb4";
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            outputMessage("Connected successfully via XAMPP socket: {$xamppSocket}", 'info');
        } catch (PDOException $e) {
            $connectionErrors[] = "Socket {$xamppSocket}: " . $e->getMessage();
        }
    }
}

// Check if connection succeeded
if (!$pdo) {
    outputMessage("Failed to connect to MySQL database server:", 'error');
    foreach ($connectionErrors as $err) {
        outputMessage($err, 'error');
    }
    outputMessage("Please ensure XAMPP MySQL service is running.", 'warning');
    if (!$isCli) { echo "</div></body></html>"; }
    exit(1);
}

outputMessage("Connected to MySQL server successfully!", 'success');

// Step 2: Read SQL schema file
$sqlFile = __DIR__ . '/happy_paws_db.sql';
if (!file_exists($sqlFile)) {
    outputMessage("Schema file not found at: {$sqlFile}", 'error');
    if (!$isCli) { echo "</div></body></html>"; }
    exit(1);
}

outputMessage("Reading SQL schema from {$sqlFile}...");
$sqlContent = file_get_contents($sqlFile);

// Step 3: Execute Schema queries
try {
    outputMessage("Executing database creation and schema migration...");
    
    // Execute the complete SQL script (PDO supports multi-query when enabled)
    $pdo->exec($sqlContent);
    outputMessage("Schema executed and sample data seeded successfully!", 'success');
} catch (PDOException $e) {
    outputMessage("Error executing SQL schema: " . $e->getMessage(), 'error');
    if (!$isCli) { echo "</div></body></html>"; }
    exit(1);
}

// Step 4: Verify tables and count seed records
$pdo->exec("USE `{$dbname}`");
$tables = ['users', 'pets', 'services', 'appointments', 'medical_records', 'vaccinations', 'products'];

outputMessage("Verifying created tables and seed records:");

foreach ($tables as $table) {
    try {
        $stmt = $pdo->query("SELECT COUNT(*) AS total FROM `{$table}`");
        $count = $stmt->fetch()['total'];
        outputMessage("Table '{$table}' exists with {$count} records.", 'success');
    } catch (PDOException $e) {
        outputMessage("Table '{$table}' check failed: " . $e->getMessage(), 'error');
    }
}

// Summary and sample login credentials
outputMessage("Database setup completed successfully!", 'success');

if ($isCli) {
    echo PHP_EOL . "========================================================" . PHP_EOL;
    echo "🎉 Test Login Credentials:" . PHP_EOL;
    echo "   - Pet Owner : owner@example.com   | Password: password123" . PHP_EOL;
    echo "   - Vet Doctor: vet@happypaws.lk    | Password: password123" . PHP_EOL;
    echo "   - Admin     : admin@happypaws.lk  | Password: password123" . PHP_EOL;
    echo "   - Staff     : staff@happypaws.lk  | Password: password123" . PHP_EOL;
    echo "========================================================" . PHP_EOL;
} else {
    echo "<div style='margin-top:20px; padding:16px; background:#eff6ff; border-radius:8px; border:1px solid #bfdbfe;'>";
    echo "<h3 style='margin-top:0; color:#1e40af;'>🎉 Test Login Credentials</h3>";
    echo "<ul>";
    echo "<li><strong>Pet Owner:</strong> owner@example.com (Password: <code>password123</code>)</li>";
    echo "<li><strong>Veterinarian:</strong> vet@happypaws.lk (Password: <code>password123</code>)</li>";
    echo "<li><strong>Admin:</strong> admin@happypaws.lk (Password: <code>password123</code>)</li>";
    echo "<li><strong>Staff:</strong> staff@happypaws.lk (Password: <code>password123</code>)</li>";
    echo "</ul>";
    echo "<a href='../public/' style='display:inline-block; padding:10px 18px; background:#2b7fff; color:#fff; border-radius:6px; text-decoration:none; font-weight:600; margin-top:10px;'>Go to Happy Paws Homepage →</a>";
    echo "</div></div></body></html>";
}
