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

    if(!isset($_GET['status'])){
        header('location:listjadwal.php?status=aktif&page=1');die;
    }
    else{
        if((!isset($_GET['page'])) && ($_GET["status"]== 'aktif')){
             header('location:listjadwal.php?status=aktif&page=1');die;
        }
    }

    if($_GET['status']=="non aktif"){
        $jadwals_status = "Non - Aktif";
        $jadwals = select("SELECT jadwal.* , film.judul FROM jadwal JOIN film ON jadwal.id_film = film.id WHERE jadwal.data_status = '$jadwals_status' ORDER BY data_timestamp");
   }
   else{
    $jadwals_status = "Aktif";
    $jadwals = select("SELECT id FROM jadwal WHERE data_status = '$jadwals_status'");
    $jumlahDataPerHalaman = 10;
    $jumlahData = count($jadwals);
    $jumlahHalaman = ceil($jumlahData/$jumlahDataPerHalaman);
    $halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;
    $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

    $jadwals = select("SELECT jadwal.* , film.judul,film.cover FROM jadwal JOIN film on jadwal.id_film = film.id WHERE jadwal.data_status = '$jadwals_status' ORDER BY data_timestamp LIMIT $awalData, $jumlahDataPerHalaman");

    if(isset($_GET['key'])){
        if(empty(trim($_GET['key'])) || isset($_GET['reset'])){
            header('location:listjadwal.php?status='.$_GET['status']);die;
        }
        else{
            $jadwals = search($_GET,'jadwal',$jadwals_status);
            $jumlahDataPerHalaman = 10;
            $jumlahData = count($jadwals);
            $jumlahHalaman = ceil($jumlahData/$jumlahDataPerHalaman);
            $halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;
            $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;
            $jadwals = search($_GET,'jadwal',$jadwals_status,$awalData,$jumlahDataPerHalaman,'data_timestamp','ASC');
        }
    }

    $dateTime_now = strtotime(date("Y-m-d H:i:s"));
    $dateTime_now_plus_one_hour = strtotime("+1 hour",$dateTime_now);
   }

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

    <title>Admin - List Jadwal | HNF Cineplex</title>

    <!-- Custom fonts for this template-->
    <link href="../asset/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../asset/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for table -->
    <link href="../asset/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include "../components/sidebar.php" ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include "../components/topbar.php" ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">List Jadwal</h1>

                    <!-- List Jadwal Aktif-->
                    <div class="col-xl-12 col-lg-12">
                        <div class="card shadow mb-4">
                            <!-- Card Header -->
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">List Jadwal
                                    <?= $_GET['status']=='non aktif'? 'Non Aktif': 'Aktif' ?></h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <?php if($_GET['status']=='aktif') :?>
                                <!-- search field -->
                                <div class="row justify-content-end flex-column-reverse flex-lg-row">
                                    <div class="col-lg-7 d-flex flex-column justify-content-center mb-3">
                                        <span>
                                            Hasil Pencarian Untuk :
                                            <?= isset($_GET['key'])? $_GET['key'] : 'Jadwal '.$_GET['status'] ?>
                                        </span>
                                    </div>
                                    <div class="col-lg-5 mb-3">
                                        <form class="navbar-search card" method="GET">
                                            <input type="hidden" name="status"
                                                value="<?= $_GET['status']=='non aktif'? 'non aktif':'aktif' ?>">
                                            <input type="hidden" name="page" value="1">
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-light border-0 small"
                                                    placeholder="Cari Data.." name="key"
                                                    <?= !isset($_GET['key'])?'':'value='.$_GET['key'] ?>>
                                                <div class="input-group-append">
                                                    <button class="btn btn-dark" type="submit">
                                                        <i class="fas fa-search fa-sm"></i>
                                                    </button>
                                                    <button class="btn btn-danger" type="submit" name='reset'>
                                                        <i class="fas fa-times fa-sm"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- end of search field -->
                                <?php endif; ?>

                                <!-- list jadwal non aktif -->
                                <?php if($_GET['status']=='non aktif') :?>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"
                                        data-order='[[ 0, "asc" ]]'>
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul</th>
                                                <th>Hari</th>
                                                <th>Tanggal</th>
                                                <th>Jam</th>
                                                <th>Studio</th>
                                                <th>Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $number=count($jadwals) ?>
                                            <?php foreach($jadwals as $jadwal) :?>
                                            <tr>
                                                <td class="text-center font-weight-bold"><?= $number; ?></td>
                                                <td><?= $jadwal['judul'] ?></td>
                                                <td> <?=  strftime('%A', $jadwal['data_timestamp']); ?>
                                                <td> <?=  strftime('%d %b %Y', $jadwal['data_timestamp']); ?>
                                                </td>
                                                <td><?= strftime('%H:%M', $jadwal['data_timestamp']); ?> WIB</td>
                                                <td><?= $jadwal['studio'] ?></td>
                                                <td>Rp. <?= $jadwal['harga'] ?></td>
                                                <td class="text-center">
                                                    <a class="btn btn-info text-light m-1" style="max-width: 50%;" 
                                                        href="edit.php?data=jadwal&id=<?= $jadwal['id']; ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a class="btn btn-danger text-light m-1 del-btn" data-id="<?= $jadwal['id']; ?>" style="max-width: 50%;">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php $number-- ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php else :?>

                                <!-- list jadwal aktif -->

                                <?php foreach($jadwals as $jadwal) :?>
                                <div class="card mb-3">
                                    <div class="row no-gutters">
                                        <div class="col-md-1">
                                            <img src="../asset/image/<?= $jadwal['cover'] ?>" class="card-img "
                                                alt="...">
                                        </div>
                                        <div class="col-md-10">
                                            <div class="card-body p-2">
                                                <li class="list-unstyled font-weight-bold"><?= $jadwal['judul'] ?>
                                                </li>
                                                <li class="list-unstyled">
                                                    <span class="font-weight-bold">Tanggal : </span>
                                                    <?=  strftime("%A, %d %B %Y",$jadwal['data_timestamp'])  ?></li>
                                                <li class="list-unstyled">
                                                    <span class="font-weight-bold">Jam : </span>
                                                    <?=  strftime("%H:%M",$jadwal['data_timestamp']) ?> WIB
                                                </li>
                                                <li class="list-unstyled">
                                                    <span class="font-weight-bold">Studio : </span>
                                                    <?= $jadwal['studio'] ?>
                                                </li>
                                                <li class="list-unstyled">
                                                    <span class="font-weight-bold">Harga : </span> Rp.
                                                    <?= $jadwal['harga'] ?>
                                                </li>
                                                <?php if($jadwal['data_timestamp'] < $dateTime_now_plus_one_hour) :?>
                                                <li class="list-unstyled">
                                                    <span class="font-weight-bold text-danger">(OUTDATED) </span>Silahkan update status jadwal ini menjadi <span class="text-danger">Non Aktif</span> 
                                                </li>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div
                                            class="col-md-1 d-flex justify-content-center align-item-center flex-column pl-3 pr-3">
                                            <a class="btn btn-info text-light m-1"
                                                href="edit.php?data=jadwal&id=<?= $jadwal['id']; ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger text-light m-1 del-btn" data-id="<?= $jadwal['id']; ?>">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php endif; ?>

                                <?php if($_GET["status"]== 'aktif') :?>
                                <!-- show data information -->
                                <div class="col-12">
                                    <span class="font-italic">Showing
                                        <?= ($awalData+1)." " ?>to<?= " ".($jumlahData<($jumlahDataPerHalaman+$awalData)?$jumlahData:($jumlahDataPerHalaman+$awalData))." " ?>of<?= " ".$jumlahData ?>
                                        Entries</span>
                                </div>
                                <!-- end of show data information -->

                                <!-- pagination -->
                                <div class="col-12 d-flex justify-content-center">
                                    <i class="fa fa-chevron-left my-auto pl-2 pr-2"></i>
                                    <?php for($i=1;$i<=$jumlahHalaman;$i++) :?>
                                    <?php if(!isset($_GET["key"])) :?>
                                    <a class="btn btn-sm <?= $_GET['page']== $i? 'btn-primary':'btn-light' ?> ml-1 mr-1"
                                        href="?status=<?= $_GET['status'] ?>&page=<?= $i?>"><?= $i?></a>
                                    <?php else :?>
                                    <a class="btn btn-sm <?= $_GET['page']== $i? 'btn-primary':'btn-light' ?> ml-1 mr-1"
                                        href="listjadwal.php?status=<?= $_GET['status'] ?>&page=<?= $i?>&key=<?= $_GET["key"] ?>"><?= $i ?></a>
                                    <?php endif; ?>
                                    <?php endfor; ?>
                                    <i class="fa fa-chevron-right my-auto pl-2 pr-2"></i>
                                </div>
                                <!-- end of pagination -->
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php include "../components/footer.php" ?> 

                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="../asset/jquery/jquery.min.js"></script>
    <script src="../asset/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../asset/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugins -->
    <script src="../asset/datatables/jquery.dataTables.min.js"></script>
    <script src="../asset/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": [1, 2, 4, 5, 6, 7]
                }]
            });
        });
    </script>

    <!-- Custom scripts for all pages-->
    <script src="../asset/js/sb-admin-2.min.js"></script>
    <script src="../asset/js/script.js"></script>

    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        const delBtn = document.querySelectorAll(".del-btn");
        delBtn.forEach(btn => {
            btn.addEventListener("click",async function(){
                let confirm = await swal({
                    title: "Apakah anda yakin?",
                    text: "Setelah dihapus, anda tidak akan bisa mendapatkan data ini lagi!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        return true;
                    } else {
                        return false;
                    }
                    });

                if(confirm==true){
                    try {
                       let result = await delData(this.dataset.id);
                       if(result==1){
                          swal('Berhasil!', ' Data jadwal berhasil dihapus. Otomatis reload dalam 5 detik', 'success');

                          setTimeout(()=>{
                            location.reload();
                          },5000);

                       }else{
                          swal('Error!', 'Data ini masih terhubung dengan database lain, silahkan cek kembali!', 'error');
                       }

                    } catch (error) {
                        console.error(error);
                    }
                }
            })
        } )

        function delData(id){
            return fetch("delete.php?data=jadwal&id="+id)
            .then(result=>result.text())
            .then(result=>result)
        }
    </script>

</body>

</html>