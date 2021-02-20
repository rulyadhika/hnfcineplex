<?php 
session_start();
define("root",true);
if(!isset($_SESSION["login"])){
    header("Location:login.php");
    exit;
}
     require '../utility/function.php';


     //voucher input handler
    if(isset($_POST['voucher'])){
        $hitung_diskon = hitungDiskon((int) $_POST['id_jadwal'],(int) $_POST['jml_kursi'],$_POST['voucher']);
        echo json_encode($hitung_diskon[0]);
        return;
    };

    //redirect handler
    if(!isset($_POST['id_jadwal'])){
        header('location:../index.php');die;
    }

    $id_jadwal = (int) $_POST['id_jadwal'];
    //time handler
     
     $dateTime_now = strtotime(date("Y-m-d H:i:s"));
     $dateTime_now_plus_one_hour = strtotime("+1 hour",$dateTime_now);

     $waktu_film_tayang = select("SELECT data_timestamp FROM jadwal WHERE id = $id_jadwal")[0]["data_timestamp"];

     if($waktu_film_tayang <= $dateTime_now_plus_one_hour){
        echo "<script>
                confirm('mohon maaf tiket hanya bisa dipesan 1 jam sebelum film ditayangkan');
                // window.location.href = 'daftarfilm.php';
             </script>";die;
     }else{
         // submit checkout handler
        if(isset($_POST['checkout'])){
            $kursi_terpilih = $_POST['id_kursi'];
            //cek apakah kursi sudah dipesan atau belum
            $cek_kursi = select("SELECT id FROM tiket WHERE id_jadwal = $id_jadwal AND id_kursi = '$kursi_terpilih'");
            //jika sudah terpilih
            if(count($cek_kursi)==1){
                echo -2;
                return;
            }
            //jika belum terpilih
            echo insertTiket($_POST);
            return;
        }
     }
    //display data handler

     $data_jadwal = select("SELECT film.*,jadwal.data_timestamp,jadwal.studio,jadwal.harga 
                          FROM film JOIN jadwal ON film.id=jadwal.id_film WHERE jadwal.id = $id_jadwal")[0];

     $count_chairs = count(explode(',',$_POST['id_kursi']));
     $total_tiket_price = $count_chairs * $data_jadwal['harga'];

 ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" href="../asset/css/ui.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="../asset/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
      rel="shortcut icon"
      type="image/png"
      href="../asset/image/NEWLOGOWHITEBOLDENOUTLINE.png"
    />

    <title>HNF Cineplex - Checkout</title>

</head>

<body>
    <header class="mb-2">
        <?php include '../components/page/navbar.php' ?>
    </header>

    <div class="main-container">
        <div class="row pt-4 pb-3">
            <div class="col">
                <h4 class="mb-3">Checkout</h4>
                <hr style="margin: 0;">
            </div>
        </div>
        <section class="row px-lg-5">
            <div class="col-lg-8 mt-lg-4">
                <div class="row px-2">
                    <div class="col-sm-3 text-center">
                        <img src="../asset/image/<?= $data_jadwal['cover']; ?>" alt=""
                            class="card-img-top d-none d-sm-block" style="max-width: 188px ;">
                    </div>
                    <div class="col-sm-9 p-2 p-lg-0 px-lg-2">
                        <ul style="list-style-type: none;">
                            <li>
                                <h5 class="font-weight-bold text-custom"><?= $data_jadwal['judul']; ?> </h5>
                            </li>
                            <li>
                                <span class="d-inline-block font-weight-bold">Aktor :</span>
                                <?= $data_jadwal['aktor']?>
                            </li>
                            <li>
                                <span class="d-inline-block font-weight-bold">Genre :</span>
                                <?= $data_jadwal['genre']?>
                            </li>
                            <li>
                                <span class="d-inline-block font-weight-bold">Kategori :</span>
                                <?= $data_jadwal['kategori']?>
                            </li>
                            <li>
                                <span class="d-inline-block font-weight-bold">Tanggal :</span>
                                <?= strftime("%A, %d %B %Y", $data_jadwal['data_timestamp']) ?>
                            </li>
                            <li>
                                <span class="d-inline-block font-weight-bold">Jam :</span>
                                <?= date("H:i",$data_jadwal['data_timestamp'])  ?> WIB
                            </li>
                            <li>
                                <span class="d-inline-block font-weight-bold">Studio :</span>
                                <?= $data_jadwal['studio']?>
                            </li>
                            <li>
                                <span class="d-inline-block font-weight-bold">Harga Tiket :</span>
                                Rp. <?= $data_jadwal['harga']?>
                            </li>
                            <hr width="80%">
                            <li>
                                <span class="d-inline-block font-weight-bold">Jumlah Kursi :</span>
                                <span class="display-count-seat"><?= $count_chairs; ?></span>
                            </li>
                            <li>
                                <span class="d-inline-block font-weight-bold">Nomor Kursi :</span>
                                <span class="display-selected-seat"><?= $_POST['id_kursi']; ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 p-2 border" style="border-radius: 10px; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);">
                <div class="row">
                    <div class="col-12">
                        <h6 class="p-2 pb-3 border-bottom m-0 font-weight-bold">Pembayaran</h6>
                    </div>
                    <div class="col-12">
                        <div class="py-3 px-2 border-bottom">
                            <div class="input-group flex-nowrap">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-custom" id="addon-wrapping">%</span>
                                </div>
                                <input type="text" class="form-control mr-1 voucher-input" placeholder="Masukan kode promo" style="box-shadow: none !important;">
                                <button class="btn btn-sm btn-custom cek-btn">Cek</button>
                            </div>
                            <small class="feedback-voucher-input"></small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="py-3 px-2 border-bottom">
                            <div class="d-flex justify-content-between">
                                <small class="font-weight-bold">Metode Pembayaran</small>
                                <div class="dropdown">
                                    <a id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
                                        <small class="font-weight-bold text-custom">Pilih Metode</small>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-payment" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" data-id="GoPay">GoPay</a>
                                        <a class="dropdown-item" data-id="Ovo">OVO</a>
                                        <a class="dropdown-item" data-id="Virtual Account">Virual Account</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <small class="display-payment-method">-</small>
                                <small class="payment-instruction-btn text-muted"></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="py-3 px-2 border-bottom">
                            <small class="font-weight-bold">Rincian Pembayaran</small>
                            <div class="mt-1">
                                <ul style="list-style-type: none;" class="m-0">
                                    <li class="d-flex justify-content-between">
                                        <small>Tiket ( <?= $count_chairs; ?> x Rp. <?= $data_jadwal['harga']; ?>)</small>
                                        <small >Rp. <?= $total_tiket_price; ?></small>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <small class="display-discount-percentage">Diskon 0%</small>
                                        <small class="display-discount-amount">- Rp. 0</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="py-3 px-2 border-bottom d-flex justify-content-between">
                            <small class="font-weight-bold">Total Pembayaran</small>
                            <small class="display-total-price">Rp. <?= $total_tiket_price; ?></small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="pt-3 px-2 pb-2">
                            <button class="btn btn-custom w-100 checkout-btn">Checkout</button>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="paymentInstructionModal" tabindex="-1" aria-labelledby="paymentInstructionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentInstructionModalLabel">Cara pembayaran via <span class="paymentProvider"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-custom" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <?php include '../components/page/footer.php' ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script> -->

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script> -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
    </script>

    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!--  -->

    <script>
        // window.onbeforeunload = function() {
        //     return true;
        // };

        let paymentMethod = document.querySelectorAll(".dropdown-item");
        const displayPaymentMethod = document.querySelector(".display-payment-method");
        const paymentInstruction = document.querySelector(".payment-instruction-btn");

        paymentMethod.forEach(btn=>{
            btn.addEventListener("click",function(e){
                displayPaymentMethod.innerText = e.target.dataset.id;
                paymentInstruction.innerText = "Cara pembayaran";
                paymentInstruction.style.cursor = "pointer";
                paymentInstruction.setAttribute("data-id",e.target.dataset.id);
            })
        });

        paymentInstruction.addEventListener("click",function(){
            $('#paymentInstructionModal').modal('show');
            $('.paymentProvider').html(this.dataset.id);
        });

        $('.cek-btn').click(function(){
            $.ajax({
                url: "checkout.php",
                type : "POST",
                data : { 
                        id_jadwal : <?= json_encode($id_jadwal) ?>,
                        jml_kursi : <?= json_encode($count_chairs) ?>,
                        voucher : $('.voucher-input').val()
                    }, 
                dataType: "json",
                success: function(result){
                $(".display-total-price").html("Rp. "+result.final_price);
                $(".display-discount-amount").html("- Rp. "+result.discount);
                $(".display-discount-percentage").html("Diskon "+result.discount_percentage+ "%");
                
                if(result.success == true){
                    $(".feedback-voucher-input").html("Kode voucher berhasil diclaim");
                    if($(".feedback-voucher-input").hasClass("text-danger")){
                        $(".feedback-voucher-input").removeClass("text-danger");
                    }
                    $(".feedback-voucher-input").addClass("text-success");
                }else{
                    $(".feedback-voucher-input").html("Kode voucher tidak sesuai");
                    if($(".feedback-voucher-input").hasClass("text-success")){
                        $(".feedback-voucher-input").removeClass("text-success");
                    }
                    $(".feedback-voucher-input").addClass("text-danger");
                }
            }});
        });

        $('.checkout-btn').click(function(){
            $(this).addClass("p-1 pb-2");
            $(this).html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`);
            $(this).prop("disabled", true);
            $.ajax({
                url: "checkout.php",
                type : "POST",
                data : { 
                        checkout : true,
                        id_jadwal : <?= json_encode($id_jadwal) ?>,
                        id_kursi : <?= json_encode( $_POST['id_kursi']) ?>,
                        voucher_code : $('.voucher-input').val()
                    }, 
                success: function(result){
                    // console.log(result);
                    $('.checkout-btn').removeClass("pb-2");
                    $('.checkout-btn').text("Berhasil");
                    $('.checkout-btn').removeClass("checkout-btn");
                    if(result==1){
                        swal('Berhasil', 'Tiket berhasil dicheckout, tekan OK untuk melanjutkan ke proses pembayaran', 'success')
                        .then((value) => {
                            window.location.href = 'account/dashboard.php?r=cart';
                        });
                    }else if(result==(-2)){
                        swal("Maaf!", 'Tiket untuk kursi yang anda pilih telah dipesan, silahkan pilih kembali kursi', 'error')
                        .then((value) => {
                            window.location.href = 'booking.php?id=<?= json_encode($id_jadwal) ?>';
                        });
                    }else{
                        swal('Gagal!', 'Tiket gagal dicheckout, silahkan hubungi customer service kami', 'warning')
                        .then((value) => {
                            window.location.href = '../index.php';
                        });
                    }
            }});
        });

        
    </script>
</body>

</html>