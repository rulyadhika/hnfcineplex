<?php 
session_start();
define("root",true);
     require '../utility/function.php';

     $id_jadwal = intval($_GET['id']);

     $dateTime_now = strtotime(date("Y-m-d H:i:s"));
     $dateTime_now_plus_one_hour = strtotime("+1 hour",$dateTime_now);

     $waktu_film_tayang = select("SELECT data_timestamp FROM jadwal WHERE id = $id_jadwal")[0]["data_timestamp"];

     if($waktu_film_tayang <= $dateTime_now_plus_one_hour){
        echo "<script>
                confirm('mohon maaf tiket hanya bisa dipesan 1 jam sebelum film ditayangkan');
                window.location.href = 'daftarfilm.php';
             </script>";die;
     }

     $studioChairs = array("A1","A2","A3","A4","A5","A6","A7","A8","A9","A10","A11","A12","A13","A14","A15",
                     "B1","B2","B3","B4","B5","B6","B7","B8","B9","B10","B11","B12","B13","B14","B15",
                     "C1","C2","C3","C4","C5","C6","C7","C8","C9","C10","C11","C12","C13","C14","C15",
                     "D1","D2","D3","D4","D5","D6","D7","D8","D9","D10","D11","D12","D13","D14","D15",
                     "E1","E2","E3","E4","E5","E6","E7","E8","E9","E10","E11","E12","E13","E14","E15",
                     "F1","F2","F3","F4","F5","F6","F7","F8","F9","F10","F11","F12","F13","F14","F15",
                     "G1","G2","G3","G4","G5","G6","G7","G8","G9","G10","G11","G12","G13","G14","G15",
                     "H1","H2","H3","H4","H5","H6","H7","H8","H9","H10","H11","H12","H13","H14","H15",
                     "I1","I2","I3","I4","I5","I6","I7","I8","I9","I10","I11","I12","I13","I14","I15",
                     "J1","J2","J3","J4","J5","J6","J7","J8","J9","J10","J11","J12","J13","J14","J15",
                     "K1","K2","K3","K4","K5","K6","K7","K8","K9","K10","K11","K12","K13","K14","K15");

    $studioChairsRow = ["A","B","C","D","E","F","G","H","I","J","K"];
    $exceptionStudioChairs = ["A4","B4","C4","D4","E4","F4","G4","H4","I4","J4",
                              "A12","B12","C12","D12","E12","F12","G12","H12","I12","J12"];
    // "A4","B4","C4","D4","E4","F4","G4","H4","I4","J4"
                    
     $chairsBooked = select("SELECT id_kursi FROM tiket WHERE id_jadwal = $id_jadwal");
     $chairsOccupied = [];
    foreach($chairsBooked as $chairBooked){
        $chairsOccupied[]= $chairBooked['id_kursi'];
    }

    $data_jadwal = select("SELECT film.judul,film.cover,jadwal.data_timestamp,jadwal.studio,jadwal.harga 
                          FROM film JOIN jadwal ON film.id=jadwal.id_film WHERE jadwal.id = $id_jadwal")[0];

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

    <title>HNF Cineplex - Booking Tiket</title>

    <style>
        .seat{
            background-color: #DC3545;
            color: white;
            outline: none !important;
            border: none !important;
            box-shadow: none!important;
            margin: 2px;
            width: 32px;
            border-radius: 4px;
            text-align: center;
        }
        /* .seat:hover{
            color: white;
        } */
        
        .empty {
            display: block;
            margin: 2px;
            width: 32px;
            height: 24px;
            border-radius: 4px;
        }

        .square{
            display: inline-block;
            margin: 2px;
            width: 12px;
            height: 12px;
            border-radius: 2px;
            margin: auto 3px;
        }

        .available{
            background-color: #28A745;
        }

        .available:hover{
            background-color: #1d8f38;
        }

        .choosen{
            background-color: #0064cf;
        }

        /* .choosen:hover{
            background-color: #007BFF;
        } */

        .booked{
            background-color: #DC3545;
        }

        .studio-wrapper{
            overflow-x:auto;
        }

        .screen-row{
            background-color: #032541;
            color: white;
            text-align: center;
            font-size: 12px;
        }

        .baris{
            width: fit-content;
            margin: 0 auto;
        }

        input{
            display: none;
            z-index: -99;
        }

        @media (max-width:620px){
            .seat{
                font-size: 8px;
                margin: 1px;
                width: 18px;
                height: 18px;
                border-radius: 4px;
                text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
                text-align: center;
                font-weight: bold;
            }

            .empty{
                margin: 1px;
                width: 18px;
                height: 18px;
            }
        }
    </style>

</head>

<body>
    <header class="mb-2">
        <?php include '../components/page/navbar.php' ?>
    </header>

    <div class="main-container">
        <!-- <div class="row pt-4 pb-3">
            <div class="col">
                <h4>Choose Seat Position</h4>
            </div>
        </div> -->
        <section class="row pt-4 pt-lg-5 mt-lg-2">
            <div class="col-lg-8 my-2">
                <div class="col-md-9 col-lg-10 screen-row p-0 mx-auto mb-5">Screen</div>
                <div class="studio-wrapper">
                    <?php foreach($studioChairsRow as $row) :?>
                    <div class="baris d-flex justify-content-center">
                        <?php foreach($studioChairs as $studioChair) :?>
                        <?php if(strpos($studioChair, $row)!== false) :?>
                            <?php if(in_array($studioChair,$exceptionStudioChairs)) :?>
                                <span class="empty"></span>
                            <?php else :?>
                                <button class="seat <?= in_array($studioChair,$chairsOccupied)? '' : 'available' ?>"
                                <?= in_array($studioChair,$chairsOccupied)? '' : 'data-id='.$studioChair ?>><?= $studioChair; ?></button>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <small class="col-12 p-0 text-center d-block mt-2 mb-1 text-muted">Geser untuk melihat keseluruhan kursi</small>
                <div class="col-12 justify-content-center d-flex">
                    <div class="mx-2">
                       <span class="square available"></span><small>Tersedia</small>
                    </div>
                    <div class="mx-2">
                       <span class="square choosen"></span><small>Dipilih</small> 
                    </div>
                    <div class="mx-2">
                       <span class="square booked"></span><small>Terisi</small> 
                    </div>
                </div>
            </div>
            <div class="col-lg-4 my-2 mt-4 mt-lg-2 align-self-center">
                <div class="row flex-lg-row-reverse">
                    <div class="col-sm-4 text-center">
                        <img src="../asset/image/<?= $data_jadwal['cover']; ?>" alt="" class="card-img-top d-none d-sm-block ml-auto mr-0 ml-lg-auto mr-lg-auto" style="max-width: 188px ;">
                    </div>
                    <div class="col-sm-8 p-2 p-lg-0">
                        <ul style="list-style-type: none;">
                            <li>
                               <h5 class="font-weight-bold text-custom"><?= $data_jadwal['judul']; ?> </h5>
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
                            <hr>
                            <li>
                                <span class="d-inline-block font-weight-bold">Jumlah Kursi :</span>
                                <span class="display-count-seat">-</span>
                            </li>
                            <li>
                                <span class="d-inline-block font-weight-bold">Nomor Kursi :</span>
                                <span class="display-selected-seat">-</span>
                            </li>
                            <li>
                                <span class="d-inline-block font-weight-bold">Total Pembayaran :</span>
                                Rp. <span class="display-total-payment">-</span>
                            </li>
                            <li class="mt-3">
                                <form action="checkout.php" method="POST" onsubmit="return validation()">
                                    <input type="hidden" name="id_jadwal" value="<?= $_GET['id'] ?>" required>
                                    <input type="hidden" id="kursi" name="id_kursi" required>
                                    <button type="submit" class="btn btn-custom w-100">Lanjutkan</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
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
        const seats = document.querySelectorAll(".seat");
        const inputSeat = document.querySelector("input[name=id_kursi]");
        
        let displaySelectedSeat = document.querySelector(".display-selected-seat");
        let displayCountSeat = document.querySelector(".display-count-seat");
        let displayTotalPayment = document.querySelector(".display-total-payment");
        let tiketPrice = <?= json_encode($data_jadwal['harga']) ?>;
        let selectedSeatArr = [];

        seats.forEach(seat => {
            seat.addEventListener("click", function (e) {
                let selectedSeat = e.target;
                if (selectedSeat.classList.contains("available")) {
                    selectedSeat.classList.remove("available");
                    selectedSeat.classList.add("choosen");
                    proceedInput(selectedSeat.dataset.id,"insert");
                   
                } else if (selectedSeat.classList.contains("choosen")) {
                    selectedSeat.classList.remove("choosen");
                    selectedSeat.classList.add("available");
                    proceedInput(selectedSeat.dataset.id,"delete");
                   
                }
            })
        });

        function proceedInput(id,status){
            if(status==="insert"){
                selectedSeatArr.push(id);
            }else{
                //remove selected seat from array
                selectedSeatArr.splice(selectedSeatArr.indexOf(id),1);
            }

            if(selectedSeatArr.length==0){
                inputSeat.value = "";
                displaySelectedSeat.innerText = "-";
                displayTotalPayment.innerText = "-";
                displayCountSeat.innerText = "-";
            }else{
                inputSeat.value = selectedSeatArr;
                displaySelectedSeat.innerText = selectedSeatArr.join(", ");
                displayCountSeat.innerText = selectedSeatArr.length;
                displayTotalPayment.innerText = tiketPrice * selectedSeatArr.length;
            }
        }

        function validation(){
            <?php if(!isset($_SESSION['login'])) :?>
                swal('Perhatian!', 'Silahkan log in terlebih dahulu', 'warning')
                        .then((value) => {
                            window.location.href = 'login.php';
                });
                return false;
            <?php else :?>
                if(($('input[name="id_kursi"]').val()).trim().length<2){
                    swal('Perhatian!', 'Silahkan pilih kursi terlebih dahulu', 'warning');
                    return false;
                }else{
                    return true;
                }
            <?php endif ?>;
        }
    </script>

</body>

</html>