<?php
// Ensure session is active so we can check login status
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="main-nav">
    <ul class="nav-list">

        <li><a href="search.php">Search Books</a></li>
        <li><a href="books.php">Browse Books</a></li>
        <li><a href="CurrentRes.php">My Reservations</a></li>

        <?php if (isset($_SESSION['username'])): ?>
            <!-- Spacer pushes logout to the right -->
            <li class="spacer"></li>

            <li><a href="logout.php" class="logout-btn">Logout</a></li>
        <?php endif; ?>

    </ul>
</nav>

<style>
    .main-nav {
        position: absolute;
        top: 18px;
        right: 40px;
        z-index: 100;
    }

    .nav-list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        gap: 22px;
        align-items: center;
    }

    .nav-list li {
        margin: 0;
    }

    /* Spacer pushes logout to the far right */
    .spacer {
        flex-grow: 1;
    }

    .nav-list a {
        color: #cbd0e0;
        text-decoration: none;
        font-size: 14px;
        padding: 6px 10px;
        border-radius: 6px;
        transition: 0.2s;
    }

    .nav-list a:hover {
        background: #5568A3;
        color: #ffffff;
        text-decoration: none;
    }

    /* Optional: Make logout button slightly more noticeable */
    .logout-btn {
        font-weight: bold;
    }
</style>
