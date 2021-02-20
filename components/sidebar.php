<?php
$page = basename($_SERVER["PHP_SELF"], ".php");

if (!defined("root")) {
    header("location:../index.php");
    die;
};

//get parameter whether it is tambah film or jadwal or user or voucher
if (isset($_GET['data'])) {
    $data = $_GET['data'];
}

?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <div class="sidebar-brand-text mx-3">SIBOS - <?= $_SESSION['role']; ?></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= ($page == "dashboard") ? 'active' : '' ?>">
        <a class="nav-link" href="dashboard.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Pengelolaan
    </div>

    <?php if (($_SESSION['role'] === 'manajer') || $_SESSION['role'] === 'dev') : ?>
        <!-- Nav Item - film Menu -->
        <li class="nav-item <?= ($page == "listfilm" || ($page == "insert" && $data == "film")) ? 'active' : '' ?>" style="z-index: 3;">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-film"></i>
                <span>Kelola Film</span>
            </a>
            <div id="collapseTwo" class="collapse <?= ($page == "listfilm" || ($page == "insert" && $data == "film")) ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Menu:</h6>
                    <a class="collapse-item d-flex justify-content-between <?= ($page == "listfilm") ? 'active' : '' ?>" data-toggle="collapse" data-target="#collapseFilm" style="cursor: pointer;">
                        <span>List Film</span>
                        <i class="fa fa-chevron-down my-auto"></i>
                    </a>
                    <div id="collapseFilm" class="collapse <?= ($page == "listfilm") ? 'show' : '' ?>">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">List Film:</h6>
                            <a class="collapse-item <?= isset($_GET['status']) ? (($_GET['status'] == 'upcoming' && $page == "listfilm") ? 'active' : '') : '' ?>" href="listfilm.php?status=upcoming">Film Upcoming</a>
                            <a class="collapse-item <?= isset($_GET['status']) ? (($_GET['status'] == 'aktif' && $page == "listfilm") ? 'active' : '') : '' ?>" href="listfilm.php?status=aktif">Film Aktif</a>
                            <a class="collapse-item <?= isset($_GET['status']) ? (($_GET['status'] == 'non aktif' && $page == "listfilm") ? 'active' : '') : '' ?>" href="listfilm.php?status=non aktif">Film Non Aktif</a>
                        </div>
                    </div>
                    <a class="collapse-item <?= (isset($_GET['data']) && $page == "insert") ? (($_GET['data'] == 'film') ? 'active' : '') : '' ?>" href="insert.php?data=film">Tambah
                        Film</a>
                </div>
            </div>
        </li>
    <?php endif; ?>

    <!-- Nav Item - jadwal Menu -->
    <li class="nav-item <?= ($page == "listjadwal" || ($page == "insert" && $data == "jadwal")) ? 'active' : '' ?>" style="z-index: 3;">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-calendar"></i>
            <span>Kelola Jadwal </span>
        </a>
        <div id="collapseUtilities" class="collapse <?= ($page == "listjadwal" || ($page == "insert" && $data == "jadwal")) ? 'show' : '' ?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Menu:</h6>
                <a class="collapse-item d-flex justify-content-between <?= ($page == "listjadwal") ? 'active' : '' ?>" data-toggle="collapse" data-target="#collapseJadwal" style="cursor: pointer;">
                    <span>List Jadwal</span>
                    <i class="fa fa-chevron-down my-auto"></i>
                </a>
                <div id="collapseJadwal" class="collapse <?= ($page == "listjadwal") ? 'show' : '' ?>">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">List Jadwal:</h6>
                        <a class="collapse-item <?= isset($_GET['status']) ? (($_GET['status'] == 'aktif' && $page == "listjadwal") ? 'active' : '') : '' ?>" href="listjadwal.php?status=aktif">Jadwal Aktif</a>
                        <a class="collapse-item <?= isset($_GET['status']) ? (($_GET['status'] == 'non aktif' && $page == "listjadwal") ? 'active' : '') : '' ?>" href="listjadwal.php?status=non aktif">Jadwal Non Aktif</a>
                    </div>
                </div>
                <a class="collapse-item <?= (isset($_GET['data']) && $page == "insert") ? (($_GET['data'] == 'jadwal') ? 'active' : '') : '' ?>" href="insert.php?data=jadwal">Tambah
                    Jadwal</a>
            </div>
        </div>
    </li>

    <?php if (($_SESSION['role'] === 'manajer') || $_SESSION['role'] === 'dev') : ?>
        <!-- Nav Item - studio Menu -->
        <!-- <li class="nav-item <?= (($page == "list" && $data == "studio") || ($page == "insert" && $data == "studio")) ? 'active' : '' ?>" style="z-index: 3;">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudio"
            aria-expanded="true" aria-controls="collapseStudio">
            <i class="fas fa-video"></i>
            <span>Kelola Studio </span>
        </a>
        <div id="collapseStudio" class="collapse <?= (($page == "list" && $data == "studio") || ($page == "insert" && $data == "studio")) ? 'show' : '' ?>"
            aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Menu:</h6>
                <a class="collapse-item <?= ($page == "list" && $data == "studio") ? 'active' : '' ?>" href="list.php?data=studio"
                  style="cursor: pointer;">
                    <span>List Studio</span>
                </a>
                <a class="collapse-item <?= (isset($_GET['data']) && $page == "insert") ? (($_GET['data'] == 'studio') ? 'active' : '') : '' ?>" href="insert.php?data=studio">Tambah
                    Studio</a>
            </div>
        </div>
    </li> -->

        <!-- Nav Item - user Menu -->
        <li class="nav-item <?= (($page == "list" && $data == "user") || ($page == "insert" && $data == "user")) ? 'active' : '' ?>" style="z-index: 3;">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser" aria-expanded="true" aria-controls="collapseUser">
                <i class="fas fa-user"></i>
                <span>Kelola User </span>
            </a>
            <div id="collapseUser" class="collapse <?= (($page == "list" && $data == "user") || ($page == "insert" && $data == "user")) ? 'show' : '' ?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Menu:</h6>
                    <!-- <a class="collapse-item <?= ($page == "list" && $data == "user") ? 'active' : '' ?>" href="./manage-user/index.php" style="cursor: pointer;">
                        <span>List User</span>
                    </a> -->
                    <!-- <a class="collapse-item <?= (isset($_GET['data']) && $page == "insert") ? (($_GET['data'] == 'user') ? 'active' : '') : '' ?>" href="./manage-user/add.php">Tambah
                    User</a> -->
                    <a class="collapse-item <?= ($page == "list" && $data == "user") ? 'active' : '' ?>" href="list.php?data=user" style="cursor: pointer;">
                        <span>List User</span>
                    </a>
                    <a class="collapse-item <?= (isset($_GET['data']) && $page == "insert") ? (($_GET['data'] == 'user') ? 'active' : '') : '' ?>" href="insert.php?data=user">Tambah
                        User</a>
                </div>
            </div>
        </li>

        <!-- Nav Item -voucher Menu -->
        <li class="nav-item <?= (($page == "list" && $data == "voucher") || ($page == "insert" && $data == "voucher")) ? 'active' : '' ?>" style="z-index: 3;">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVoucher" aria-expanded="true" aria-controls="collapseVoucher">
                <i class="fas fa-tags"></i>
                <span>Kelola Voucher </span>
            </a>
            <div id="collapseVoucher" class="collapse <?= (($page == "list" && $data == "voucher") || ($page == "insert" && $data == "voucher")) ? 'show' : '' ?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Menu:</h6>
                    <a class="collapse-item <?= ($page == "list" && $data == "voucher") ? 'active' : '' ?>" href="list.php?data=voucher" style="cursor: pointer;">
                        <span>List Voucher</span>
                    </a>
                    <a class="collapse-item <?= (isset($_GET['data']) && $page == "insert") ? (($_GET['data'] == 'voucher') ? 'active' : '') : '' ?>" href="insert.php?data=voucher">Tambah
                        Voucher</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Laporan
        </div>

        <!-- Nav Item - Penjualan -->
        <li class="nav-item <?= $page == "list" && $data == "penjualan" ? 'active' : '' ?>">
            <a class="nav-link" href="list.php?data=penjualan">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Penjualan</span>
            </a>
        </li>

    <?php else : ?>
    <?php endif; ?>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->