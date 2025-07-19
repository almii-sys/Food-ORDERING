<?php
session_start();
include_once 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burger Haven - Food Ordering</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dark-mode.css" id="theme-css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="light-mode">
    <header>
        <nav>
            <div class="logo">
                <a href="index.php">
                    <img src="images/logo.png" alt="Burger Haven Logo">
                    <span>Burger Haven</span>
                </a>
            </div>
            <div class="theme-toggle">
                <button id="theme-toggle-btn">
                    <i class="fas fa-moon"></i>
                    <i class="fas fa-sun"></i>
                </button>
            </div>
            <ul class="nav-links">
                <li class="dropdown">
                    <a href="menu.php">Menu <i class="fas fa-caret-down"></i></a>
                    <div class="dropdown-content">
                        <a href="menu.php?category=1">Burgers</a>
                        <a href="menu.php?category=2">Fries</a>
                        <a href="menu.php?category=3">Drinks</a>
                    </div>
                </li>
                <li><a href="contact.php">Contact</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li><a href="account.php">My Account</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="signup.php">Sign Up</a></li>
                <?php endif; ?>
                <li class="cart-icon">
                    <a href="cart.php">
                        <i class="fas fa-shopping-cart"></i>
                        <span id="cart-count">
                            <?php 
                            echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
                            ?>
                        </span>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    <main>