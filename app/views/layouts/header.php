<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data['title']) ? $data['title'] . ' | ' . SITENAME : SITENAME; ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="<?php echo URLROOT; ?>" class="brand-logo">
                🐾 <span>Happy Paws</span>
            </a>
            <ul class="nav-links">
                <li><a href="<?php echo URLROOT; ?>">Home</a></li>
                <li><a href="<?php echo URLROOT; ?>/about">About Us</a></li>
                <li><a href="<?php echo URLROOT; ?>/services">Services</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="<?php echo URLROOT; ?>/dashboard" class="btn-nav">Dashboard</a></li>
                    <li><a href="<?php echo URLROOT; ?>/auth/logout" class="btn-nav btn-outline">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?php echo URLROOT; ?>/auth/login" class="btn-nav">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <main class="main-content">
