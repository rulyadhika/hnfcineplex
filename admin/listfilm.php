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
}elseif($_SESSION['role']==='petugas'){
    header('location:dashboard.php');
    exit;
}

    require '../utility/function.php';

   if(!isset($_GET['status'])){
    header('location:listfilm.php?status=aktif&page=1');die;
   }else{
       if(!isset($_GET['page'])){
        header('location:listfilm.php?status='.$_GET['status'].'&page=1');die;
       }
   }

   
   if($_GET['status']=="non aktif"){
        $films_status = "Non - Aktif";
        $req_data = "id,judul,aktor,genre,kategori,durasi,cover,bahasa,subtitle,sutradara,produksi,link_trailer";
   }
   else if($_GET['status']=="aktif"){
        $films_status = "Aktif";
        $req_data = "*";
   }
   else{
        $films_status = "Upcoming";
        $req_data = "*";
   }

   $films = select("SELECT id FROM film WHERE data_status = '$films_status'");
   $jumlahDataPerHalaman = 5;
   $jumlahData = count($films);
   $jumlahHalaman = ceil($jumlahData/$jumlahDataPerHalaman);
   $halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;
   $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

   $films = select("SELECT $req_data FROM film WHERE data_status = '$films_status' ORDER BY id DESC LIMIT $awalData, $jumlahDataPerHalaman");

   if(isset($_GET['key'])){
       if(empty(trim($_GET['key'])) || isset($_GET['reset'])){
           header('location:listfilm.php?status='.$_GET['status']);die;
        }
        else{
         $films = search($_GET,'film',$films_status);
         $jumlahDataPerHalaman = 5;
        $jumlahData = count($films);
        $jumlahHalaman = ceil($jumlahData/$jumlahDataPerHalaman);
        $halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;
        $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;
        $films = search($_GET,'film',$films_status,$awalData,$jumlahDataPerHalaman,'id','DESC');
        }
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

    <title>Admin - List Film | HNF Cineplex</title>

    <!-- Custom fonts for this template-->
    <link href="../asset/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

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

                <?php include "../components/topbar.php" ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Kelola Film</h1>

                    <div class="col-xl-12 col-lg-12">
                        <div class="card shadow mb-4">
                            <!-- Card Header -->
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">List Film
                                    <?= $_GET['status']=='non aktif'? 'Non Aktif': 'Aktif' ?></h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <!-- search field -->
                                <div class="row justify-content-end flex-column-reverse flex-lg-row">
                                    <div class="col-lg-7 d-flex flex-column justify-content-center mb-3">
                                        <span>
                                            Hasil Pencarian Untuk :
                                            <?= isset($_GET['key'])? $_GET['key'] : 'Film '.$_GET['status'] ?>
                                        </span>
                                    </div>
                                    <div class="col-lg-5 mb-3">
                                        <form class="navbar-search card" method="GET">
                                            <input type="hidden" name="status"
                                                value="<?= $_GET['status']=='non aktif'? 'non aktif' : ($_GET['status']=='aktif'? 'aktif' : 'upcoming') ?>">
                                            <input type="hidden" name="page" value="1">
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-light border-0 small"
                                                    placeholder="Cari Film.." name="key"
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

                                <!-- List Film Non Aktif-->
                                <?php if($_GET['status']=='non aktif') :?>
                                <?php foreach($films as $film) :?>
                                <div class="card mb-3">
                                    <div class="row no-gutters">
                                        <div class="col-lg-1">
                                            <img src="../asset/image/<?= $film['cover'] ?>" class="card-img" alt="...">
                                        </div>
                                        <div class="col-lg-10">
                                            <div class="card-body p-2">
                                            <li class="list-unstyled font-weight-bold"><?= $film['judul'] ?></li>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <li class="list-unstyled">
                                                        <span class="font-weight-bold">Aktor : </span>
                                                        <?= $film['aktor'] ?>
                                                        </li>
                                                        <li class="list-unstyled">
                                                            <span class="font-weight-bold">Genre : </span>
                                                            <?= $film['genre'] ?>
                                                        </li>
                                                        <li class="list-unstyled">
                                                            <span class="font-weight-bold">Kategori : </span>
                                                            <?= $film['kategori'] ?>
                                                        </li>
                                                        <li class="list-unstyled">
                                                            <span class="font-weight-bold">Durasi :</span>
                                                            <?= $film['durasi'] ?> Menit
                                                        </li>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <li class="list-unstyled">
                                                        <span class="font-weight-bold">Bahasa : </span>
                                                        <?= $film['bahasa'] ?>
                                                        </li>
                                                        <li class="list-unstyled">
                                                            <span class="font-weight-bold">Subtitle : </span>
                                                            <?= $film['subtitle'] ?>
                                                        </li>
                                                        <li class="list-unstyled">
                                                            <span class="font-weight-bold">Sutradara : </span>
                                                            <?= $film['sutradara'] ?>
                                                        </li>
                                                        <li class="list-unstyled">
                                                            <span class="font-weight-bold">Produksi :</span>
                                                            <?= $film['produksi'] ?>
                                                        </li>
                                                    </div>
                                                </div>
                                                <li class="list-unstyled mb-1">
                                                    <span class="font-weight-bold">Trailer :</span>
                                                     <?= $film['link_trailer'] ?>
                                                </li>
                                            </div>
                                        </div>
                                        <div
                                            class="col-lg-1 d-flex justify-content-center align-item-center flex-column pl-3 pr-3">
                                            <a class="btn btn-info text-light m-1" href="edit.php?data=film&id=<?= $film['id']; ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger text-light m-1 del-btn" data-id="<?= $film['id']; ?>" >
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>

                                <?php elseif($_GET['status']=='aktif') :?>
                                <!-- List Film Aktif-->
                                <?php foreach($films as $film) :?>
                                <div class="card mb-3">
                                    <div class="row no-gutters">
                                        <div class="col-lg-2">
                                            <img src="../asset/image/<?= $film['cover'] ?>" class="card-img" alt="...">
                                        </div>
                                        <div class="col-lg-9">
                                            <div class="card-body">
                                                <h5 class="card-title font-weight-bold"><?= $film['judul'] ?></h5>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <li class="list-unstyled">
                                                        <span class="font-weight-bold">Aktor : </span>
                                                        <?= $film['aktor'] ?>
                                                        </li>
                                                        <li class="list-unstyled">
                                                            <span class="font-weight-bold">Genre : </span>
                                                            <?= $film['genre'] ?>
                                                        </li>
                                                        <li class="list-unstyled">
                                                            <span class="font-weight-bold">Kategori : </span>
                                                            <?= $film['kategori'] ?>
                                                        </li>
                                                        <li class="list-unstyled">
                                                            <span class="font-weight-bold">Durasi :</span>
                                                            <?= $film['durasi'] ?> Menit
                                                        </li>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <li class="list-unstyled">
                                                        <span class="font-weight-bold">Bahasa : </span>
                                                        <?= $film['bahasa'] ?>
                                                        </li>
                                                        <li class="list-unstyled">
                                                            <span class="font-weight-bold">Subtitle : </span>
                                                            <?= $film['subtitle'] ?>
                                                        </li>
                                                        <li class="list-unstyled">
                                                            <span class="font-weight-bold">Sutradara : </span>
                                                            <?= $film['sutradara'] ?>
                                                        </li>
                                                        <li class="list-unstyled">
                                                            <span class="font-weight-bold">Produksi :</span>
                                                            <?= $film['produksi'] ?>
                                                        </li>
                                                    </div>
                                                </div>
                                                <li class="list-unstyled mb-1">
                                                    <span class="font-weight-bold">Trailer :</span>
                                                     <?= $film['link_trailer'] ?>
                                                </li>
                                                <li class="list-unstyled font-weight-bold">Sinopsis : </li>
                                                <p class="card-text text-justify pt-2 pr-2"
                                                    style="max-height: 300px; overflow-y : scroll">
                                                    <?= $film['sinopsis'] ?></p>
                                            </div>
                                        </div>
                                        <div
                                            class="col-lg-1 d-flex justify-content-center align-item-center flex-column pl-3 pr-3">
                                            <a class="btn btn-info text-light m-1"
                                                href="edit.php?data=film&id=<?= $film['id']; ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger text-light m-1 del-btn" data-id="<?= $film['id']; ?>">
                                                <i class="fas fa-times" style="pointer-events: none;"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>

                                <?php else :?>
                                    <!-- List film Upcoming -->
                                <?php foreach($films as $film) :?>
                                <div class="card mb-3">
                                    <div class="row no-gutters">
                                        <div class="col-lg-2">
                                            <img src="../asset/image/<?= $film['cover'] ?>" class="card-img" alt="...">
                                        </div>
                                        <div class="col-lg-9">
                                            <div class="card-body">
                                            <h5 class="card-title font-weight-bold"><?= $film['judul'] ?></h5>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <li class="list-unstyled">
                                                        <span class="font-weight-bold">Aktor : </span>
                                                        <?= $film['aktor'] ?>
                                                        </li>
                                                        <li class="list-unstyled">
                                                            <span class="font-weight-bold">Genre : </span>
                                                            <?= $film['genre'] ?>
                                                        </li>
                                                        <li class="list-unstyled">
                                                            <span class="font-weight-bold">Kategori : </span>
                                                            <?= $film['kategori'] ?>
                                                        </li>
                                                        <li class="list-unstyled">
                                                            <span class="font-weight-bold">Durasi :</span>
                                                            <?= $film['durasi'] ?> Menit
                                                        </li>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <li class="list-unstyled">
                                                        <span class="font-weight-bold">Bahasa : </span>
                                                        <?= $film['bahasa'] ?>
                                                        </li>
                                                        <li class="list-unstyled">
                                                            <span class="font-weight-bold">Subtitle : </span>
                                                            <?= $film['subtitle'] ?>
                                                        </li>
                                                        <li class="list-unstyled">
                                                            <span class="font-weight-bold">Sutradara : </span>
                                                            <?= $film['sutradara'] ?>
                                                        </li>
                                                        <li class="list-unstyled">
                                                            <span class="font-weight-bold">Produksi :</span>
                                                            <?= $film['produksi'] ?>
                                                        </li>
                                                    </div>
                                                </div>
                                                <li class="list-unstyled mb-1">
                                                    <span class="font-weight-bold">Trailer :</span>
                                                     <?= $film['link_trailer'] ?>
                                                </li>
                                                <li class="list-unstyled font-weight-bold">Sinopsis : </li>
                                                <p class="card-text text-justify pt-2 pr-2"
                                                    style="max-height: 300px; overflow-y : scroll">
                                                    <?= $film['sinopsis'] ?></p>
                                            </div>
                                        </div>
                                        <div
                                            class="col-lg-1 d-flex justify-content-center align-item-center flex-column pl-3 pr-3">
                                            <a class="btn btn-info text-light m-1"
                                                href="edit.php?data=film&id=<?= $film['id']; ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger text-light m-1 del-btn" data-id="<?= $film['id']; ?>">
                                                <i class="fas fa-times" style="pointer-events: none;"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php endif; ?>
                                <!-- end of list film aktif -->

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
                                        href="listfilm.php?status=<?= $_GET['status'] ?>&page=<?= $i?>&key=<?= $_GET["key"] ?>"><?= $i ?></a>
                                    <?php endif; ?>
                                    <?php endfor; ?>
                                    <i class="fa fa-chevron-right my-auto pl-2 pr-2"></i>
                                </div>
                                <!-- end of pagination -->

                            </div>
                            <!-- end of card body -->
                        </div>
                    </div>


                </div>
                <!-- /.container-fluid -->


                <?php include "../components/footer.php" ?>

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
                          swal('Berhasil!', ' Data film berhasil dihapus. Otomatis reload dalam 5 detik', 'success');

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
            return fetch("delete.php?data=film&id="+id)
            .then(result=>result.text())
            .then(result=>result)
        }
    </script>
</body>

</html>