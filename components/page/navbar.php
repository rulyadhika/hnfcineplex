<?php 
if(!defined("root")){
    header("location:../index.php");die;
}

    define("BASEURL", 'http://localhost/web/web bioskop/');

?>

    <nav class="navbar navbar-expand-md navbar-dark fixed-top">
        <div class="container navbar-container">
            <a class="navbar-brand" href="<?= BASEURL; ?>">HNF CINEPLEX</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggle-icon"><i class="fa fa-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse mt-2 mt-md-0" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= BASEURL; ?>">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= BASEURL."page/listfilm.php?st=nowplaying"; ?>">Now Playing</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= BASEURL."page/listfilm.php?st=upcoming"; ?>">Upcoming</a>
                    </li>
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            More Info
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?= BASEURL."page/about.php"; ?>">About Us</a>
                            <a class="dropdown-item" href="<?= BASEURL."page/contact.php"; ?>">Contact Us</a>
                        </div>
                    </li>
                </ul>
                <div class="dropdown-divider"></div>
                <ul class="navbar-nav">
                    <?php if(!isset($_SESSION['login'])) :?>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= BASEURL."page/login.php"; ?>">Log in</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link sign-up-btn" href="<?= BASEURL."page/register.php"; ?>">Sign Up</a>
                    </li>
                    <?php else :?>
                        <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= $_SESSION['user_login']; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accountDropdown">
                            <?php if($_SESSION['role']!=='konsumen') :?>
                                <a class="dropdown-item" href="<?= BASEURL.'admin/dashboard.php' ?>">Dashboard</a> 
                            <?php else :?>
                            <?php endif; ?>
                            <a class="dropdown-item" href="<?= BASEURL.'page/account/dashboard.php' ?>">Profil</a> 
                            <a class="dropdown-item" href="<?= BASEURL."page/account/logout.php"; ?>">Log Out</a>
                        </div>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>