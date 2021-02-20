<?php 
define("root",true);
session_start();
     require '../utility/function.php';
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

    <title>HNF Cineplex - Experience the immersive of watching movie</title>

    <style>
        .banner-box{
            position: relative;
            max-width: 1440px;
            margin: 0 auto;
            background: url('../asset/image/mintenance banner.svg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: 0 30%;
            height: 600px;
        }

        .banner-text{
            position: absolute;
            top: 50%;
            left: 5%;
            transform: translate(0,-50%);
            max-width: 30%;
        }

        .oops {
                font-size: 6rem;
                font-weight: 300;
                line-height: 1.2;
        }

        .button-on-carousel{
            outline: none !important;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .button-on-carousel:hover{
            opacity: 0.8;
            color: white;
        }

        
        @media (max-width:1024px){
            .banner-text{
                max-width: 45%;
            }
        }

        @media (max-width:768px){
            
            .banner-text{
                top: 50%;
                left: 50%;
                transform: translate(-50%,-50%);
                width: 80%;
                max-width: unset;
            }
            
        }

        @media (max-width:400px){
            .oops {
                font-size: 4rem;
            }
        }

    </style>

</head>

<body>
    <header class="mb-2">
        <?php include '../components/page/navbar.php' ?>

        <div class="banner-box">
            <div class="banner-text text-left text-sm-center text-md-left">
                <h1 class="text-custom font-weight-bolder mb-2 oops">Oops !</h1>
                <h3 class="text-custom mb-3 font-weight-bolder">Under Maintenance</h3>
                <h6 class="text-muted mb-3">Halaman ini sedang dalam proses perawatan, mohon maaf atas ketidaknyamanannya :(</h6>
                <a class="btn button-on-carousel bg-custom" href="../index.php">Back to homepage</a>
            </div>
        </div>
    </header>

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


</body>

</html>