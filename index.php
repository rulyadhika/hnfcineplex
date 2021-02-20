<?php 
session_start();
define("root",true);
require 'utility/function.php';

    $now_playing = select("SELECT id,judul,cover,kategori,durasi,genre FROM film WHERE data_status = 'Aktif' LIMIT 0 , 10");
    $upcoming = select("SELECT id,judul,cover,kategori,durasi,genre FROM film WHERE data_status = 'Upcoming' LIMIT 0 , 10");

    $jumlah_film_now_playing = (int) select("SELECT COUNT(id) as jumlah_film FROM film WHERE data_status = 'Aktif'")[0]['jumlah_film'];
    $jumlah_film_upcoming = (int) select("SELECT COUNT(id) as jumlah_film FROM film WHERE data_status = 'Upcoming'")[0]['jumlah_film'];
    

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

    <link rel="stylesheet" href="asset/css/style.css">
    <link rel="stylesheet" href="asset/css/ui.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="asset/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
      rel="shortcut icon"
      type="image/png"
      href="asset/image/NEWLOGOWHITEBOLDENOUTLINE.png"
    />

    <!-- slick.js -->
    <link rel="stylesheet" type="text/css" href="asset/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="asset/slick/slick-theme.css"/>

    <title>HNF Cineplex - Experience the immersive of watching movie</title>

</head>

<body>
    <header>
        <?php include 'components/page/navbar.php' ?>

        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner image-carousel-wrapper">
                <div class="text-on-carousel">
                    <h1 class="font-weight-bolder mb-3">Experience the immersive of watching movie</h1>
                    <h6 class="mb-3">HNF CINEPLEX merupakan salah satu bioskop di dunia yang mendapat sertifikat pelayanan terbaik.</h6>
                    <button class="button-on-carousel">Mulai Menonton</button>
                </div>
                <div class="carousel-item active">
                    <img src="asset/image/bioskop banner2.svg" class="d-block w-100" alt="...">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </header>

    <div class="main-container">
        <section class="movie-type mb-5" id="now-playing">
            <h4 class="text-custom font-weight-bold mb-1"><small><i class="fa fa-play"></i></small> Now Showing</h4>
            <small class="d-block text-muted mb-3">Film yang saat ini sedang ditayangkan</small>
            <div class="pl-3 pr-3">
                <div class="multiple-items">
                <?php foreach($now_playing as $film_now) :?>
                    <a class="film-card mt-3 mb-3 mx-2" href="page/detail.php?id=<?= $film_now['id']; ?>">
                        <div class="card">
                            <img src="asset/image/<?= $film_now['cover']; ?>" class="card-img-top px-2 pt-2" style="border-radius: 15px 15px 0 0;" alt="..." loading="lazy">
                            <div class="card-body film-title d-flex flex-column">
                                <h6 class="font-weight-bold mb-1"><?= $film_now['judul']; ?></h6>
                                <small class="mb-0 text-muted"><?= $film_now['genre']; ?> | <?= $film_now['kategori']; ?> | <?= $film_now['durasi']; ?> Menit</small>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php if($jumlah_film_now_playing>10) :?>
            <div class="row d-flex justify-content-center mt-3 mb-1">
                <a href="" class="btn btn-custom">Show All</a>
            </div>
            <?php endif; ?>
        </section>
        <section class="movie-type mb-5" id="upcoming">
            <h4 class="text-custom font-weight-bold mb-1"><small><i class="fa fa-pause"></i></small> Upcoming</h4>
            <small class="d-block text-muted mb-3">Film yang akan segera hadir untuk ditayangkan</small>
            <div class="pl-3 pr-3">
                <div class="multiple-items">
                <?php foreach($upcoming as $film_upcoming) :?>
                    <a class="film-card mt-3 mb-3 mx-2" href="page/detail.php?id=<?= $film_upcoming['id']; ?>">
                        <div class="card">
                            <img src="asset/image/<?= $film_upcoming['cover']; ?>" class="card-img-top px-2 pt-2" style="border-radius: 15px 15px 0 0;" alt="..." loading="lazy">
                            <div class="card-body film-title d-flex flex-column">
                                <h6 class="font-weight-bold mb-1"><?= $film_upcoming['judul']; ?></h6>
                                <small class="mb-0 text-muted"><?= $film_now['genre']; ?> | <?= $film_upcoming['kategori']; ?> | <?= $film_upcoming['durasi']; ?> Menit</small>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php if($jumlah_film_upcoming>10) :?>
            <div class="row d-flex justify-content-center mt-3 mb-1">
                <a href="" class="btn btn-custom">Show All</a>
            </div>
            <?php endif; ?>
        </section>
    </div>

    <?php include 'components/page/footer.php' ?>

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
        const navbar = document.querySelector(".navbar");
        const buttonOnCarousel = document.querySelector(".button-on-carousel");

        buttonOnCarousel.addEventListener("click",()=>{
            if(window.innerWidth < 768){
                // window.scrollTo(0,document.querySelector("#now-playing").offsetTop);
                document.querySelector("#now-playing").scrollIntoView();
            }else{
                document.querySelector("#now-playing").scrollIntoView({block: "center"});
            }
        })

        window.onload = function () {
            let pageOffsetYAxis = window.pageYOffset;
            navbar.classList.replace("navbar-dark","navbar-custom");

            if (pageOffsetYAxis > 30) {
                navbar.classList.replace("navbar-custom","navbar-dark");
            }
        }

        window.onscroll = function () {
            if (window.pageYOffset == 0) {
                navbar.classList.replace("navbar-dark","navbar-custom");
            } else if (window.pageYOffset > 30) {
                navbar.classList.replace("navbar-custom","navbar-dark");
            }
            // else if (window.pageYOffset < 350) {
            //     document.querySelector(".backToTopBox").style.transform =
            //     "translateX(" + 1 * 100 + "%)";
            // } else if (window.pageYOffset > 350) {
            //     document.querySelector(".backToTopBox").style.transform =
            //     "translateX(" + -0.2 * 100 + "%)";
            // }
        };
    </script>

    <script type="text/javascript" src="asset/slick/slick.min.js"></script>

    <script type="text/javascript">
      $(".multiple-items").slick({
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3,
            },
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2,
            },
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
            },
          },
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ],
      });
    </script>


</body>

</html>

</html>