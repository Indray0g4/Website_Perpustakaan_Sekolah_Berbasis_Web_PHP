<?php  
  include 'koneksi.php';
  session_start();
    if ( !isset($_SESSION["level"]) ) {
      header("Location: login.php?pesan=belum_login");
      exit;
    }

// TANGGAL (BULAN)
function tgl_indo($tanggal){
  $bulan = array (
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $pecahkan = explode('-', $tanggal);
  
  // variabel pecahkan 0 = tahun
  // variabel pecahkan 1 = bulan
  // variabel pecahkan 2 = tanggal
 
  return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

// TANGGAL (Hari)
function hari_ini(){
  $hari = date ("D");
 
  switch($hari){
    case 'Sun':
      $hari_ini = "Minggu";
    break;
 
    case 'Mon':     
      $hari_ini = "Senin";
    break;
 
    case 'Tue':
      $hari_ini = "Selasa";
    break;
 
    case 'Wed':
      $hari_ini = "Rabu";
    break;
 
    case 'Thu':
      $hari_ini = "Kamis";
    break;
 
    case 'Fri':
      $hari_ini = "Jumat";
    break;
 
    case 'Sat':
      $hari_ini = "Sabtu";
    break;
    
    default:
      $hari_ini = "Tidak di ketahui";   
    break;
  }
 
  return $hari_ini;
 
}

  $sql_hadir="SELECT * FROM tb_hadir";
  $query_hadir=mysqli_query($koneksi,$sql_hadir);
  $sql_buku="SELECT * FROM tb_buku";
  $query_buku=mysqli_query($koneksi,$sql_buku);
  $sql_pinjam="SELECT * FROM tb_pinjam INNER JOIN tb_hadir ON tb_pinjam.id_hadir = tb_hadir.id_hadir INNER JOIN tb_buku ON tb_pinjam.id_buku = tb_buku.id_buku";
  $query_pinjam=mysqli_query($koneksi, $sql_pinjam);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Beranda | Perpustakaan SMP Negeri 2 Wlingi</title>
  <link rel="shortcut icon" href="sekolah.jpeg">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link href="fontawesome/css/all.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="index.php"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon">

    </span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Beranda</a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="daftar_hadir.php"><i class="fas fa-book-open"></i> Daftar Hadir</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="daftar_buku.php"><i class="fas fa-book"></i> Daftar Buku</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="peminjaman.php"><i class="fas fa-upload"></i> Peminjaman</a>
      </li>
<!--       <li class="nav-item">
        <a class="nav-link" href="tagihan.php"><i class="fas fa-file-invoice"></i> Tagihan</a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link" href="laporan.php"><i class="fas fa-download"></i> Laporan</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <button class="btn btn-outline-dark text-white my-2 my-sm-0" href="#" type="submit"><?= $_SESSION['level']; ?></button>
      <h6 class="text-white"> | </h6>
      <button class="btn btn-outline-dark text-white my-2 my-sm-0" type="submit"><a href="logout.php" style="text-decoration: none; color: white;">Logout</a></button>
    </form>
  </div>
</nav>

<div class="container mt-5">
  <div class="jumbotron">
    <h3>Selamat Datang, <?= $_SESSION['username']; ?></h3>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= $_SESSION['username']; ?> sebagai <?=$_SESSION['level']; ?></p>
    <br>
    <div class="row">
      <div class="col-sm-8" style="text-align: left;"><?php echo hari_ini(); ?>, <?php echo tgl_indo(date('Y-m-d')); ?></div>
      <div class="col-sm-4" style="text-align: right;" id="jam"></div>
    </div>
  </div>
  <?php $buku=mysqli_num_rows($query_buku);?>
  <?php $siswa=mysqli_num_rows($query_hadir); ?>
  <?php $pinjam=mysqli_num_rows($query_pinjam); ?>

  <div class="row ml-4">
    <div class="col-sm-4">
      <div class="card text-center btn-outline-primary" style="width: 19rem;">
        <div class="card-body">
          <h5 class="card-title"><?= $siswa; ?></h5>
          <p class="card-text">siswa</p>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="card text-center btn-outline-secondary" style="width: 19rem;">
        <div class="card-body">
          <h5 class="card-title"><?= $buku; ?></h5>
          <p class="card-text">Buku</p>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="card text-center btn-outline-success" style="width: 19rem;">
        <div class="card-body">
          <h5 class="card-title"><?= $pinjam ?></h5>
          <p class="card-text">Pinjaman Buku</p>
        </div>
      </div>
    </div>
  </div>
</div>
<nav class="navbar fixed-bottom text-white navbar-dark bg-dark">

    <small class="float-left">Teknik Informatika A</small>
    <small class="float-right">&copy 2022</small>
</nav>


  <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javaScript">
      window.onload = function() { jam(); }

     function jam() {
      var e = document.getElementById('jam'),
      d = new Date(), h, m, s;
      h = d.getHours();
      m = set(d.getMinutes());
      s = set(d.getSeconds());

      e.innerHTML = h +':'+ m +':'+ s;

      setTimeout('jam()', 1000);
     }

     function set(e) {
      e = e < 10 ? '0'+ e : e;
      return e;
     }
    </script>
</body>
</html>