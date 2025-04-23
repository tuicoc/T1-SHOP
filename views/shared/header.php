<?php 
require_once('../config/config.php');
if (session_status() === PHP_SESSION_NONE) {
  ini_set('session.gc_maxlifetime', 0); 
    session_start();
}
?>
<?php require_once('../config/config.php'); ?>

<!DOCTYPE html>
<html lang="vi" xmlns="http://www.w3.org/1999/html">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="keywords" content="BK Buddy, Tech Support">
  <meta name="description" content="All Tech Support You Need">
  <meta name="author" content="Trần Xuân Bách">
  <title>Buddy</title>
  <link rel="icon" href="consultant.png" type="image">
  <link rel="stylesheet" href="/mywebsite/public/css/style.css?v=<?php echo time();?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <script src="../public/js/script.js?v=<?php echo time();?>"></script>
</head>
<body>
<header>
  <!--  <h1>My Website</h1>-->
  <nav class="navbar">
    <div class="navbar-container">
      <div class="nav-links">
        <div class="menu-icon">
          <i class="fa-solid fa-bars"></i>
        </div>
        <!-- Container chứa toàn bộ menu -->
        <div id="menu-container" class="hidden">
          <nav id="sidebar" class="sidebar">
            <div class="sidebar-header">
              <span class="logo">Buddy</span>
            </div>

            <form class="search">
              <input type="text" placeholder="Search">
              <button class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>

            <ul class="menu">
              <li><a href="<?= DOMAIN.'public/index.php?';?>"><i class="fa-solid fa-house" style="padding-right: 8px"></i>Home</a></li>
              <li><a href="<?php echo DOMAIN.'public/index.php?controller=service';?>"><i class="fa-solid fa-thumbtack" style="padding-right: 12px"></i>Products</a></li>
              <li><a href="<?= DOMAIN.'public/index.php?controller=contact';?>"><i class="fa-solid fa-address-card" style="padding-right: 7px"></i>Contact</a></li>
              <li class="submenu">
                <a href="<?= DOMAIN.'public/index.php?';?>" style="padding-bottom: 5px"><i class="fa-solid fa-angle-down" style="padding-right: 12px"></i>Collection</a>
                <ul class="dropdown">
                  <li><a href="<?= DOMAIN.'public/index.php?controller=categories&category=0';?>">LOL Team</a></li>
                  <li><a href="<?= DOMAIN.'public/index.php?controller=categories&category=1';?>">Valorant Team</a></li>
                </ul>
              </li>
            </ul>
          </nav>
        </div>
        <a href="<?= DOMAIN.'public/index.php?';?>" class="logo">Buddy</a>
        <a href="<?= DOMAIN.'public/index.php?';?>" class="navElement">Home</a> <!-- ?= -> ?php echo-->
        <a href="<?php echo DOMAIN.'public/index.php?controller=service';?>" class="navElement">Products</a> <!-- Database basedx -->
        <a href="<?= DOMAIN.'public/index.php?controller=contact';?>" class="navElement">Contact</a>
        <div class="dropdown navElement" >
          <a href="<?= DOMAIN.'public/index.php?';?>">Collection<i class="fa-solid fa-caret-down" style="padding-left: 10px"></i></a>
          <div class="dropdown-content">
            <a href="<?= DOMAIN.'public/index.php?controller=categories&category=0';?>">LOL Team</a>
            <a href="<?= DOMAIN.'public/index.php?controller=categories&category=1';?>">Valorant Team</a>
          </div>
        </div>
      </div>
      <div class="nav-actions">
        <form class="search-bar">
          <input type="text" placeholder="Search">
          <button class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>

        <?php if (isset($_SESSION['user_id'])): ?>
          <!-- Hiển thị khi đã đăng nhập -->
          <div class="user-actions">
          <div class="user-dropdown">
              <button class="icon-btn user-btn"><i class="fa-solid fa-gear"></i></button>
              <div class="user-dropdown-content">
              <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="<?= DOMAIN.'public/index.php?controller=admin&action=index'; ?>">
                    <i class="fa-solid fa-address-card"></i> Admin site
                </a>
                <a href="<?= DOMAIN.'public/index.php?controller=login&action=logout'; ?>">
                    <i class="fa-solid fa-sign-out-alt"></i> Logout
                </a>
            <?php else: ?>
                <a href="<?= DOMAIN.'public/index.php?controller=login&action=logout'; ?>" class="handleLoginStyle">
                    <i class="fa-solid fa-sign-out-alt"></i> Logout
                </a>
            <?php endif; ?>

                
              </div>
            </div>
            <button class="icon-btn settings-btn"><i class="fa-solid fa-user"></i></button>
            
          </div>
        <?php else: ?>
          <!-- Hiển thị khi chưa đăng nhập -->
          <button class="sign-in" onclick="handleAuth('login')">Sign In</button>
          <button class="register" onclick="handleAuth('register')">Register</button>
        <?php endif; ?>
      </div>
    </div>
  </nav>
</header>

