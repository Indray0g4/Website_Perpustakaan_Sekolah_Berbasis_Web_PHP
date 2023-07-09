<?php  
  include "koneksi.php";
  session_start();
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
  $tanggal=date('Y-m-d');
  $sql_hadir="SELECT * FROM tb_hadir WHERE keperluan = 'pinjam'";
  $query_hadir=mysqli_query($koneksi,$sql_hadir);
  $sql_buku="SELECT * FROM tb_buku";
  $query_buku=mysqli_query($koneksi,$sql_buku);

  $sql_pinjam="SELECT
                tb_buku.id_buku, 
                tb_buku.judul_buku, 
                tb_buku.jenis_buku, 
                tb_hadir.id_hadir, 
                tb_hadir.nama, 
                tb_hadir.no_induk, 
                tb_hadir.kelas,
                tb_hadir.tanggal_hadir, 
                tb_hadir.keperluan, 
                tb_pinjam.id_status, 
                tb_pinjam.id_hadir, 
                tb_pinjam.id_buku, 
                tb_pinjam.nomor_pinjam, 
                tb_pinjam.tanggal_pinjam, 
                tb_pinjam.tanggal_kembali, 
                tb_pinjam.`status`
              FROM
                tb_buku
                INNER JOIN
                tb_pinjam
                ON 
                  tb_buku.id_buku = tb_pinjam.id_buku
                INNER JOIN
                tb_hadir
                ON 
                  tb_pinjam.id_hadir = tb_hadir.id_hadir GROUP BY tb_pinjam.nomor_pinjam";
  $query_pinjam=mysqli_query($koneksi, $sql_pinjam);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Laporan | Perpustakaan SMPN 2 Wlingi</title>
	<link rel="shortcut icon" href="sekolah.jpeg">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link href="fontawesome/css/all.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/> -->
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <!-- <a class="navbar-brand" href="index.php">Resto</a> -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon">

    </span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item ">
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
      <li class="nav-item active">
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
  <!-- ==========Card=============== -->
  <div class="card">
    <div class="card-header text-white bg-primary">
      Data Peminjaman Buku
    </div>
    <div class="card-body">
      <h5 class="card-title"></h5>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">Data Peminjaman Buku</li>
        </ol>
      </nav>
      <?php $level = $_SESSION['level'] == 'admin';
            if ($level) {
            ?>
      <a href="cetak2.php">
      	<button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#">
     		 <i class="fas fa-print"></i> Laporan
      	</button>
      </a>
      <?php } ?>
    </div>
  </div>
  <!-- =======Formulir Data======== -->
  <div class="card mt-4">
    <div class="card-body">
      <div class="container">
        <form action="" class="form-inline mb-3  float-right" method="post">
         <div class="form-group mx-sm-3 mb-2">
          <!-- <div class="form-group mb-2">
            <label for="staticEmail2" class="sr-only">Email</label>
            <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="email@example.com">
          </div> -->          
            <!-- <label for="cari" class="sr-only">Cari</label>
            <input type="text" class="form-control" id="cari" placeholder="Cari Nama" autocomplete="off" name="cari"> -->
          </div>
          <!-- <button type="submit" name="cari_data" value="cari" class="btn btn-primary mb-2"><i class="fas fa-search"></i></button> -->
        </form>  
      </div>
      <table class="table table-hover mt-4">
        <thead>
          <tr>
            <th scope="col">No.</th>
            <th scope="col">Nomor Pinjaman</th>
            <th scope="col">Nama</th>
            <th scope="col">Tanggal Pinjam</th>
            <th scope="col">Keterangan</th>
            <!-- <th scope="col">Aksi</th> -->
          </tr>
        </thead>
        <tbody>
        <?php $no=1; ?>
        <?php foreach ($query_pinjam as $pinjam) { ?>  
          <tr>
            <th scope="row"><?= $no; ?></th>
            <td><?= $pinjam["nomor_pinjam"];  ?> </td>
            <td><?= $pinjam["nama"];  ?> </td>
            <td><?= tgl_indo($pinjam["tanggal_pinjam"]); ?></td>
            <td><?= $pinjam["status"];  ?> </td>
            <td>
               <!-- <a href="data_detail.php?nomor_pinjam=<?= $pinjam['nomor_pinjam']; ?>&&nama=<?php echo $pinjam["nama"]?>" class="btn btn-outline-warning" >Lihat</a> -->
            <?php $level = $_SESSION['level'] == 'admin';
            if ($level) {
            ?>
                <a href="hapus.php?id_status=<?php echo $pinjam['id_status']; ?>"><button type="button" class="btn btn-outline-danger" onclick="return confirm('Hapus?')">Hapus</button></a>
              <?php } ?>
            </td>
            <?php $no++; ?>
          <?php }; ?>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>