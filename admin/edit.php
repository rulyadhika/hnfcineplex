<?php 
session_start();
define("root",true);
if(!isset($_SESSION["login"])){
    header("Location:../page/login.php");
    exit;
}

//redirection handler
if(!isset($_GET['data']) || !isset($_GET['id'])){
    header("location:dashboard.php");die;
}else{
    $id = $_GET['id'];
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

    // submit data handler
    if(isset($_POST['submit'])){
        if($_GET['data']=="film"){
            $result = updateFilm($_POST);
        }
        elseif($_GET['data']=="jadwal"){
            $result = updateJadwal($_POST);
        }elseif($_GET['data']=="voucher"){
            $result = updateVoucher($_POST);
        }elseif($_GET['data']=="user"){
            $result = updateUser($_POST);
        }
    }


    if($_GET['data']=="film"){
        $film = select("SELECT * FROM film WHERE id = $id")[0];
    }
    elseif($_GET['data']=="jadwal"){
        $jadwal = select("SELECT jadwal.* , film.judul,film.cover,film.id FROM jadwal JOIN film ON jadwal.id_film = film.id WHERE jadwal.id = $id")[0];
        $studio = array("A1","B2","C3","D4","E5");
    }elseif($_GET['data']=="voucher"){
        $voucher = select("SELECT * FROM voucher WHERE id = $id")[0];
    }elseif($_GET['data']=="user"){
        $user = select("SELECT * FROM user WHERE id = $id")[0];
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

    <title>Admin - Edit <?= $_GET['data']  ?> | HNF Cineplex</title> 

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
                    <h1 class="h3 mb-4 text-gray-800 text-capitalize">Edit <?= $_GET['data'] ?></h1>
                    <?php if(isset($_POST["submit"])) :?>
                    <div class="alert <?= ($result==1)?'alert-success':'alert-danger' ?> alert-dismissible fade show"
                        role="alert">
                        Data <?= $_GET['data'] ?>
                        <strong><?= ($result==1)?'Berhasil':'Gagal' ?></strong> Diubah!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php endif; ?>


                    <div class="col-xl-12 col-lg-12">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 ">
                                <h6 class="m-0 font-weight-bold text-primary text-capitalize">Form Edit
                                    <?= $_GET['data'] ?></h6>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <?php if($_GET['data']=="film") :?>
                                        <a class="btn btn-link mt-2 ml-2 p-1" href="listfilm.php">
                                            <i class="fas fa-chevron-left"></i>
                                            Kembali
                                        </a>
                                    <?php elseif($_GET['data']=="jadwal") :?>
                                        <a class="btn btn-link mt-2 ml-2 p-1" href="listjadwal.php">
                                            <i class="fas fa-chevron-left"></i>
                                            Kembali
                                        </a>
                                    <?php elseif($_GET['data']=="user") :?>
                                        <a class="btn btn-link mt-2 ml-2 p-1" href="list.php?data=user">
                                            <i class="fas fa-chevron-left"></i>
                                            Kembali
                                        </a>
                                    <?php elseif($_GET['data']=="voucher") :?>
                                        <a class="btn btn-link mt-2 ml-2 p-1" href="list.php?data=voucher">
                                            <i class="fas fa-chevron-left"></i>
                                            Kembali
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- Card Body -->

                            <!-- Update data film -->
                            <?php if($_GET['data']=='film') :?>
                            <div class="card-body pt-2">
                                <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id_film" value="<?= $id ?>"> 
                                <input type="hidden" name="cover_lama" value="<?= $film['cover'] ?>"> 
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img src="../asset/image/<?= $film['cover']; ?>" class="card-img" id="previewFile" alt="...">
                                            <input type="file" class="p-2" name="cover" onchange="document.getElementById('previewFile').src = window.URL.createObjectURL(this.files[0])">
                                        </div>
                                        <div class="col-md-9 bg-white">
                                            <div class="form-group">
                                                <label for="judul">Judul</label>
                                                <input type="text" class="form-control" id="judul"
                                                    placeholder="Masukan Judul Film" name="judul"
                                                    value="<?= $film['judul']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="aktor">Aktor</label>
                                                <input type="text" class="form-control" id="aktor"
                                                    placeholder="Masukan Aktor Film" name="aktor"
                                                    value="<?= $film['aktor']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="genre">Genre</label>
                                                <input type="text" class="form-control" id="genre"
                                                    placeholder="Masukan Genre Film, e.g : Action" name="genre"
                                                    value="<?= $film['genre']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="kategori">Kategori</label>
                                                <select id="kategori" name="kategori" class="form-control" required>
                                                    <option value="-" disabled hidden>-- Pilih Kategori --</option>
                                                    <option value="Segala Umur"
                                                        <?= $film["kategori"]=="Segala Umur"?'selected':'' ?>>Segala Umur
                                                    </option>
                                                    <option value="Remaja" <?= $film["kategori"]=="Remaja"?'selected':'' ?>>
                                                        Remaja</option>
                                                    <option value="Dewasa" <?= $film["kategori"]=="Dewasa"?'selected':'' ?>>
                                                        Dewasa</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="bahasa">Bahasa</label>
                                                <input type="text" class="form-control" id="bahasa"
                                                    placeholder="Masukan Bahasa Film" name="bahasa" value="<?= $film['bahasa']; ?>" required
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="subtitle">Subtitle</label>
                                                <input type="text" class="form-control" id="subtitle"
                                                    placeholder="Masukan Subtitle Film" name="subtitle" value="<?= $film['subtitle']; ?>" required
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="sutradara">Sutradara</label>
                                                <input type="text" class="form-control" id="sutradara"
                                                    placeholder="Masukan Sutradara Film" name="sutradara" value="<?= $film['sutradara']; ?>" required
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="produksi">Produksi</label>
                                                <input type="text" class="form-control" id="produksi"
                                                    placeholder="Masukan Produksi Film" name="produksi" value="<?= $film['produksi']; ?>" required
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="link_trailer">Link Trailer</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-link"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="link_trailer"
                                                    placeholder="Masukan Link Trailer Film" name="link_trailer" value="<?= $film['link_trailer']; ?>" required
                                                    required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="durasi">Durasi (Menit)</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-clock"></i></span>
                                                    </div>
                                                    <input type="number" class="form-control" id="durasi"
                                                    placeholder="Masukan Durasi Film" name="durasi"
                                                    value="<?= $film['durasi']; ?>" required>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">Menit</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select id="status" name="data_status" class="form-control" required>
                                                    <option value="-" hidden>-- Pilih Status --</option>
                                                    <option value="Upcoming"
                                                        <?= $film["data_status"]=="Upcoming"?'selected':'' ?>>Upcoming
                                                    </option>
                                                    <option value="Aktif"
                                                        <?= $film["data_status"]=="Aktif"?'selected':'' ?>>Aktif
                                                    </option>
                                                    <option value="Non - Aktif" <?= $film["data_status"]=="Non - Aktif"?'selected':'' ?>>
                                                        Non - Aktif</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label for="sinopsis">Sinopsis</label>
                                                    <span class="font-italic">Sisa Karakter : <span class="inputCounter font-weight-bold">2000</span></span>
                                                </div>
                                                <textarea class="form-control" id="sinopsis" name="sinopsis"
                                                    placeholder="Masukan Sinopsis Film"
                                                    style="min-height: 300px;max-height:600px"
                                                    required><?= $film['sinopsis']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group d-flex justify-content-end m-0 pt-1">
                                        <button type="submit" class="btn btn-primary" name="submit">Edit
                                            Film</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Update data jadwal -->
                            <?php elseif($_GET['data']=='jadwal') :?>
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id_jadwal" value="<?= $id ?>"> 
                                <input type="hidden" name="id_film" value="<?= $jadwal['id'] ?>"> 
                                    <div class="row d-flex flex-column-reverse flex-md-row">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="film">Film :</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-film"></i></span>
                                                    </div>
                                                    <select name="film" id="film" class="form-control">
                                                        <option selected disabled value="<?= $jadwal['judul']; ?>">
                                                            <?= $jadwal['judul']; ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select id="status" name="data_status" class="form-control">
                                                    <option value="-" disabled hidden>-- Pilih Status --</option>
                                                    <option value="Aktif"
                                                        <?= $jadwal["data_status"]=="Aktif"?'selected':'' ?>>Aktif
                                                    </option>
                                                    <option value="Non - Aktif" <?= $jadwal["data_status"]=="Non - Aktif"?'selected':'' ?>>
                                                        Non - Aktif</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal :</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                    <input type="date" id="tanggal" name="tanggal" class="form-control"
                                                    value="<?= date("Y-m-d",$jadwal['data_timestamp']); ?>">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">Bulan / Hari / Tahun</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="jam">Jam :</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-clock"></i></span>
                                                    </div>
                                                    <input type="time" id="jam" name="jam" class="form-control"
                                                    value="<?= date('H:i:s',$jadwal['data_timestamp']); ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="studio">Studio :</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-video"></i></span>
                                                    </div>
                                                    <select id="studio" name="studio" class="form-control">
                                                        <option value="-" disabled hidden>-- Pilih Studio --</option>
                                                        <?php foreach($studio as $studio) :?>
                                                        <option value="<?= $studio; ?>"
                                                            <?= $jadwal['studio']==$studio?'selected' : '' ?>>
                                                            <?= $studio; ?></option>
                                                        <?php endforeach; ?>
                                                </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="harga">Harga Tiket :</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                                    </div>
                                                    <select id="harga" name="harga" class="form-control">
                                                        <option value="-" disabled hidden>-- Pilih Harga --</option>
                                                        <option value="25000"
                                                            <?= $jadwal['harga']==25000? 'selected' : '' ?>>25000
                                                        </option>
                                                        <option value="30000"
                                                            <?= $jadwal['harga']==30000? 'selected' : '' ?>>30000
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <img src="../asset/image/<?= $jadwal['cover'] ?>" class="card-img filmCover"
                                                alt="...">
                                        </div>
                                    </div>
                                    <div class="form-group d-flex justify-content-end m-0 pt-1">
                                        <button type="submit" class="btn btn-primary" name="submit">Edit
                                            Jadwal</button>
                                    </div>
                                </form>
                            </div>

                            <!-- update data voucher -->
                            <?php elseif($_GET['data']=='voucher') :?>
                            <div class="card-body">
                                <form method="POST">
                                <input type="hidden" name="id_voucher" value="<?= $voucher['id'] ?>">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="kode">Kode :</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-key"></i></span>
                                                    </div>
                                                    <input type="text" id="kode" name="kode" class="form-control" placeholder="Masukan kode" value="<?= $voucher['kode']; ?>" required readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="persentase">Persentase :</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-tag"></i></span>
                                                    </div>
                                                    <input type="number" id="persentase" class="form-control" name="persentase" placeholder="Masukan persentase" value="<?= $voucher['persentase']; ?>" required readonly>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2"><i class="fa fa-percentage"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                            <label for="data_status">Status :</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-exclamation-circle"></i></span>
                                                    </div>
                                                    <select id="data_status" name="data_status" class="form-control" required>
                                                        <option value="" hidden >-- Pilih Status --</option>
                                                        <option value="Aktif" <?= $voucher['data_status']=='Aktif'?'selected':''; ?>>Aktif</option>
                                                        <option value="Non - Aktif" <?= $voucher['data_status']=='Non - Aktif'?'selected':''; ?>>Non - Aktif</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group d-flex justify-content-end m-0 pt-1">
                                        <button type="submit" class="btn btn-primary" name="submit">Edit
                                            Voucher</button>
                                    </div>
                                </form>
                            </div>
                             <!-- update data user -->
                            <?php elseif($_GET['data']=='user') :?>
                            <div class="card-body">
                                <form method="POST">
                                <input type="hidden" name="id_user" value="<?= $user['id'] ?>">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="email">Email :</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-at"></i></span>
                                                    </div>
                                                    <input type="text" id="email" name="email" class="form-control" placeholder="Masukan email" value="<?= $user['email']; ?>" required readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="no_hp">No Hp :</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">+62</i></span>
                                                    </div>
                                                    <input type="number" id="no_hp" name="no_hp" class="form-control" placeholder="Masukan no_hp" value="<?= $user['no_hp']; ?>" required readonly>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-phone"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama">Nama :</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                                                    </div>
                                                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukan nama" value="<?= $user['nama']; ?>" required readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="tanggal_lahir">Tanggal Lahir :</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                    <input type="date" id="tanggal_lahir" class="form-control" name="tanggal_lahir" placeholder="Masukan tanggal lahir" value="<?= $user['tanggal_lahir']; ?>" required readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="jenis_kelamin">Jenis Kelamin :</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-venus-mars"></i></span>
                                                    </div>
                                                    <select id="jenis_kelamin" class="form-control" name="jenis_kelamin" required>
                                                        <option value="" hidden>-- Pilih Status --</option>
                                                        <option value="Laki-Laki" <?= $user['jenis_kelamin']=='Laki-Laki'?'selected':'hidden'; ?>>Laki - Laki</option>
                                                        <option value="Perempuan" <?= $user['jenis_kelamin']=='Perempuan'?'selected':'hidden'; ?>>Perempuan</option>
                                                    </select>
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
                                                        <option value="manajer" <?= $user['role']=='manajer'?'selected':''; ?>>Manajer</option>
                                                        <option value="petugas" <?= $user['role']=='petugas'?'selected':''; ?>>Petugas</option>
                                                        <option value="konsumen" <?= $user['role']=='konsumen'?'selected':''; ?>>Konsumen</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group d-flex justify-content-end m-0 pt-1">
                                        <button type="submit" class="btn btn-primary" name="submit">Edit
                                            User</button>
                                    </div>
                                </form>
                            </div>

                            <?php endif; ?>
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
                <?php if($result==(1)) :?>
                    swal('Berhasil!', 'Data film berhasil diubah', 'success');
                <?php elseif($result==(-3)) :?>
                    swal('Error!', 'Yang anda upload bukan gambar!', 'error');
                <?php elseif($result==(-4)) :?>
                    swal('Error!', 'Ukuran gambar terlalu besar! (Max 1 Mb)', 'warning');
                <?php else :?>
                    swal('Error!', 'Data film gagal diubah', 'error');
                <?php endif ?>
            </script>
        <?php elseif($_GET['data']=='jadwal') :?>
            <script>
                <?php if($result==(1)) :?>
                    swal('Berhasil!', 'Data jadwal berhasil diubah', 'success');
                <?php elseif($result==(-3)) :?>
                    swal('Error!', 'Yang anda upload bukan gambar!', 'error');
                <?php elseif($result==(-4)) :?>
                    swal('Error!', 'Ukuran gambar terlalu besar! (Max 1 Mb)', 'warning');
                <?php else :?>
                    swal('Error!', 'Data jadwal gagal diubah', 'error');
                <?php endif ?>
            </script>
        <?php elseif($_GET['data']=='user') :?>
            <script>
                <?php if($result===(1)) :?>
                    swal('Berhasil!', 'Data user berhasil diubah', 'success');;
                <?php else :?>
                    swal('Gagal!', 'Data user gagal diubah', 'error');
                <?php endif; ?>
            </script>
        <?php elseif($_GET['data']=='voucher') :?>
            <script>
                <?php if($result===(1)) :?>
                    swal('Berhasil!', 'Data voucher berhasil diubah', 'success');
                <?php else :?>
                    swal('Gagal!', 'Voucher gagal diubah', 'error');
                <?php endif; ?>
            </script>
        <?php endif; ?>

    <?php endif; ?>

    <?php if($_GET['data']=='film') :?>
        <script>
            const inputCounter = document.querySelector(".inputCounter");
            const textarea = document.querySelector("textarea[name=sinopsis]");
            textarea.maxLength = 2000;
            inputCounter.innerText = 2000 - textarea.value.length;
            
            textarea.addEventListener("input",function(){
                inputCounter.innerText = 2000 - this.value.length ;
            })
        </script>
    <?php endif; ?>


</body>

</html>