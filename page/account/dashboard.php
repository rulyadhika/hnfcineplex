<?php
define("root",true);
session_start();
if(!isset($_SESSION["login"])){
    header("Location:../login.php");
    exit;
}

require '../../utility/function.php';

    //redirection handler
    if(!isset($_GET["r"])){
        header("location: dashboard.php?r=data");die;
    }else{
        $redirect = $_GET["r"];
    }

    $user_id = (int) $_SESSION['user_id'];
    $user_data = select("SELECT * FROM user WHERE id = $user_id")[0];

    if($redirect=="history"){
        $historys = select("SELECT pembayaran.id as id_pembayaran,pembayaran.harga_akhir, pembayaran.payment_status, pembayaran.data_timestamp as 
                            waktu_pembayaran, penjualan.tanggal_pembelian,penjualan.waktu_pembelian,
                            GROUP_CONCAT(tiket.id_kursi) as id_kursi,jadwal.data_timestamp,jadwal.studio,film.judul,film.cover FROM pembayaran 
                            JOIN penjualan ON pembayaran.id_penjualan = penjualan.id JOIN tiket ON penjualan.id_tiket = tiket.id 
                            JOIN jadwal ON tiket.id_jadwal = jadwal.id JOIN film ON jadwal.id_film = film.id WHERE penjualan.id_user = $user_id 
                            AND pembayaran.payment_status <> 'PENDING' 
                            GROUP BY penjualan.id ORDER BY pembayaran.id DESC LIMIT 0 , 10");

        //hanya mengambil key tiket dengan status pembayaran berhasil
        $tikets_key = select("SELECT pembayaran.id as id_pembayaran,tiket.tiket_key FROM pembayaran JOIN penjualan ON pembayaran.id_penjualan = penjualan.id
                             JOIN tiket ON penjualan.id_tiket = tiket.id WHERE penjualan.id_user = $user_id AND pembayaran.payment_status = 'BERHASIL' GROUP BY penjualan.id");

    }elseif($redirect=="cart"){
        $carts = select("SELECT pembayaran.id as id_pembayaran,pembayaran.harga_akhir, pembayaran.payment_status, pembayaran.data_timestamp as 
                        waktu_pembayaran, penjualan.tanggal_pembelian,penjualan.waktu_pembelian,
                        GROUP_CONCAT(tiket.id_kursi) as id_kursi,jadwal.data_timestamp,jadwal.studio,film.judul,film.cover FROM pembayaran 
                        JOIN penjualan ON pembayaran.id_penjualan = penjualan.id JOIN tiket ON penjualan.id_tiket = tiket.id 
                        JOIN jadwal ON tiket.id_jadwal = jadwal.id JOIN film ON jadwal.id_film = film.id WHERE penjualan.id_user = $user_id
                        AND pembayaran.payment_status = 'PENDING' GROUP BY penjualan.id ORDER BY pembayaran.id DESC LIMIT 0 , 10");

        // form input handler untuk manual konfirmasi pembayaran
        if(isset($_POST['payment-id'])){
            $result = updatePembayaran($_POST);
        }
    }else{
        // form input handler untuk update data user
        if(isset($_POST['simpan'])){
            $result = updateUser($_POST);
        }
    }

 ?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" href="../../asset/css/ui.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="../../asset/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
      rel="shortcut icon"
      type="image/png"
      href="../../asset/image/NEWLOGOWHITEBOLDENOUTLINE.png"
    />

    <title>HNF Cineplex - <?= ($redirect=='history'? 'Riwayat Pembelian' : ($redirect=='cart'? 'Keranjang' : 'Ubah Profil')) ?></title>

    <style>

        body {
            background-color: #F6F6F6;
        }

        .content-container {
            background-color: white;
        }

        .content-container ul li{
            list-style-type: none;
            display: flex;
            margin-bottom: 20px;
        }

        .redirect-btn{
            border-radius: unset !important;
            box-shadow: unset !important;
        }

        .redirect-btn:hover{
            color: #032541 !important;
        }

        .border-bottom-blue{
            border-bottom: 1px solid #032541;
        }

        label{
            width: 200px;
            display: inline-block;
            margin: auto 0;
            margin-right: 5px;
        }

        input{
            width: 100%;
        }

        @media (max-width:576px){
            .main-container{
                padding: 50px 30px;
            }
        }
    </style>

</head>

<body>
    <header class="mb-2">
        <?php include '../../components/page/navbar.php' ?>
    </header>

    <div class="main-container">
        <div class="row my-4">
            <div class="col">
                <h5 style="text-transform: capitalize;">Ubah Profile > <?= ($redirect=='history'? 'Riwayat Pembelian' : ($redirect=='cart'? 'Keranjang' : 'Ubah Profil')) ?></h5>
            </div>
        </div>
        <div class="row justify-content-around flex-column-reverse flex-md-row">
            <div class="col-md-3 card p-0 shadow-sm" style="height: fit-content;">
                <img src="https://ui-avatars.com/api/?name=<?= $user_data['nama']; ?>&size=64&background=032541&color=FFFFFF&format=svg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title font-weight-bold"><?= $user_data['nama']; ?></h5>
                    <div class="card-text mb-4">
                        <small class="text-muted">Besar file: maksimum 1.000.000 bytes (1 Megabytes)</small>
                        <small class="text-muted">Ekstensi file yang diperbolehkan: .JPG .JPEG .PNG</small>
                    </div>
                    <a href="#" class="btn btn-light w-100">Ubah Foto</a>
                </div>
            </div>
            <div class="col-md-8 content-container shadow-sm border p-0 rounded-lg  mb-4 mb-md-0" style="height: fit-content;">
                <div class="row text-center no-gutters border-bottom">
                    <a class="btn col-md w-100 redirect-btn <?= $redirect=="data"? 'text-custom border-bottom-blue' : 'text-black-50' ?>" href="dashboard.php?r=data">Data Akun</a>
                    <a class="btn col-md w-100 redirect-btn <?= $redirect=="history"? 'text-custom border-bottom-blue' : 'text-black-50' ?>" href="dashboard.php?r=history">Riwayat Pembelian</a>
                    <a class="btn col-md w-100 redirect-btn <?= $redirect=="cart"? 'text-custom border-bottom-blue' : 'text-black-50' ?>" href="dashboard.php?r=cart">Keranjang</a>
                </div>
                <div class="row p-3">
                    <?php if($redirect=="history") :?>
                        <div class="col-12">
                            <?php if(count($historys)==0) :?>
                            <div class="d-flex justify-content-center flex-column">
                                <small class="text-center">Belum ada riwayat pembelian</small>   
                                <div class="d-flex justify-content-center mt-2">
                                    <a class="btn btn-custom btn-sm" href="../../index.php#now-playing">Pesan tiket sekarang</a>
                                </div>             
                            </div>
                            <?php else: ?>
                            <div class="col-12 mb-3">
                                <small class="text-muted"><i class="fa fa-ticket-alt"></i> 10 Pemensanan terakhir kamu :</small>
                            </div>
                            <?php  foreach($historys as $history):?>
                            <div class="card mb-2">
                                <div class="row no-gutters">
                                    <div class="col-3 col-sm-2 col-lg-1">
                                        <img src="../../asset/image/<?= $history['cover']; ?>" class="card-img" alt="...">
                                    </div>
                                    <div class="col-9 col-sm-10 col-lg-11">
                                        <div class="row card-body py-1 pl-2 d-flex justify-content-between">
                                            <div class="col-lg-5">
                                                <p class="card-title text-custom mb-0"><?= $history['judul']; ?></p>
                                                <p class="card-text mb-0"><small>Tanggal : <?=strftime("%A, %d %B %Y", $history['data_timestamp']); ?></small></p>
                                                <p class="card-text mb-0"><small>Jam : <?= date("H:i",$history['data_timestamp']) ; ?> WIB</small></p>
                                                <p class="card-text mb-0"><small>Nomor kursi : <?= $history['id_kursi']; ?></small></p>
                                            </div>
                                            <div class="col-lg-5 d-flex justify-content-lg-center align-items-lg-center">
                                                <div>
                                                    <p class="card-text mb-0"><small class="text-muted">Waktu pembelian : <?= strftime("%d %B %Y", strtotime($history['tanggal_pembelian'])); ?>, <?= $history['waktu_pembelian']; ?> WIB</small></p>
                                                    <p class="card-text mb-0"><small class="text-muted">Total pembayaran : Rp. <?= $history['harga_akhir']; ?> </small></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 my-3 my-lg-0 d-flex justify-content-end align-items-lg-center">
                                                <button class="btn btn-sm btn-custom info-btn w-100" data-id="<?= $history['id_pembayaran']; ?>" data-section="history"><i class="fa fa-info-circle mr-2"></i>Detail</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php elseif($redirect=="cart") :?>
                        <div class="col-12">
                        <?php if(count($carts)==0) :?>
                            <div class="d-flex justify-content-center flex-column">
                                <small class="text-center">Belum ada tiket yang dipesan</small>   
                                <div class="d-flex justify-content-center mt-2">
                                    <a class="btn btn-custom btn-sm" href="../../index.php#now-playing">Pesan tiket sekarang</a>
                                </div>             
                            </div>
                        <?php else: ?>
                            <div class="col-12 mb-3">
                                <small class="text-muted"><i class="fa fa-ticket-alt"></i> 10 Pemensanan aktif kamu :</small>
                            </div>
                            <?php foreach($carts as $cart):?>
                                <div class="card mb-2">
                                    <div class="row no-gutters">
                                        <div class="col-3 col-sm-2 col-lg-1">
                                            <img src="../../asset/image/<?= $cart['cover']; ?>" class="card-img" alt="...">
                                        </div>
                                        <div class="col-9 col-sm-10 col-lg-11">
                                            <div class="row card-body py-1 pl-2 d-flex justify-content-between">
                                                <div class="col-lg-5">
                                                    <p class="card-title text-custom mb-0"><?= $cart['judul']; ?></p>
                                                    <p class="card-text mb-0"><small>Tanggal : <?=strftime("%A, %d %B %Y", $cart['data_timestamp']); ?></small></p>
                                                    <p class="card-text mb-0"><small>Jam : <?= date("H:i",$cart['data_timestamp']) ; ?> WIB</small></p>
                                                    <p class="card-text mb-0"><small>Nomor kursi : <?= $cart['id_kursi']; ?></small></p>
                                                </div>
                                                <div class="col-lg-5 d-flex justify-content-lg-center align-items-lg-center">
                                                    <div>
                                                        <p class="card-text mb-0"><small class="text-muted">Waktu pembelian : <?= strftime("%d %B %Y", strtotime($cart['tanggal_pembelian'])); ?>, <?= $cart['waktu_pembelian']; ?> WIB</small></p>
                                                        <p class="card-text mb-0"><small class="text-muted">Total pembayaran : Rp. <?= $cart['harga_akhir']; ?> </small></p>
                                                        <small><span class="text-muted">Status pembayaran : </span><span class="text-danger font-weight-bold"><?= $cart['payment_status']; ?></span></small>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 my-3 my-lg-0 d-flex justify-content-end align-items-lg-center">
                                                    <button class="btn btn-sm btn-custom info-btn w-100" data-id="<?= $cart['id_pembayaran']; ?>" data-section="cart"><i class="fa fa-info-circle mr-2"></i>Detail</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </div>
                    <?php else :?>
                        <div class="col-12 pl-0 pr-0 pl-md-2 pr-md-2">
                            <form action="" method="POST">
                                <input type="hidden" name="id_user" value="<?= $user_data['id']; ?>">
                                <div class="col-12 my-2">
                                    <h6 class="font-weight-bold mb-3 d-flex justify-content-between">Biodata Pribadi <i class="fas fa-pencil-alt text-black-50"></i></h6>
                                    <ul width="100%">
                                        <li class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" id="nama" name="nama" value="<?= $user_data['nama']; ?>" >
                                        </li>
                                        <li class="form-group">
                                            <label for="tanggal_lahir">Tanggal Lahir</label>
                                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $user_data['tanggal_lahir']; ?>" />
                                        </li>
                                        <li class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <select id="jenis_kelamin" class="form-control" name="jenis_kelamin" required>
                                                <option value="" hidden>-- Pilih Status --</option>
                                                <option value="Laki-Laki" <?= $user_data['jenis_kelamin']=='Laki-Laki'?'selected':''; ?>>Laki - Laki</option>
                                                <option value="Perempuan" <?= $user_data['jenis_kelamin']=='Perempuan'?'selected':''; ?>>Perempuan</option>
                                            </select>
                                        </li>
                                    </ul>
                                    <hr class="mt-5 mb-0">
                                </div> 
                                <div class="col-12 my-2 mt-5">
                                    <h6 class="font-weight-bold mb-3 d-flex justify-content-between">Data Akun <i class="fas fa-pencil-alt text-black-50"></i></h6>
                                    <ul width="100%" class="mb-0">
                                        <li class="form-group">
                                            <label for="">Email</label>
                                            <input class="form-control" id="" type="email" value="<?= $user_data['email']; ?>" disabled>
                                        </li>
                                        <li class="form-group">
                                            <label for="no_hp">No Hp</label>
                                            <input class="form-control" id="no_hp" name="no_hp" type="number" value="<?= $user_data['no_hp']; ?>" >
                                        </li>
                                        <li class="form-group">
                                            <a href="javascript:void(0)">Ganti password?</a>
                                        </li>
                                        <li class="d-flex justify-content-end mb-0 mt-4">
                                            <button class="btn btn-custom" type="submit" name="simpan">Simpan</button>
                                        </li>
                                    </ul>
                                </div> 
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="infoPembelianModal" tabindex="-1" aria-labelledby="infoPembelianModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoPembelianModalLabel">Info pembelian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row info-modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-custom" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <?php include '../../components/page/footer.php' ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script> -->

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- alert popUp area -->
    <?php if(isset($result)):?>
        <?php if($_GET['r']=='data') :?>
            <script>
                <?php if($result==(1)) :?>
                    swal('Berhasil!', 'Data akun berhasil diubah, silahkan masuk kembali', 'success')
                    .then(()=>{window.location.href="./logout.php"});
                <?php else :?>
                    swal('Error!', 'Data akun gagal diubah', 'error');
                <?php endif ?>
            </script>
        <?php elseif($_GET['r']=='cart') :?>
            <script>
                <?php if($result==(1)) :?>
                    swal('Berhasil!', 'Pembayaran berhasil dikonfirmasi', 'success')
                    .then(()=>{window.location.href="dashboard.php?r=cart"});
                <?php else :?>
                    swal('Error!', 'Pembayaran gagal dikonfirmasi', 'error');
                <?php endif ?>
            </script>
        <?php endif; ?>
    <?php endif; ?>

    <script>
        $('.info-btn').click(function(){
            $('#infoPembelianModal').modal('show');
            let section  = this.dataset.section;

            //idpembayaran
            let id  = this.dataset.id;

            let data;
            let ticketsKey;

            <?php if($redirect == 'history') :?> 
                data = <?= json_encode($historys) ?>;

                // get ticket data
                ticketsKey = <?= json_encode($tikets_key) ?>;

                // filter ticket data to match certain payment id
                let filteredTicketsKey = ticketsKey.filter(data=>data.id_pembayaran==id)[0];

            <?php elseif($redirect == 'cart') :?>
                data = <?= json_encode($carts) ?>
            <?php else :?>

            <?php endif; ?>

            //filter data to get information that match to certain payment id
            let filteredData = data.filter(data=>data.id_pembayaran == id)[0];

            function getDate(data, convertFromString){
                if(convertFromString){
                    return new Date(data).toLocaleDateString("id",{ weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                }
                
                   return new Date(1000*data).toLocaleDateString("id",{ weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            }

            function getTime(data){
                let epoch = new Date(1000*data);
                return `${epoch.getHours()}:${epoch.getMinutes()}:${epoch.getSeconds()}`;
            }

            $('.info-modal-body').html(
                `<div class="col-md-3">
                    <img src="../../asset/image/${filteredData.cover}" class="card-img" alt="...">
                </div>
                <div class="col-md-9 mt-3 mt-md-0">
                    <div class="row">
                        <div class="col-lg-5">
                            <p class="card-title text-custom mb-0">${filteredData.judul}</p>
                            <p class="card-text mb-0"><small>Tanggal : ${getDate(filteredData.data_timestamp,false)}</small></p>
                            <p class="card-text mb-0"><small>Jam : ${getTime(filteredData.data_timestamp)} WIB</small></p>
                            <p class="card-text mb-0"><small>Nomor kursi : ${filteredData.id_kursi}</small></p>
                            <p class="card-text mb-1"><small>Studio : ${filteredData.studio}</small></p>
                        </div>
                        <div class="col-lg-7">
                            <p class="card-text mb-0"><small class="text-muted">Tanggal pembelian : ${getDate(filteredData.tanggal_pembelian, true)}</small></p>
                            <p class="card-text mb-0"><small class="text-muted">Waktu pembelian : ${filteredData.waktu_pembelian} WIB</small></p>
                            <p class="card-text mb-0"><small class="text-muted">Total pembayaran : Rp. ${filteredData.harga_akhir} </small></p>
                            <p class="card-text mb-0"><small class="text-muted">Tanggal pembayaran : ${filteredData.waktu_pembayaran==0?'-' : getDate(filteredData.waktu_pembayaran,false)} </small></p>
                            <p class="card-text mb-0"><small class="text-muted">Waktu pembayaran : ${filteredData.waktu_pembayaran==0?'-' : getTime(filteredData.waktu_pembayaran) +  ' WIB'}</small></p>
                            <small><span class="text-muted">Status pembayaran : </span><span class="text-${filteredData.payment_status=="BERHASIL"? 'success' : 'danger'}  font-weight-bold">${filteredData.payment_status}</span></small>
                        </div>
                    </div>
                    <div class="row mt-3 confirmation-box">
                        <div class="col-12 d-flex justify-content-center align-items-center flex-column">
                            <small class="text-muted text-center">Fitur ini masih dalam proses pengembangan, silahkan tekan 'sudah bayar' untuk konfirmasi pembayaran secara manual.</small>
                            <form action="" method="POST">
                                <input type="hidden" value="${id}" name="payment-id"></input>
                                <button class="btn btn-sm btn-custom mt-2" type="submit">Sudah Bayar</button>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-3 qr-display">
                    </div>
                </div>`
            );

            //check if redirect is history? yes? then proceed hit api get ticket qr img
            <?php if($redirect=='history') :?>
                $('.confirmation-box').remove();

                //check if ticket with certain id payment is available
                if(ticketsKey.some(e => e.id_pembayaran == id)){
                    $('.qr-display').append(
                    `<div class="col-lg-3 mb-2 mb-lg-0 pr-lg-0">
                        <p class="card-text mb-0"><small>Kode QR Tiket : </small></p>
                    </div>
                        <div class="col-lg-4 mb-2 mb-lg-0 pl-lg-0 pr-lg-0 d-flex justify-content-center d-lg-block qr-img">
                            <div class="d-flex flex-column loading-qr">
                                <small class="text-center mb-2">Tunggu sebentar..</small>
                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="col-lg-5 d-flex justify-content-center align-items-center pl-lg-0 pr-lg-2">
                        <p class="card-text mb-0 text-center"><small class="text-muted">Berikan qr code ini kepada petugas di pos pemeriksaan tiket</small></p>
                    </div>`);

                    getData(filteredTicketsKey.tiket_key);
                };
            <?php endif; ?>

            // hit api get qr ticket img
            async function getData(key){
                try {
                    let data = await getQr(key);
                    $('.qr-img').html(`<img src="${data.url}" alt="${data.url}"/>`);
                } catch (error) {
                    alert(error);
                }
            }

            function getQr(key){
                return fetch(`https://api.qrserver.com/v1/create-qr-code/?data=${key}&size=150x150`)
                .then(response=>{
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    } else {
                        return response;
                    }
                })
                .then(response=>response)
                .finally(()=>{
                    $('.loading-qr').remove();
                });
            }

            // end of hit api get qr ticket img
        });
    </script>

</body>

</html>

</html>