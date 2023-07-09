<?php  
  include "koneksi.php";
  session_start();
  if ( !isset($_SESSION["level"]) ) {
      header("Location: login.php");
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
  $tanggal=date('Y-m-d');
  $nomor_pinjam=rand(100,999);
  $sql_pinjam="SELECT * FROM tb_pinjam INNER JOIN tb_hadir ON tb_pinjam.id_hadir = tb_hadir.id_hadir INNER JOIN tb_buku ON tb_pinjam.id_buku = tb_buku.id_buku GROUP BY tb_pinjam.nomor_pinjam";
  $query_pinjam=mysqli_query($koneksi, $sql_pinjam);
  $sql_hadir="SELECT * FROM tb_hadir WHERE keperluan = 'pinjam'";
  $query_hadir=mysqli_query($koneksi,$sql_hadir);
  $sql_buku="SELECT * FROM tb_buku";
  $query_buku=mysqli_query($koneksi,$sql_buku);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Daftar Peminjaman | Perpustakaan SMP Negeri 2 Wlingi</title>
  <link rel="shortcut icon" href="sekolah.jpeg">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link href="fontawesome/css/all.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/> -->

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
      <li class="nav-item ">
        <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Beranda</a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="daftar_hadir.php"><i class="fas fa-book-open"></i> Daftar Hadir</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="daftar_buku.php"><i class="fas fa-book"></i> Daftar Buku</a>
      </li>
      <li class="nav-item active">
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

<!-- ============Header============= -->
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
      <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#tambahPinjam">
      <i class="fas fa-plus"></i> Tambah Data Peminjaman Buku
      </button>
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
            <th scope="col">Nomor Pinjaman </th>
            <th scope="col">Nama</th>
            <th scope="col">Tanggal Pinjam</th>
            <th scope="col">Keterangan</th>
            <th scope="col">Aksi</th>
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
               <a href="data_detail.php?nomor_pinjam=<?= $pinjam['nomor_pinjam']; ?>&&nama=<?php echo $pinjam["nama"]?>&&tanggal_pinjam=<?= tgl_indo($pinjam['tanggal_pinjam']); ?>" class="btn btn-outline-warning" >Lihat</a>
            <?php $level = $_SESSION['level'] == 'admin';
            if ($level) {
            ?>
                <a href="hapus.php?id_status=<?php echo $pinjam['id_status']; ?>"><button type="button" class="btn btn-outline-danger" onclick="return confirm('Hapus id= <?= $pinjam['id_status']; ?>?')">Hapus</button></a>
            <?php } ?>
                <a href="cetak.php?nomor_pinjam=<?php echo $pinjam['nomor_pinjam']; ?>&&nama=<?php echo $pinjam['nama']; ?>"><button type="button" class="btn btn-outline-secondary">Cetak</button></a>
            </td>
            <?php $no++; ?>
          <?php }; ?>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="tambahPinjam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Daftar Peminjaman Buku</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<!-- Form -->
      <form action="tambah.php" method="POST">
        <div class="form-group row">
          <label for="nomor_pinjam" class="col-sm-4 col-form-label">Nomor Pinjam</label>
          <div class="col-sm-8">
            <input type="number" class="form-control" id="nomor_pinjam" value="<?= $nomor_pinjam; ?>" name="nomor_pinjam" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-4 col-form-label">Nama</label>
          <div class="col-sm-8">
           <select name="id_hadir" id="InputState" class="form-control">
             <option value="" selected>==Pilih==</option>
              <?php while ($hadir = mysqli_fetch_array($query_hadir)) {?>
                <option value="<?= $hadir['id_hadir']; ?>"><?= $hadir['nama']; ?></option>
              <?php } ?>
           </select>
          </div>
        </div>    
        <div class="form-group row">
          <label for="inputPassword3" class="col-sm-4 col-form-label">Judul Buku</label>
          <div class="col-sm-8">
            <select name="id_buku" id="InputState" class="form-control">
             <option value="" selected>==Pilih==</option>
              <?php while ($buku = mysqli_fetch_array($query_buku)) {?>
                <option value="<?= $buku['id_buku']; ?>"><?= $buku['judul_buku']; ?></option>
              <?php } ?>
           </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="tanggal_pinjam" class="col-sm-4 col-form-label">Tanggal Pinjam</label>
          <div class="col-sm-8">
            <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" value="<?= $tanggal; ?>" readonly>
          </div>
        </div>    
        <div class="form-group row">
          <label for="tanggal_kembali" class="col-sm-4 col-form-label">Tanggal Kembali</label>
          <div class="col-sm-8">
            <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" autocomplete="off" placeholder="Masukkan tanggal Pengembalian" autocomplete="off">
          </div>
        </div>          
        <div class="form-group row">
          <label for="status" class="col-sm-4 col-form-label">Keterangan</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="status" value="Pinjam" placeholder="Masukkaan Keterangan" name="status" readonly autocomplete="off" required>
          </div>
        </div>  
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-outline-primary" name="tambah_pinjam">Tambah</button>        
        </div>        
      </form>
      </div>
      
    </div>
  </div>
</div>
<!-- Ubah Data Daftar Hadir -->
<div class="modal fade" id="ubahPinjam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel2">Ubah Data Peminjaman Buku</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" action="ubah.php">
              <input type="hidden" class="form-control" id="id_buku" name="id_buku" autocomplete="off" required="">
              <div class="form-group">
                <label for="judul_buku">Judul Buku</label>
                <input type="text" class="form-control" id="judul_buku" name="judul_buku" autocomplete="off" required="">
              </div>
              <div class="form-group">
                <label for="jenis_buku">Jenis Buku</label>
                <select class="form-control" id="jenis_buku" name="jenis_buku" autocomplete="off" required="">
                  <option value="" selected>==Pilih Jenis Buku==</option>
                  <option value="Pendidikan">Pendidikan</option>
                  <option value="Hiburan">Hiburan</option>
                  <option value="Sejarah">Sejarah</option>
                  <option value="Teknologi">Teknologi</option>
                  <option value="Dongeng">Dongeng</option>
                  <option value="Agama">Agama</option>
                  <option value="Olahraga">Olahraga</option>
                </select>
              </div>
              <div class="form-group">
                <label for="stok">No.Induk</label>
                <input type="number" class="form-control" id="stok" name="stok" autocomplete="off" required="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" name="ubah_buku">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- <script type="text/javascript" src="DataTables/datatables.min.js"></script>
    <script type="text/javascript">
      $(document).ready( function () {
        $('#myTable').DataTable();
      } );
    </script> --> 
</body>
</html>