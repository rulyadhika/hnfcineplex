<?php 
session_start();
define("root",true);
    require '../utility/function.php';

    $dateTime_now = strtotime(date("Y-m-d H:i:s"));
    $dateTime_now_plus_one_hour = strtotime("+1 hour",$dateTime_now);

    $id_film = $_GET['id'];
    $film = select("SELECT * FROM film WHERE id = $id_film")[0];
    $jadwals = select("SELECT * FROM jadwal WHERE id_film = $id_film AND 
                    data_timestamp >= $dateTime_now_plus_one_hour ORDER BY data_timestamp");

    $tanggal_tersedia = [];
    foreach($jadwals as $jadwall){
        if(!in_array(strftime('%A, %d %B %Y', $jadwall['data_timestamp']),$tanggal_tersedia)){
           $tanggal_tersedia[] = strftime('%A, %d %B %Y', $jadwall['data_timestamp']);
        }
    }

    // $cek = strtotime("2020-10-23 22:00:00");
    // var_dump($cek);
    // var_dump(date("Y-m-d H:i:s", $cek));

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

    <link rel="stylesheet" href="../asset/css/ui.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="../asset/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
      rel="shortcut icon"
      type="image/png"
      href="../asset/image/NEWLOGOWHITEBOLDENOUTLINE.png"
    />

    <title>HNF Cineplex - Detail Film</title>

    <style>
        .jadwal-box{
            transition: all 0.3s ease;
        }

        .jadwal-box:hover{
            background-color: #032541 !important;
            color: white !important;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            border: 1px solid #218c74 !important;
        }
    </style>
</head>

<body>
    <header class="mb-2">
        <?php include '../components/page/navbar.php' ?>
    </header>

    <div class="main-container">
        <div class="row pt-4 pb-3">
            <div class="col">
                <h3 class="text-custom"><?= $film['data_status']=="Upcoming"?'COMING SOON':'NOW PLAYING' ?></h3>
            </div>
        </div>
        <section class="row">
            <div class="col-md-3 mb-3">
                <img src="../asset/image/<?= $film['cover'] ?>" alt="" class="card-img-top shadow" style="border-radius : 10px" >
            </div>
            <div class="col-md pl-3">
                <div class="row">
                    <div class="col-lg-5 d-flex flex-column justify-content-between">
                        <div>
                            <h3 style="letter-spacing: 1px;" class="font-weight-bold text-custom"><?= $film['judul'] ?>
                            </h3>
                            <table>
                                <tr>
                                    <td class="font-weight-bold" style="width: 100px;">
                                        Durasi
                                    </td>
                                    <td>
                                        : <?= $film['durasi'] ?> Menit
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold" style="vertical-align:top">
                                        Aktor
                                    </td>
                                    <td>
                                        : <?= $film['aktor'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">
                                        Genre
                                    </td>
                                    <td>
                                        : <?= $film['genre'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">
                                        Kategori
                                    </td>
                                    <td>
                                        : <?= $film['kategori'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">
                                        Language
                                    </td>
                                    <td>
                                        : <?= $film['bahasa'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">
                                        Subtitle
                                    </td>
                                    <td>
                                        : <?= $film['subtitle'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">
                                        Sutradara
                                    </td>
                                    <td>
                                        : <?= $film['sutradara'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">
                                        Produksi
                                    </td>
                                    <td>
                                        : <?= $film['produksi'] ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center align-items-center mt-3 h-100">
                            <button class="btn btn-custom pesan-btn w-100">Pesan Tiket</button>
                        </div>
                    </div>
                    <div class="col-lg-7 mt-3 mt-lg-0">
                        <h5 style="letter-spacing: 1px;" class=" font-weight-bold">Watch Trailer</h5>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="<?= $film['link_trailer'] ?>" 
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>
                <h5 class="mt-4 mb-1 font-weight-bold">SINOPSIS</h5>
                <p class="text-justify">
                    <?= $film['sinopsis'] ?>
                </p>
            </div>
        </section>
        <hr>
        <section id="jadwal">
            <h4 style="letter-spacing: 1px;" class="font-weight-bold text-custom">Jadwal Tersedia</h4>
            <?php if(count($tanggal_tersedia)==0) :?>
            <h6 class="text-black-50">Belum ada jadwal yang tersedia, Stay Tune</h6>
            <?php endif; ?>
            <?php foreach($tanggal_tersedia as $tanggal) :?>
            <div class="row">
                <div class="col-12 mt-4">
                    <h5 class="mb-0"><?= $tanggal; ?></h5>
                </div>
                <?php foreach($jadwals as $jadwal) :?>
                    <?php if(strpos($tanggal,strftime('%A, %d %B %Y', $jadwal['data_timestamp']))!== false) :?>
                        <a class="col-sm-6 col-md-4 col-lg-3 col-xl-2 my-2" style=" text-decoration : none" href="booking.php?id=<?=$jadwal['id']?>">
                            <div class="p-3 d-flex flex-column rounded-lg border border-dark bg-light text-dark jadwal-box">
                                <span class="font-weight-bold">Jam : <?=  strftime('%H:%M', $jadwal['data_timestamp']); ?> WIB</span>
                                <span class="font-weight-bold">Studio : <?= $jadwal['studio'] ?></span>
                                <span class="font-weight-bold">Harga : Rp. <?= $jadwal['harga'] ?></span>
                            </div>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>
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

    <script>
        const pesanBtn = document.querySelector(".pesan-btn");

        pesanBtn.addEventListener("click", () => {
            window.scrollTo(0, document.getElementById("jadwal").offsetTop - 75);
        });
    </script>

</body>

</html>

</html>