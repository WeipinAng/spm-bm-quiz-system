<?php
require 'connect.php';
require 'keselamatan.php';

$idtopik=$_GET['idtopik'];

//Laksanakan DELETE
$deletetopik = mysqli_query($conn,"DELETE FROM topik WHERE idtopik='$idtopik'");
$deletesoalan = mysqli_query($conn,"DELETE FROM soalan WHERE idtopik='$idtopik'");

$queryidsoal = mysqli_query($conn, "SELECT * FROM soalan WHERE idtopik='$idtopik'");
while ($datasoal = mysqli_fetch_array($queryidsoal)) {
    $idsoal = $datasoal['idsoal'];
    echo"<script>alert('$idsoal')</script>";
    $queryidpilihan = mysqli_query($conn, "SELECT * FROM pilihan WHERE idsoal='$idsoal'");
    while ($datapilihan = mysqli_fetch_array($queryidpilihan)) {
        $idpilihan = $datapilihan['idpilihan'];
        $deletepilihan = mysqli_query($conn, "DELETE FROM pilihan WHERE idpilihan='$idpilihan'");
    }
}

$deleteperekodan = mysqli_query($conn,"DELETE FROM perekodan WHERE idtopik='$idtopik'");

//pastikan topik sudah berjaya dihapuskan
echo"<script>alert('Topik berjaya dihapuskan.');window.location='javascript:history.go(-1)'</script>";
?>