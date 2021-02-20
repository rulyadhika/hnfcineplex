<?php 
define("root",true);
session_start();
if(!isset($_SESSION["login"])){
    header("Location:../page/login.php");
    exit;
}

if($_SESSION['role']==='konsumen'){
    header("Location:../index.php");
    exit;
}
    require '../utility/function.php';

    if(isset($_GET['data']) && isset($_GET['id'])){
        $data = $_GET['data'];
        $id= $_GET['id'];

        echo delete($data,$id);
    }
    
?>

