<?php
/**
 * =======================================================================
 * Happy Paws - Application Configuration File
 * =======================================================================
 * 
 * Defines global constants for database connection parameters, filesystem
 * path roots, application URLs, and clinic metadata.
 * =======================================================================
 */

// -----------------------------------------------------------------------
// 1. Database Connection Parameters
// -----------------------------------------------------------------------
// Primary database host (127.0.0.1 avoids macOS socket ambiguity)
define('DB_HOST', '127.0.0.1');

// MySQL Port (Default: 3306)
define('DB_PORT', '3306');

// Database user credentials
define('DB_USER', 'root');
define('DB_PASS', '');

// Target database name
define('DB_NAME', 'happy_paws_db');


// -----------------------------------------------------------------------
// 2. Application & Routing Constants
// -----------------------------------------------------------------------
// Filesystem path to the internal 'app' directory
define('APPROOT', dirname(dirname(__FILE__)) . '/app');

// Public base URL root (adjust if running under a virtual host or custom port)
define('URLROOT', 'http://localhost/Happy-Paws');

// Global clinic brand name
define('SITENAME', 'Happy Paws - Pet Care & Veterinary Clinic');
