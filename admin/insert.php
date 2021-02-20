<?php 
session_start();
define("root",true);
if(!isset($_SESSION["login"])){
    header("Location:../page/login.php");
    exit;
}

    //redirect handler
    if(!isset($_GET['data'])){
        header('location:dashboard.php');die;
    }

    if($_SESSION['role']==='konsumen'){
        header("Location:../index.php");
        exit;
    }elseif($_SESSION['role']==='petugas'){
        if($_GET['data']== 'user' || $_GET['data']== 'voucher' || $_GET['data']== 'film'){
            header("Location:dashboard.php");
            exit;
        }
    }

    require '../utility/function.php';

    //data handler
    if($_GET['data']=='jadwal'){
        $films = select("SELECT judul,cover FROM film WHERE data_status = 'Aktif'");
    }

    //submit handler
    if(isset($_POST['submit'])){
        if($_GET['data']=='film'){
            $result = insertFilm($_POST);
        }elseif($_GET['data']=='jadwal'){
            $result = insertJadwal($_POST);
        }elseif($_GET['data']=='user'){
            $result = register($_POST);
        }elseif($_GET['data']=='voucher'){
            $result = insertVoucher($_POST);
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

    <title>Admin - Tambah <?= $_GET['data'] ?> | HNF Cineplex</title>

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
                    <h1 class="h3 mb-4 text-gray-800 text-capitalize">Tambah <?= $_GET['data'] ?></h1>
                    <?php if(isset($_POST["submit"])) :?>
                    <div class="alert <?= ($result==1)?'alert-success':'alert-danger' ?> alert-dismissible fade show"
                        role="alert">
                        Data <?= $_GET['data'] ?> <strong><?= ($result==1)?'Berhasil':'Gagal' ?></strong> Ditambahkan!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php endif; ?>


                    <div class="col-xl-12 col-lg-12">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 ">
                                <h6 class="m-0 font-weight-bold text-primary text-capitalize">Form Tambah <?= $_GET['data'] ?></h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">

                            <!-- form tambah film -->

                            <?php if($_GET['data']=='film')  :?>
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img src="../asset/image/noimage.jpg" class="card-img" id="previewFile" alt="...">
                                            <input type="file" class="p-2" name="cover" onchange="document.getElementById('previewFile').src = window.URL.createObjectURL(this.files[0])">
                                        </div>
                                        <div class="col-md-9 bg-white">
                                            <div class="form-group">
                                                <label for="judul">Judul</label>
                                                <input type="text" class="form-control" id="judul"
                                                    placeholder="Masukan Judul Film" name="judul" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="aktor">Aktor</label>
                                                <input type="text" class="form-control" id="aktor"
                                                    placeholder="Masukan Aktor Film" name="aktor" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="genre">Genre</label>
                                                <input type="text" class="form-control" id="genre"
                                                    placeholder="Masukan Genre Film, e.g : Action" name="genre"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="kategori">Kategori</label>
                                                <select id="kategori" name="kategori" class="form-control" required>
                                                    <option value="" hidden>-- Pilih Kategori --</option>
                                                    <option value="Segala Umur">Segala Umur</option>
                                                    <option value="Remaja">Remaja</option>
                                                    <option value="Dewasa">Dewasa</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="bahasa">Bahasa</label>
                                                <input type="text" class="form-control" id="bahasa"
                                                    placeholder="Masukan Bahasa Film" name="bahasa"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="subtitle">Subtitle</label>
                                                <input type="text" class="form-control" id="subtitle"
                                                    placeholder="Masukan Subtitle Film" name="subtitle"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="sutradara">Sutradara</label>
                                                <input type="text" class="form-control" id="sutradara"
                                                    placeholder="Masukan Sutradara Film" name="sutradara"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="produksi">Produksi</label>
                                                <input type="text" class="form-control" id="produksi"
                                                    placeholder="Masukan Produksi Film" name="produksi"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="link_trailer">Link Trailer</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-link"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="link_trailer"
                                                    placeholder="Masukan Link Trailer Film" name="link_trailer"
                                                    required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="durasi">Durasi</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-clock"></i></span>
                                                    </div>
                                                    <input type="number" class="form-control" id="durasi"
                                                    placeholder="Masukan Durasi Film" name="durasi" required>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">Menit</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select id="status" name="data_status" class="form-control" required>
                                                    <option value="-" hidden>-- Pilih Status --</option>
                                                    <option value="Upcoming">Upcoming</option>
                                                    <option value="Aktif">Aktif</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label for="sinopsis">Sinopsis</label>
                                                    <span class="font-italic">Sisa Karakter : <span class="inputCounter font-weight-bold">2000</span></span>
                                                </div>
                                                <textarea class="form-control" id="sinopsis" name="sinopsis"
                                                    placeholder="Masukan Sinopsis Film"
                                                    style="min-height: 300px;max-height:600px" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group d-flex justify-content-end m-0 pt-1">
                                        <button type="submit" class="btn btn-primary" name="submit">Tambah
                                            Film</button>
                                    </div>
                                </form>
                                <?php elseif($_GET['data']=='jadwal')  :?>

                                <!--  form tambah jadwal -->

                                <form method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="film">Film :</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-film"></i></span>
                                                    </div>
                                                    <select name="film" id="film" class="form-control" required>
                                                        <option hidden value="">--Pilih Film--</option>
                                                        <?php foreach($films as $film) :?>
                                                        <option value="<?= $film['judul']?>"><?= $film['judul']?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal :</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                    <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">Bulan / Hari / Tahun</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="jam">Jam :</label>
                                                <div class="input-jam-area">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-clock"></i></span>
                                                        </div>
                                                        <input type="time" class="form-control input-jam" required>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="jam">
                                                <div class="text-right">
                                                    <a href="javascript:void(0)" class="tambah-jam-btn">+ Tambah Jam</a>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="studio">Studio :</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-video"></i></span>
                                                    </div>
                                                    <select id="studio" name="studio" class="form-control" required>
                                                        <option value="" hidden >-- Pilih Studio --</option>
                                                        <option value="A1">A1</option>
                                                        <option value="B2">B2</option>
                                                        <option value="C3">C3</option>
                                                        <option value="D4">D4</option>
                                                        <option value="E5">E5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="harga">Harga Tiket :</label> <span class="displayDay"></span>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                                    </div>
                                                    <select id="harga" name="harga" class="form-control">
                                                        <option value="" hidden>-- Pilih Harga --</option>
                                                        <option value="25000">25000</option>
                                                        <option value="30000">30000</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <img src="../asset/image/noimage.jpg" class="card-img filmCover" alt="...">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary submit-jadwal" name="submit" style="display: none;"></button>
                                </form>
                                    <div class="form-group d-flex justify-content-end m-0 pt-1">
                                        <button class="btn btn-primary tambah-jdwal-btn" >Tambah Jadwal</button>
                                    </div>

                                <!-- form tambah user -->
                                <?php elseif($_GET['data']=='user')  :?>

                                    <form method="POST">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row mb-0">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                <label for="nama-depan">Nama Depan :</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="nama-depan" name="nama-depan" placeholder="Masukan nama depan" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="nama-belakang">Nama Belakang :</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-user-circle"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="nama-belakang" name="nama-belakang" placeholder="Masukan nama belakang" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email :</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">@</span>
                                                    </div>
                                                    <input type="email" id="email" name="email" class="form-control" placeholder="Masukan email" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password :</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-lock"></i></span>
                                                    </div>
                                                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukan password" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="retype-password">Retype Password :</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-key"></i></span>
                                                    </div>
                                                    <input type="password" id="retype-password" class="form-control" name="retype-password" placeholder="Masukan ulang password" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                            <label for="role">Role :</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-user-tie"></i></span>
                                                    </div>
                                                    <select id="role" name="role" class="form-control" required>
                                                        <option value="" hidden >-- Pilih Role --</option>
                                                        <option value="manajer">Manajer</option>
                                                        <option value="petugas">Petugas</option>
                                                        <option value="konsumen">Konsumen</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group d-flex justify-content-end m-0 pt-1">
                                        <button type="submit" class="btn btn-primary" name="submit">Tambah
                                            User</button>
                                    </div>
                                </form>

                                <!-- form tambah user -->
                                <?php elseif($_GET['data']=='voucher')  :?>

                                <form method="POST">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="kode">Kode :</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-key"></i></span>
                                                </div>
                                                <input type="text" id="kode" name="kode" class="form-control" placeholder="Masukan kode" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="persentase">Persentase :</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-tag"></i></span>
                                                </div>
                                                <input type="number" id="persentase" class="form-control" name="persentase" placeholder="Masukan persentase" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-percentage"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group d-flex justify-content-end m-0 pt-1">
                                    <button type="submit" class="btn btn-primary" name="submit">Tambah
                                        Voucher</button>
                                </div>
                                </form>

                            <?php endif; ?>
                            </div>
                        </div>
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

    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- alert popUp area -->
    <?php if(isset($result)):?>

        <?php if($_GET['data']=='film') :?>
            <script>
                <?php if($result==(-2)) :?>
                    swal('Perhatian!', 'Silahkan upload file cover terlebih dahulu', 'warning');
                <?php elseif($result==(-3)) :?>
                    swal('Error!', 'Yang anda upload bukan gambar!', 'error');
                <?php elseif($result==(-4)) :?>
                    swal('Error!', 'Ukuran gambar terlalu besar! (Max 1 Mb)', 'warning');
                <?php elseif($result==(1)) :?>
                    swal('Berhasil!', 'Data film berhasil ditambahkan', 'success');
                <?php else :?>
                    swal('Error!', 'Data film gagal ditambahkan', 'error');
                <?php endif; ?>
            </script>
            
        <?php elseif($_GET['data']=='jadwal') :?>
            <script>
                <?php if($result==(1)) :?>
                    swal('Berhasil!', 'Data jadwal berhasil ditambahkan', 'success');
                <?php else :?>
                    swal('Error!', 'Data jadwal gagal ditambahkan', 'error');
                <?php endif; ?>
            </script>

        <?php elseif($_GET['data']=='user') :?>
            <script>
                <?php if($result===(1)) :?>
                    swal('Berhasil!', 'Akun berhasil dibuat', 'success');
                <?php elseif($result==='email-registered') :?>
                    swal('Gagal!', 'Email ini sudah terdaftar, silahkan gunakan email lain', 'error');
                <?php elseif($result==='password-not-match') :?>
                    swal('Gagal!', 'Password tidak sesuai, silahkan cek kembali', 'warning');
                <?php elseif($result==='password-length-not-enough') :?>
                    swal('Perhatian!', 'Panjang password minimal 8 karakter!', 'warning');
                <?php else :?>
                    swal('Gagal!', 'Akun gagal dibuat, silahkan tunggu beberapa saat lalu coba kembali', 'error');
                <?php endif; ?>
            </script>

        <?php elseif($_GET['data']=='voucher') :?>
            <script>
                <?php if($result===(1)) :?>
                    swal('Berhasil!', 'Voucher berhasil ditambahkan', 'success');
                <?php else :?>
                    swal('Gagal!', 'Kode voucher sudah pernah didaftarkan, masukan kode lain', 'error');
                <?php endif; ?>
            </script>

        <?php endif; ?>
        
    <?php endif; ?>

    <?php if($_GET['data']=='jadwal') :?>
        <script>
        const data = <?php echo json_encode($films) ?>; 
        const filmCoverDisplay = document.querySelector(".filmCover");
        const filmInput = document.querySelector("select[name=film]");
        const dateInput = document.querySelector("input[name=tanggal]");
        const priceInput = document.querySelector("select[name=harga]");
        const displayDay = document.querySelector(".displayDay");

        //untuk menampilkan nama hari dari tanggal yg dipilih
        dateInput.addEventListener("input",function(){
            const dateSelected = this.value;
            const daySelected = getDayName(dateSelected, "id");
            displayDay.innerText = daySelected;
            if(daySelected == "Sabtu" || daySelected == "Minggu"){
                priceInput.selectedIndex = "2";
            }else{
                priceInput.selectedIndex = "1";
            }
        })

        function getDayName(dateSelected, locale){
            let date = new Date(dateSelected);
            return date.toLocaleDateString(locale, { weekday: 'long' });        
        }
        // 

        // untuk menampilkan cover film yg dipilih
        filmInput.addEventListener("input",function(){
            let selectedFilm = this.value;
            let selectedFilmCover = data.filter(data=>data.judul == selectedFilm).map(data=>data.cover).join("");
            filmCoverDisplay.src = `../asset/image/${selectedFilmCover}`;
        })
        
    </script>

    <!-- script untuk mengatur input jam -->
    <script>
        const tambahJamBtn = document.querySelector('.tambah-jam-btn');
        const inputJamArea = document.querySelector('.input-jam-area');

        const inputSemuaJam = document.querySelector('input[name=jam]');

        let arrJam = [];

        tambahJamBtn.addEventListener('click',()=>{
            inputJamArea.innerHTML += `
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-clock"></i></span>
                    </div>
                    <input type="time" class="form-control input-jam" required>
                    <div class="input-group-prepend delete-jam-btn" style="cursor:pointer;">
                        <span class="input-group-text bg-danger text-white" style="pointer-events:none;" id="basic-addon1"><i class="fa fa-times"></i></span>
                    </div>
                </div>
            `;
        })

        document.addEventListener("click",(e)=>{
            if(e.target.classList.contains("delete-jam-btn")){
                e.target.parentElement.remove();
            }
        });

        document.querySelector(".tambah-jdwal-btn").addEventListener("click",()=>{
            arrJam = [];
            document.querySelectorAll(".input-jam").forEach(el=>{
                arrJam.push(el.value);
            })

            inputSemuaJam.value = arrJam;

            document.querySelector(".submit-jadwal").click();
        });
        

    </script>

    <?php elseif($_GET['data']=='film') :?>
        <script>
            const inputCounter = document.querySelector(".inputCounter");
            const textarea = document.querySelector("textarea[name=sinopsis]");
            textarea.maxLength = 2000;

            textarea.addEventListener("input",function(){
                inputCounter.innerText = 2000 - this.value.length ;
            })
        </script>
    <?php endif; ?>


</body>

</html>