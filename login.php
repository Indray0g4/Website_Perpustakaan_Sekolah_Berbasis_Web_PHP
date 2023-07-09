<?php 
session_start();
if ( isset($_SESSION["login.php"]) ) {
	header("Location: index.php");
	exit;
}
include "koneksi.php";
	@$login=$_POST['login'];
	if ($login == "ditekan" ) {
		//menangkap inputan dari form
		$username=$_POST['username'];
		$password=$_POST['password'];

		 //perintah cek login
		$sql_login="SELECT * FROM tb_pengguna WHERE username = '$username' AND password = '$password'";
		$query_login=mysqli_query($koneksi, $sql_login);
		$data_login=mysqli_num_rows($query_login);
  
		if ($data_login == 1) {
			$_SESSION['username'] = $username;
			header("Location: index.php");
		}else{?>
			<script>
			alert("login gagal. Silahkan periksa nama pengguna dan kata sandi!")
		</script>
		<?php
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login | Perpustakaan SMPN 2 Wlingi</title>
	<link rel="shortcut icon" href="sekolah.jpeg">
	<!-- CSS -->
	<link rel="stylesheet" href="style_login.css">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awrsome-->
	<link href="fontawesome/css/all.min.css" rel="stylesheet">
</head>
<body>
	<div class="login">
		<div class="avatar">
			<i class="fa fa-user"></i>
		</div>
		<h5>Perpustakaan SMPN 2 Wlingi</h6>		
		<!-- Cek Nontifikasi -->
		<?php  
			if (isset($_GET['pesan'])) {
				if($_GET['pesan'] == "gagal") {?> 
					<div class="alert alert-danger" role="alert">
						<center>
							<strong>Login gagal! Username dan Password</strong>
						</center>
					</div>
				<?php }elseif ($_GET['pesan'] == "logout") { ?>
					<div class="alert alert-success" role="alert">
						<center>
							  <strong>Anda telah berhasil logout</strong>
						</center>
					</div>
				<?php }elseif ($_GET['pesan'] == "belum_login") { ?>
					<div class="alert alert-info" role="alert">
						<center>
							<strong>Anda harus mengisi login terlebih dahulu</strong>
						</center>
					</div>
				<?php }
			}
		?>

		<form action="cek_login.php" method="post">
			<div class="box-login">
				<i class="fas fa-user"></i>
			<input type="text" name="username" placeholder="Masukkan Nama Pengguna" autocomplete="off">
			</div>
			<div class="box-login">
				<i class="fas fa-key"></i>
				<input type="password" name="password" placeholder="Masukkan Kata Sandi" id="myInput">
				<span class="eye" onclick="Myfunction()">
					<i id="hide1" class="fa fa-eye"></i>
					<i id="hide2" class="fa fa-eye-slash"></i>
				</span>
			</div>
			<button type="submit" name="login" value="ditekan" class="btn-login">
				Masuk
			</button>
			<div class="botton">
				<a href="register.php" style="text-decoration: none;color: white;">Register</a>
				<!-- <a href="">Lupa Kata Sandi?</a> -->
			</div>
		</form>
	</div>
	
	<!-- Java -->
	<script src="js/bootstrap.bundle.min.js" ></script>
    <script src="js/popper.min.js"></script>
    <script>
    	function Myfunction() {
    		var x = document.getElementById('myInput');
    		var y = document.getElementById('hide1');
    		var z = document.getElementById('hide2');

    		if (x.type === 'password') {
    			x.type = "text";
    			y.style.display = "block";
    			z.style.display = "none";
    		}else{
    			x.type = "password";
    			y.style.display = "block";
    			z.style.display = "none";
    		}
    	}
    </script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script> -->
</body>
</html>