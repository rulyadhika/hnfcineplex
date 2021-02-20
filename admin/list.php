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

    if(!isset($_GET['data'])){
        header('location:dashboard.php');die;
    }

    $data = $_GET['data'];

    if($data=='user'){
        $users = select("SELECT * FROM user");
    }elseif($data=='voucher'){
        $vouchers = select("SELECT * FROM voucher");
    }elseif($data=='penjualan'){
        $checkouts = select("SELECT pembayaran.harga_total,pembayaran.harga_akhir,pembayaran.data_timestamp as waktu_pembayaran,pembayaran.payment_status,
                              penjualan.id_user,penjualan.tanggal_pembelian,penjualan.waktu_pembelian,GROUP_CONCAT(tiket.id) as id_tiket
                              FROM pembayaran JOIN penjualan ON pembayaran.id_penjualan = penjualan.id JOIN tiket 
                              ON penjualan.id_tiket = tiket.id JOIN jadwal ON tiket.id_jadwal = jadwal.id
                              GROUP BY pembayaran.id ORDER BY pembayaran.id");
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

    <title>Admin - List <?= $data; ?> | HNF Cineplex</title>

    <!-- Custom fonts for this template-->
    <link href="../asset/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../asset/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for table -->
    <link href="../asset/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                    <h1 class="h3 mb-4 text-gray-800 text-capitalize">List <?= $data; ?></h1>

                    <!-- Accordion List Jadwal Aktif-->
                    <div class="col-xl-12 col-lg-12">
                        <div class="card shadow mb-4">
                            <!-- Card Header -->
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary text-capitalize">List <?= $data; ?></h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">

                                <!-- data user -->
                                <div class="table-responsive">
                                    <?php if($data=='user') :?>
                                        <table class="table table-bordered" id="dataTableUser" width="100%" cellspacing="0"
                                        data-order='[[ 0, "asc" ]]'>
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Tgl Lahir</th>
                                                <th>Jenis Kelamin</th>
                                                <th>No Hp</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $number=count($users) ?>
                                            <?php foreach($users as $user) :?>
                                            <tr>
                                                <td class="text-center font-weight-bold"><?= $number; ?></td>
                                                <td><?= $user['nama'] ?></td>
                                                <td> <?=  $user['tanggal_lahir']; ?>
                                                <td> <?=  $user['jenis_kelamin']; ?>
                                                </td>
                                                <td><?= $user['no_hp']; ?></td>
                                                <td><?= $user['email'] ?></td>
                                                <td><?= $user['role'] ?></td>
                                                <td class="text-center">
                                                    <a class="btn btn-info text-light m-1" style="max-width: 50%;" 
                                                        href="edit.php?data=user&id=<?= $user['id']; ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a class="btn btn-danger text-light m-1 del-btn" data-id="<?= $user['id']; ?>" style="max-width: 50%;">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php $number-- ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                    <!-- data voucher -->
                                    <?php elseif($data=='voucher') :?>
                                        <table class="table table-bordered" id="dataTableVoucher" width="100%" cellspacing="0"
                                        data-order='[[ 0, "asc" ]]'>
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode</th>
                                                <th>Persentase</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $number=count($vouchers) ?>
                                            <?php foreach($vouchers as $voucher) :?>
                                            <tr>
                                                <td class="text-center font-weight-bold"><?= $number; ?></td>
                                                <td><?= $voucher['kode'] ?></td>
                                                <td> <?=  $voucher['persentase']; ?> %
                                                <td> <?=  $voucher['data_status']; ?></td>
                                                <td class="text-center">
                                                    <a class="btn btn-info text-light m-1" style="max-width: 50%;" 
                                                        href="edit.php?data=voucher&id=<?= $voucher['id']; ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a class="btn btn-danger text-light m-1 del-btn" data-id="<?= $voucher['id']; ?>" style="max-width: 50%;">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php $number-- ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                    <!-- data penjualan -->
                                    <?php elseif($data=='penjualan') :?>
                                        <table class="table table-bordered" id="dataTablePenjualan" width="100%" cellspacing="0"
                                        data-order='[[ 0, "asc" ]]'>
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Id User</th>
                                                <th>Id Tiket</th>
                                                <th>Waktu Pembelian</th>
                                                <th>Harga Total</th>
                                                <th>Harga Akhir</th>
                                                <th>Waktu Pembayaran</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $number=count($checkouts) ?>
                                            <?php foreach($checkouts as $checkout) :?>
                                            <tr>
                                                <td class="text-center font-weight-bold"><?= $number; ?></td>
                                                <td><?= $checkout['id_user'] ?></td>
                                                <td><?= $checkout['id_tiket'] ?></td>
                                                <td>
                                                    <i class="fas fa-calendar text-gray-300 mr-2"></i><?=  strftime("%d %b %Y",strtotime($checkout['tanggal_pembelian'])) ?> <br/>
                                                    <i class="fa fa-clock text-gray-300 mr-2"></i><?= date("H:i:s",strtotime($checkout['waktu_pembelian'])) ?> WIB
                                                </td>
                                                <td>Rp. <?= $checkout['harga_total'] ?></td>
                                                <td>Rp. <?= $checkout['harga_akhir'] ?></td>
                                                <td>
                                                    <?php if($checkout['waktu_pembayaran']==0) :?>
                                                        -
                                                    <?php else :?>
                                                        <i class="fas fa-calendar text-gray-300 mr-2"></i><?=  strftime("%d %b %Y",$checkout['waktu_pembayaran']) ?> <br/>
                                                        <i class="fa fa-clock text-gray-300 mr-2"></i><?= date("H:i:s",$checkout['waktu_pembayaran']) ?> WIB
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-<?= $checkout['payment_status']=='BERHASIL'?'success':'danger' ?>"><?= $checkout['payment_status'] ?></td>
                                            </tr>
                                            <?php $number-- ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <?php include "../components/footer.php" ?> 

                    </div>
                </div>
                <!-- /.container-fluid -->
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

    <!-- Page level plugins -->
    <script src="../asset/datatables/jquery.dataTables.min.js"></script>
    <script src="../asset/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#dataTableUser').DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": [2,4,5,7]
                }]
            });

            $('#dataTableVoucher').DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": [4]
                }]
            });

            $('#dataTablePenjualan').DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": [2,4,5]
                }]
            });
        });
    </script>

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
                          swal('Berhasil!', ' Data <?= $data; ?> berhasil dihapus. Otomatis reload dalam 5 detik', 'success');

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
            return fetch("delete.php?data=<?= $data; ?>&id="+id)
            .then(result=>result.text())
            .then(result=>result)
        }
    </script>

</body>

</html>