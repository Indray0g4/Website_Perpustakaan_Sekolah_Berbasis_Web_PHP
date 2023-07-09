<?php  
	require "koneksi.php";
	session_start();
	if (isset($_GET["id_hadir"])) {
		$id_hadir = $_GET["id_hadir"];

		mysqli_query($koneksi, "DELETE FROM tb_hadir WHERE id_hadir = '$id_hadir'");

		if (mysqli_affected_rows($koneksi) > 0) {

		echo "<script>
				alert('Data Berhasil Dihapus!');
				document.location.href = 'daftar_hadir.php';
			  </script>";
		} else {

			echo "<script>
					alert('Data Gagal Dihapus!');
					document.location.href = 'daftar_hadir.php';
				  </script>";
		}
	}
	if (isset($_GET["id_buku"])) {
		$id_buku = $_GET["id_buku"];

		mysqli_query($koneksi, "DELETE FROM tb_buku WHERE id_buku = '$id_buku'");

		if (mysqli_affected_rows($koneksi) > 0) {

		echo "<script>
				alert('Data Berhasil Dihapus!');
				document.location.href = 'daftar_buku.php';
			  </script>";
		} else {

			echo "<script>
					alert('Data Gagal Dihapus!');
					document.location.href = 'daftar_buku.php';
				  </script>";
		}
	}
	if (isset($_GET["id_status"])) {
		$id_status = $_GET["id_status"];

		mysqli_query($koneksi, "DELETE FROM tb_pinjam WHERE id_status = '$id_status'");

		if (mysqli_affected_rows($koneksi) > 0) {

		echo "<script>
				alert('Data Berhasil Dihapus!');
				document.location.href = 'peminjaman.php';
			  </script>";
		} else {

			echo "<script>
					alert('Data Gagal Dihapus!');
					document.location.href = 'peminjaman.php';
				  </script>";
		}
	}
?>