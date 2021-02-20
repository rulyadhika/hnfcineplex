<?php

if (!defined("root")) {
    header("location:../index.php");
    die;
}

$conn = mysqli_connect("localhost", "root", "", "web_bioskop");

date_default_timezone_set('Asia/Jakarta');
$localtime_assoc = localtime(time(), true);
setlocale(LC_ALL, 'id-ID', 'id_ID');


function insertFilm($data)
{
    global $conn;

    $judul = $data["judul"];
    $durasi = $data["durasi"];
    $aktor = $data["aktor"];
    $genre = $data["genre"];
    $kategori = $data["kategori"];
    $bahasa = $data["bahasa"];
    $subtitle = $data["subtitle"];
    $sutradara = $data["sutradara"];
    $produksi = $data["produksi"];
    $link_trailer = mysqli_escape_string($conn, $data["link_trailer"]);
    $sinopsis = $data["sinopsis"];
    $data_status = $data['data_status'];

    $cover = upload();

    // if(!$cover){
    //     return false;
    // }

    if (gettype($cover) != 'string') {
        return $cover;
    }

    $query = "INSERT INTO film VALUES(
            '',
            '$judul',
            $durasi,
            '$aktor',
            '$genre',
            '$kategori',
            '$bahasa',
            '$subtitle',
            '$sutradara',
            '$produksi',
            '$link_trailer',
            '$sinopsis',
            '$cover',
            '$data_status'
        )";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function insertJadwal($data)
{
    global $conn;

    $namaFilm = $data['film'];
    $id_film = intval(select("SELECT id FROM film WHERE judul = '$namaFilm'")[0]['id']);
    $tanggal = $data['tanggal'];
    $waktu = explode(',', $data['jam']);
    $studio = $data['studio'];
    $harga = intval($data['harga']);
    $status = "Aktif";

    //tambah pengkondisian apakah sudah ada jadwal dengan waktu yang sama dimasukan ke dalam db
    foreach ($waktu as $jam) {
        $data_timestamp = strtotime($tanggal . ' ' . $jam);

        //cek apakah studio pada waktu x sudah sedang dipakai atau tidak
        $cekStudio = select("SELECT COUNT(id) FROM jadwal WHERE data_timestamp = $data_timestamp AND studio = '$studio'")[0]['COUNT(id)'];

        if ($cekStudio == 0) {
            // cek apakah jadwal dengan waktu,dan studio yang sama sudah pernah ditambahkan atau belum
            $cekJadwal = (int) select("SELECT COUNT(id) FROM jadwal WHERE id_film = $id_film AND id IN
                                          (SELECT id FROM jadwal WHERE data_timestamp = $data_timestamp AND studio = '$studio')")[0]['COUNT(id)'];

            if ($cekJadwal == 0) {
                $query = "INSERT INTO jadwal VALUES(
                        '',
                        $id_film,
                        $data_timestamp,
                        '$studio',
                        $harga,
                        '$status'
                    )";

                mysqli_query($conn, $query);
            }
        }
    }


    return mysqli_affected_rows($conn);
}

function insertTiket($data)
{
    global $conn;

    $id_jadwal = intval($data['id_jadwal']);
    $chairs_id = explode(',', $data['id_kursi']);

    $voucher_code = $data['voucher_code'];

    $tiket_key = uniqid();

    foreach ($chairs_id as $id_kursi) {
        $query = "INSERT INTO tiket VALUES(
                '',
                $id_jadwal,
                '$id_kursi',
                '$tiket_key'
            )";

        mysqli_query($conn, $query);
    }

    return insertPenjualan($id_jadwal, $chairs_id, $voucher_code);
}

function insertPenjualan($id_jadwal, $chairs_id, $voucher_code)
{
    global $conn;

    $date_now = date("Y-m-d");
    $time_now = date("H:i:s");

    $id_user = (int) $_SESSION['user_id'];

    $jumlah_kursi = count($chairs_id);

    //id terakhir pada tabel pesanan plus 1 untuk input penjualan saat ini
    $id = (int) select("SELECT id FROM penjualan ORDER BY id DESC LIMIT 1")[0]['id'] + 1;

    foreach ($chairs_id as $id_kursi) {
        $id_tiket = (int) select("SELECT id FROM tiket WHERE id_jadwal = $id_jadwal AND id_kursi = '$id_kursi'")[0]['id'];

        $query = "INSERT INTO penjualan VALUES(
                $id,
                $id_tiket,
                $id_user,
                '$date_now',
                '$time_now'
            )";

        mysqli_query($conn, $query);
    }

    $hitung_diskon = hitungDiskon($id_jadwal, $jumlah_kursi, $voucher_code);

    $harga_total = (int) $hitung_diskon[0]['harga_total'];
    $harga_akhir = (int) $hitung_diskon[0]['final_price'];
    // var_dump($harga_akhir);

    return insertPembayaran($id, $harga_total, $harga_akhir);
}

function insertPembayaran($id_penjualan, $harga_total, $harga_akhir)
{
    global $conn;

    $query = "INSERT INTO pembayaran VALUES(
            '',
            $id_penjualan,
            $harga_total,
            $harga_akhir,
            0,
            'PENDING'
        )";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function updatePembayaran($data)
{
    global $conn;

    $date_now = strtotime(date("Y-m-d H:i:s"));
    $id_pembayaran = (int) $data['payment-id'];

    $query = "UPDATE pembayaran SET data_timestamp = $date_now , payment_status = 'BERHASIL' WHERE id = $id_pembayaran";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hitungDiskon($id_jadwal, $jumlah_kursi, $kode)
{
    global $conn;
    $cek_kode = mysqli_query($conn, "SELECT persentase FROM voucher WHERE kode = '$kode' AND data_status = 'Aktif'");

    $harga_tiket = (int) select("SELECT harga FROM jadwal WHERE id = $id_jadwal")[0]['harga'];
    $harga_total = $jumlah_kursi * $harga_tiket;

    $persentase_diskon = 0;
    $jumlah_diskon = 0;
    $success = false;
    $final_price = $harga_total;

    //cek apakah kode voucher tersedia didalam db
    if (mysqli_num_rows($cek_kode) > 0) {
        $persentase_diskon = (int) select("SELECT persentase FROM voucher WHERE kode = '$kode' AND data_status = 'Aktif'")[0]['persentase'];
        $jumlah_diskon = $harga_total * $persentase_diskon / 100;
        $final_price = $harga_total - $jumlah_diskon;
        $success = true;
    }

    return array([
        "harga_total" => $harga_total,
        "final_price" => $final_price,
        "discount" => $jumlah_diskon,
        "success" => $success,
        "discount_percentage" => $persentase_diskon
    ]);
}

function insertVoucher($data)
{
    global $conn;

    $kode = $data['kode'];
    $persentase = (int) $data['persentase'];

    $query = "INSERT INTO voucher VALUES(
            '',
            '$kode',
            $persentase,
            'Aktif'
        )";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
};

function upload()
{
    $namaFile = $_FILES['cover']['name'];
    $ukuranFile = $_FILES['cover']['size'];
    $error = $_FILES['cover']['error'];
    $tmp = $_FILES['cover']['tmp_name'];

    //cek apakah user sudah mengupload file belum
    if ($error === 4) {
        // echo "<script>
        //     alert('silahkan upload file cover terlebih dahulu');
        // </script>";
        // return false;
        return -2;
    }

    //cek apakah file yang diupload sesuai
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiFileUploaded = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

    if (!in_array($ekstensiFileUploaded, $ekstensiGambarValid)) {
        // echo "<script>
        //     alert('Yang anda upload bukan gambar');
        // </script>";
        // return false;
        return -3;
    }


    //cek apakah ukuran file yang diupload sesuai
    if ($ukuranFile > 1000000) {
        // echo "<script>
        //     alert('ukuran gambar terlalu besar');
        // </script>";
        // return false;
        return -4;
    }

    //generate nama baru 
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiFileUploaded;



    move_uploaded_file($tmp, '../asset/image/' . $namaFileBaru);

    return $namaFileBaru;
}

function select($data)
{
    global $conn;

    $result = mysqli_query($conn, $data);

    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function search($data, $table, $data_status, $awalData = null, $jumlahDataPerHalaman = null, $order = null, $orderMethod = null)
{
    $key = $data['key'];
    $query = "";

    if ($table == 'film') {
        $query = "SELECT * FROM film WHERE data_status = '$data_status' 
            AND id IN(SELECT id FROM film WHERE judul LIKE '%$key%' 
            OR kategori LIKE '%$key%' OR genre LIKE '%$key%' 
            OR aktor LIKE '%$key%' OR durasi LIKE '%$key%')";
    } elseif ($table == 'jadwal') {
        $query = "SELECT jadwal.* , film.judul,film.cover FROM jadwal 
            JOIN film ON jadwal.id_film = film.id WHERE jadwal.data_status = '$data_status' 
            AND jadwal.id IN(SELECT jadwal.id FROM jadwal WHERE film.judul LIKE '%$key%' OR
            jadwal.studio LIKE '%$key%' OR jadwal.harga LIKE '%$key%')";
    }


    if ($order != null) {
        $query .= "ORDER BY $order $orderMethod";
    }

    if ($awalData != null || $jumlahDataPerHalaman != null) {
        $query .= " LIMIT $awalData, $jumlahDataPerHalaman";
    } else {
        $query = $query;
    }

    return select($query);
}

function updateFilm($data)
{
    global $conn;

    $id_film = $data['id_film'];
    $judul = $data["judul"];
    $durasi = $data["durasi"];
    $aktor = $data["aktor"];
    $genre = $data["genre"];
    $kategori = $data["kategori"];
    $bahasa = $data["bahasa"];
    $subtitle = $data["subtitle"];
    $sutradara = $data["sutradara"];
    $produksi = $data["produksi"];
    $link_trailer = mysqli_escape_string($conn, $data["link_trailer"]);
    $sinopsis = $data["sinopsis"];
    $cover_lama = $data["cover_lama"];
    $data_status = $data['data_status'];

    $cover = upload();

    // if(!$cover){
    //     return false;
    // }

    if (gettype($cover) != 'string') {
        if ($cover == (-2)) {
            $cover = $cover_lama;
        } else {
            return $cover;
        }
    }

    $query = "UPDATE film SET judul = '$judul', durasi = $durasi,
            aktor = '$aktor', sinopsis = '$sinopsis', kategori = '$kategori', 
            genre = '$genre', cover = '$cover', data_status = '$data_status',
            bahasa = '$bahasa' , subtitle = '$subtitle' , sutradara = '$sutradara',
            produksi = '$produksi' , link_trailer = '$link_trailer'
            WHERE id = $id_film
        ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function updateJadwal($data)
{
    global $conn;

    $id_jadwal = $data['id_jadwal'];
    $id_film = $data['id_film'];
    $tanggal = $data['tanggal'];
    $jam = $data['jam'];
    $studio = $data['studio'];
    $harga = $data['harga'];
    $data_timestamp = strtotime($tanggal . ' ' . $jam);
    $data_status = $data['data_status'];

    $query = "UPDATE jadwal SET id_film = $id_film, studio = '$studio', harga = $harga, 
            data_timestamp = $data_timestamp, data_status = '$data_status'
            WHERE id = $id_jadwal
        ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function updateVoucher($data)
{
    global $conn;

    $kode = $data['kode'];
    $persentase = (int) $data['persentase'];
    $data_status = $data['data_status'];
    $id_voucher = $data['id_voucher'];

    $query = "UPDATE voucher SET kode = '$kode' , persentase = $persentase , data_status = '$data_status' 
                  WHERE id = $id_voucher";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function updateUser($data)
{
    global $conn;

    $id_user = sanitize_input($data['id_user']);
    $nama = sanitize_input($data['nama']);
    $tanggal_lahir = sanitize_input($data['tanggal_lahir']);
    $jenis_kelamin = sanitize_input($data['jenis_kelamin']);
    $no_hp = sanitize_input($data['no_hp']);
    $role = 'konsumen';

    //memastikan jika register akun via dashboard admin
    // sehingga bisa set role akun
    if (isset($_SESSION['login'])) {
        if ($_SESSION['role'] == 'manajer' || $_SESSION['role'] == 'dev') {
            $role = sanitize_input($data['role']);
        }
    }

    $query = "UPDATE user SET nama = '$nama' , tanggal_lahir = '$tanggal_lahir' , jenis_kelamin = '$jenis_kelamin' ,
                   no_hp = '$no_hp' , role = '$role' WHERE id = $id_user";


    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function delete($table, $id)
{
    global $conn;

    $query = "DELETE FROM $table WHERE id = $id";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function register($data)
{
    global $conn;

    $nama_depan =  sanitize_input($data['nama-depan']);
    $nama_belakang =  sanitize_input($data['nama-belakang']);
    $nama = $nama_depan . ' ' . $nama_belakang;
    $email = sanitize_input($data['email']);
    $password = sanitize_input($data['password']);
    $retype_password = sanitize_input($data['retype-password']);
    $role = 'konsumen';

    //memastikan jika register akun via dashboard admin
    // sehingga bisa set role akun
    if (isset($_SESSION['login'])) {
        if ($_SESSION['role'] == 'manajer' || $_SESSION['role'] == 'dev') {
            $role = sanitize_input($data['role']);
        }
    }

    //cek apakah email sudah pernah terdaftar atau belum
    $result = mysqli_query($conn, "SELECT id FROM user WHERE email = '$email'");

    if (mysqli_num_rows($result) > 0) {
        return 'email-registered';
    }

    if (strlen($password) < 8) {
        return 'password-length-not-enough';
    }

    if ($password != $retype_password) {
        return 'password-not-match';
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO user VALUES(
            '',
            '$nama',
            null,
            null,
            null,
            '$email',
            '$password',
            '$role'
        )";


    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function login($data)
{
    global $conn;

    $email =  sanitize_input($data['email']);
    $password =  sanitize_input($data['password']);

    $result = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION["login"] = true;
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_login"] = $row["nama"];
            $_SESSION["role"] = $row["role"];
            return $row["role"];
        }
    }

    return false;
}

function sanitize_input($data)
{

    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
