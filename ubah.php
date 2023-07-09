<?php  
	require 'koneksi.php';
	session_start();
	if (isset($_POST["ubah_daftar"])) {
		$id_hadir = $_POST["id_hadir"];
		$nama = $_POST["nama"];
        $kelas = $_POST["kelas"];
        $no_induk = $_POST["no_induk"];
        $tanggal_hadir = $_POST["tanggal_hadir"];
        $keperluan = $_POST["keperluan"];

        $sql_data_hadir = "UPDATE tb_hadir SET id_hadir= '$id_hadir', nama='$nama', kelas='$kelas', no_induk='$no_induk', tanggal_hadir='$tanggal_hadir',keperluan='$keperluan' WHERE id_hadir='$id_hadir' ";
        mysqli_query($koneksi, $sql_data_hadir);
        if (mysqli_affected_rows($koneksi) > 0) {

		echo "<script>
				alert('Data Berhasil Diubah!');
				document.location.href = 'daftar_hadir.php';
			  </script>";
		} else {

		echo "<script>
				document.location.href = 'daftar_hadir.php';
			  </script>";
		}
	}
	if (isset($_POST["ubah_buku"])) {
		$id_buku = $_POST["id_buku"];
		$judul_buku = $_POST["judul_buku"];
		$jenis_buku = $_POST["jenis_buku"];
		$stok = $_POST["stok"];

        $sql_ubah_buku="UPDATE `tb_buku` SET `judul_buku` = '$judul_buku', `jenis_buku` = '$jenis_buku', `stok` = '$stok' WHERE `tb_buku`.`id_buku` = '$id_buku'";
        mysqli_query($koneksi, $sql_ubah_buku);

        if (mysqli_affected_rows($koneksi) > 0) {

		echo "<script>
				alert('Data Berhasil Diubah!');
				document.location.href = 'daftar_buku.php';
			  </script>";
		} else {

		echo "<script>
				document.location.href = 'daftar_buku.php';
			  </script>";
		}
	}
?>