<?php  
include "koneksi.php";
	// If form submitted, insert values into the database.
	if (isset($_REQUEST['username'])){
	        // removes backslashes
		$username = stripslashes($_REQUEST['username']);
	        //escapes special characters in a string
		$username = mysqli_real_escape_string($koneksi,$username); 
		$password = stripslashes($_REQUEST['password']);
		$password = mysqli_real_escape_string($koneksi,$password);
		$level = stripslashes($_REQUEST['level']);
		$level = mysqli_real_escape_string($koneksi,$level);
	        $query = "INSERT into `tb_pengguna` (id_pengguna, username, password, level) 
			VALUES (NULL, '$username', '$password', '$level')";
	        $result = mysqli_query($koneksi,$query);
	        if($result){
	            echo "<script>
				alert('Sudah daftar! Silahkan masukkan kembali ke login');
				document.location.href = 'login.php';
				</script>";
	        }
	    }else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register | Perpustakaan SMPN 2 Wlingi</title>
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
		<form action="" method="post">
			<div class="box-login">
				<i class="fas fa-user"></i>
			<input type="text" name="username" placeholder="Masukkan Nama Pengguna" autocomplete="off" onkeypress="return validation()">
			</div>
			<div class="box-login">
				<i class="fas fa-user"></i>
		            <select id="level" class="form-control" name="level">
		              <option value="" selected>Masukkan Level</option>
		              <option value="admin">Admin</option>
		              <option value="siswa">Siswa</option>
					</select>		    
			</div>
			<div class="box-login">
				<i class="fas fa-key"></i>
				<input type="password" name="password" placeholder="Masukkan Kata Sandi" id="myInput">
				<span class="eye" onclick="Myfunction()">
					<i id="hide1" class="fa fa-eye"></i>
					<i id="hide2" class="fa fa-eye-slash"></i>
				</span>
			</div>
			<button type="submit" name="register" class="btn-login">
				Daftar
			</button>
			<div class="botton">
				<a href="login.php" style="text-decoration: none;color: white;">Kembali</a>
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
    	function validation(){
          var validasiHuruf = /^[a-zA-Z ]+$/;
          var nama = document.getElementById("nama");
          if (nama.value.match(!validasiHuruf)) {
          	alert("Wajib huruf!");
            nama.value="";
            nama.focus();
            return false;
          }
        }
    </script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script> -->
<?php } ?>
</body>
</html>