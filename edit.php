<?php  
	include "koneksi.php";
	session_start();
	$id_status=$_GET['id_status'];
	$nomor_pinjam=$_GET['nomor_pinjam'];
	$nama=$_GET['nama'];
	$sql_edit_detail="UPDATE `tb_pinjam` SET `status` = 'Kembali' WHERE `tb_pinjam`.`id_status` = '$id_status'";
	$query_edit=mysqli_query($koneksi,$sql_edit_detail);
	header("Location:data_detail.php?nama=".$nama."&id_status=".$id_status."&nomor_pinjam=".$nomor_pinjam);
	
?>