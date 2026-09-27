<?php

/**
 * HappyPaws Main Entry Point
 *
 * Every application request passes through this file.
 */

// Start a PHP session if one is not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load application configuration
require_once dirname(__DIR__) . '/config/config.php';

// Load MVC core classes
require_once APPROOT . '/core/Database.php';
require_once APPROOT . '/core/Controller.php';
require_once APPROOT . '/core/Router.php';

/*
 * Create the router.
 * The Router automatically reads the URL and loads
 * the correct controller and controller method.
 */
$router = new Router();