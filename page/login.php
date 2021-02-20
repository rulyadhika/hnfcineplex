<?php 
define("root",true);
session_start();
 require '../utility/function.php';

  if(isset($_SESSION["login"])){
    header("Location:../index.php");
    exit;
  }

  if(isset($_POST['masuk'])){
      $result = login($_POST);

      if($result==='konsumen'){
        header('location:../index.php');die;
      }elseif($result==='manajer' || $result==='petugas' || $result==='dev'){
        header('location:../admin/dashboard.php');die;
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

  <title>HNF Cineplex - Log In</title>

  <!-- Custom fonts for this template-->
  <link href="../asset/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../asset/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- custom css -->
  <link rel="stylesheet" href="../asset/css/ui.css">

  <style>
    body{
      /* background: url('https://source.unsplash.com/23LET4Hxj_U/1280x720');
      background-position: center;
      background-size: cover; */
      color: black !important;

      height: 100vh;
    }

    .password-view{
        right: 5% !important;
    }

    .bg-login-section-image {
      background: url("https://source.unsplash.com/evlkOfkQ5rE/600x800");
      background-position: center;
      background-size: cover;
    }
  </style>

</head>

<body class="bg-custom">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-section-image">
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Selamat Datang!</h1>
                  </div>

                  <form class="user" action="" method="POST">
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Masukan Email" name="email" required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user password-input" id="exampleInputPassword" placeholder="Password" name="password" required>
                      <i class="fa fa-eye-slash password-view"></i>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Ingat Saya</label>
                      </div>
                    </div>
                    <button class="btn btn-custom btn-user btn-block" type="submit" name="masuk">
                      Masuk
                    </button>

                    <hr>
                    <a href="javascript:void(0)" class="btn btn-google btn-user btn-block">
                      <i class="fab fa-google fa-fw"></i> Masuk dengan Google
                    </a>
                    <a href="javascript:void(0)" class="btn btn-facebook btn-user btn-block">
                      <i class="fab fa-facebook-f fa-fw"></i> Masuk dengan Facebook
                    </a>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small text-custom" href="javascript:void(0)">Lupa Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small text-custom" href="register.php">Buat Akun!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../asset/jquery/jquery.min.js"></script>
  <script src="../asset/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../asset/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../asset/js/sb-admin-2.min.js"></script>

  <!-- sweetalert -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!--  -->

  <script>
    $('.password-view').click(function(e){

      if($('.password-input').attr('type')=='text'){
        $('.password-input').attr('type','password');
        e.target.classList.toggle("fa-eye");
        e.target.classList.toggle("fa-eye-slash");
      }else{
      e.target.classList.toggle("fa-eye-slash");
      e.target.classList.toggle("fa-eye");
        $('.password-input').attr('type','text');
      }
    })
  </script>

  
  <?php if(isset($result)) :?>
    <script>
          <?php if($result===false) :?>
            swal('Gagal!', 'Email atau password salah, silahkan cek kembali', 'error')
            .then((value) => {
                window.location.href = 'login.php';
            });
          <?php endif; ?>
    </script>
  <?php endif; ?>

</body>

</html>
