<?php  
include "koneksi.php";
session_start();
	if (isset($_POST["tambah_hadir"])) {
	
			$nama = $_POST["nama"];
			$kelas = $_POST["kelas"];
			$no_induk = $_POST["no_induk"];
			$tanggal_hadir = $_POST["tanggal_hadir"];
			$keperluan = $_POST["keperluan"];
			

			$sql_tambah_hadir = "INSERT INTO `tb_hadir` (`id_hadir`, `nama`, `kelas`, `no_induk`, 'tanggal_hadir', `keperluan`) VALUES (NULL, '$nama', '$kelas', '$no_induk', '$tanggal_hadir', '$keperluan')";

		$query_hadir=mysqli_query($koneksi, $sql_tambah_hadir);

		if (mysqli_affected_rows($koneksi) > 0) {

			echo "<script>
						alert('Data Berhasil Ditambahkan!');
						document.location.href = 'daftar_hadir.php';
				</script>";
					  
		} else {

			echo "<script>
				alert('Data Gagal Ditambahkan!');
				document.location.href = 'daftar_hadir.php';
				</script>";
		}
	}
	if (isset($_POST["tambah_buku"])) {
	
			$judul_buku = $_POST["judul_buku"];
			$jenis_buku = $_POST["jenis_buku"];
			$stok = $_POST["stok"];

			$sql_tambah_buku = "INSERT INTO `tb_buku` (`id_buku`, `judul_buku`, `jenis_buku`, `stok`) VALUES (NULL, '$judul_buku', '$jenis_buku', '$stok')";

		$query_buku=mysqli_query($koneksi, $sql_tambah_buku);

		if (mysqli_affected_rows($koneksi) > 0) {

			echo "<script>
						alert('Data Berhasil Ditambahkan!');
						document.location.href = 'daftar_buku.php';
				</script>";
					  
		} else {

			echo "<script>
				alert('Data Gagal Ditambahkan!');
				document.location.href = 'daftar_buku.php';
				</script>";
		}
	}
	if (isset($_POST["tambah_pinjam"])) {
		$id_hadir=$_POST["id_hadir"];
		$id_buku=$_POST["id_buku"];
		$nomor_pinjam=$_POST["nomor_pinjam"];
		$tanggal_pinjam=$_POST["tanggal_pinjam"];
		$tanggal_kembali=$_POST["tanggal_kembali"];
		$status=$_POST["status"];

		$sql_tambah_pinjam="INSERT INTO `tb_pinjam` (`id_status`, `id_hadir`, `id_buku`, `nomor_pinjam`, `tanggal_pinjam`, `tanggal_kembali`, `status`) VALUES ('', '$id_hadir', '$id_buku', '$nomor_pinjam', '$tanggal_pinjam', '$tanggal_kembali', '$status');";
		$query_tambah_pinjam=mysqli_query($koneksi, $sql_tambah_pinjam);

		if (mysqli_affected_rows($koneksi) > 0) {
			echo "<script>
						alert('Data Berhasil Ditambahkan!');
						document.location.href = 'peminjaman.php';
				</script>";
					  
		} else {

			echo "<script>
				alert('Data Gagal Ditambahkan!');
				document.location.href = 'peminjaman.php';
				</script>";
		}
	}	
?>