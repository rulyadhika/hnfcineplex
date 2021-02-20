<?php
session_start();
define("root",true);
if(!isset($_SESSION["login"])){
    header("Location:../page/login.php");
    exit;
}

if($_SESSION['role']==='konsumen'){
    header("Location:../index.php");
    exit;
}

require '../utility/function.php';

$today = date("Y-m-d");


$countFilmsAktif = (int) select("SELECT COUNT(id) FROM film WHERE data_status = 'Aktif'")[0]["COUNT(id)"];
$countFilmsUpcoming = (int) select("SELECT COUNT(id) FROM film WHERE data_status = 'Upcoming'")[0]["COUNT(id)"];
$countJadwals = (int) select("SELECT COUNT(id) FROM jadwal WHERE data_status = 'Aktif'")[0]["COUNT(id)"];
$countTikets = (int) select("SELECT COUNT(tiket.id) FROM pembayaran JOIN penjualan ON pembayaran.id_penjualan = penjualan.id 
                            JOIN tiket ON penjualan.id_tiket = tiket.id WHERE penjualan.tanggal_pembelian = '$today' 
                            AND pembayaran.payment_status = 'BERHASIL'")[0]["COUNT(tiket.id)"];
$countUsers = (int) select("SELECT COUNT(id) FROM user")[0]["COUNT(id)"];
$countVouchersAktif = (int) select("SELECT COUNT(id) FROM voucher WHERE data_status = 'Aktif'")[0]["COUNT(id)"];


$startdate = strtotime("-7 Days", strtotime($today));
$enddate = strtotime($today);
$past7days = [];
$i =0;

//menghitung pendapatan 7 hari terakhir
while ($startdate <= $enddate) {
    $day = $startdate;
    $tommorow = strtotime('+1 day', $day);
    $past7days[$i]["tanggal"] = date("d M", $startdate);
    //mendapatkan pendapatan hari ini (antara hari ini 00:00 dan besok 00:00)
    $past7days[$i]["revenue"] = select("SELECT data_timestamp,SUM(harga_akhir) FROM pembayaran WHERE data_timestamp BETWEEN $day AND $tommorow")[0]["SUM(harga_akhir)"];
    // jika tidak ada pembayaran hari ini (antara hari ini 00:00 dan besok 00:00)
    if($past7days[$i]["revenue"]==null){
        $past7days[$i]["revenue"] = 0;
    }
    
    $startdate = strtotime("+1 day", $startdate);
    $i++;
}

$todayTiketsRevenue = $past7days[7]["revenue"] ;

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link
      rel="shortcut icon"
      type="image/png"
      href="../asset/image/NEWLOGOWHITEBOLDENOUTLINE.png"
    />

    <title>Admin - Dashboard | HNF Cineplex</title>

    <!-- Custom fonts for this template-->
    <link href="../asset/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../asset/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include "../components/sidebar.php" ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION['user_login']?></span>
                                <img class="img-profile rounded-circle" src="https://ui-avatars.com/api/?name=<?= $_SESSION['user_login']; ?>&size=64&background=032541&color=FFFFFF&format=svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="../page/account/dashboard.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="../index.php">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Landing Page
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../page/account/logout.php" >
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard HNF Cineplex</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- date col -->
                        <div class="col-xl-9 col-lg-8">
                            <div class="col-12">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Dashboard - <span class="text-capitalize"><?= $_SESSION['role']?></span></h6>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body text-center pt-5 pb-5">
                                        <h2 class="font-weight-bold text-uppercase">SELAMAT <span class="waktu">DATANG</span>, <?= $_SESSION['user_login']; ?></h2>
                                        <h1 class="clockDisplay font-weight-bold"></h1>
                                        <h5 class="dateDisplay "></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card shadow mb-4">
                                    <!-- Card Header -->
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Pendapatan 7 Hari Terakhir</h6>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body text-center pt-5 pb-5">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of date col -->

                        <!-- card info col -->
                        <div class="col-xl-3 col-lg-4">
                            <div class="row">
                                <div class="col-12 mb-1 col-md-6 col-lg-12">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Film Aktif</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?= $countFilmsAktif ?></div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-film fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-1 col-md-6 col-lg-12">
                                    <div class="card border-left-info shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                        Film Upcoming</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?= $countFilmsUpcoming ?></div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-film fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-1 col-md-6 col-lg-12">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Jadwal Aktif</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?= $countJadwals ?></div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="col-12 mb-1 col-md-6 col-lg-12">
                                    <div class="card border-left-info shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                        Voucher Aktif</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?= $countVouchersAktif ?></div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-ticket-alt fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="col-12 mb-1 col-md-6 col-lg-12">
                                    <div class="card border-left-success shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                        Tiket Terjual (Hari Ini)</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?= $countTikets; ?></div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-ticket-alt fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-1 col-md-6 col-lg-12">
                                    <div class="card border-left-success shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                        Pendapatan (Hari Ini)</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        Rp. <?= $todayTiketsRevenue; ?></div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fa fa-dollar-sign fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-1 col-md-6 col-lg-12">
                                    <div class="card border-left-warning shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                        User</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $countUsers; ?></div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-user fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- end of card info col -->
                    </div>





                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include "../components/footer.php" ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="../asset/jquery/jquery.min.js"></script>
    <script src="../asset/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../asset/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../asset/js/sb-admin-2.min.js"></script>
    <script src="../asset/js/script.js"></script>

    <!-- chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

    <script>
        let tanggal = <?php echo json_encode($past7days) ?>;
        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: tanggal.map(data=> data.tanggal) ,
                datasets: [{
                    label: 'Rupiah',
                    data: tanggal.map(data=> data.revenue),
                    // backgroundColor: [
                    //     'rgba(54, 162, 235, 0)'
                    // ],
                    fill: false,
                    borderColor: [
                        'rgba(54, 162, 235, 1)'
                    ],
                    lineTension: 0.1,
                    borderWidth: 3
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>  

</body>

</html>