<?php 
//lokasi server,username,pasword,nama database
$koneksi = mysqli_connect("localhost","root","","db_perpustakaan");
 
// Check connection
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}
 
 // function registrasi($data){
 // 	global $koneksi;

 // 	$username = strtolower(stripcslashes($data["username"]));
 // 	$password = mysqli_real_escape_string($koneksi,$data["password"]));
	// $password2 = mysqli_real_escape_string($koneksi,$data["password2"]));

	// //cek username
	// $query_user=mysqli_query($koneksi, "SELECT username FROM tb_pengguna WHERE username='$username'");
	// if (mysqli_fetch_assoc($query_user)) {
	// 	echo "<script>
	// 				alert('username sudah terdaftar');
	// 		 	</script>";
	// 		return false;
	// }
	// //cek konfirmasi password
	// if ($password !== $password2) {
	// 	echo "<script>
	// 				alert('konformasi password tidak sesuai');
	// 			  </script>";
	// 	return false;
	// }
	// //enkripsi password
	// $password = password_hash($password, PASSWORD_DEFAULT);

	// //tambah user baru ke database
	// mysqli_query($koneksi, "INSERT INTO tb_pengguna VALUES('', '$username', '$password')");

	// return mysqli_affected_rows($koneksi);
 // }
?>