<?php  
  include "koneksi.php";
  error_reporting(0);
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
  $tanggal_pinjam=tgl_indo($_GET['tanggal_pinjam']);
  $nomor_pinjam=$_GET['nomor_pinjam'];
  $nama=$_GET['nama'];
  $sql_hadir="SELECT * FROM tb_hadir WHERE keperluan = 'pinjam'";
  $query_hadir=mysqli_query($koneksi,$sql_hadir);
  $sql_buku="SELECT * FROM tb_buku";
  $query_buku=mysqli_query($koneksi,$sql_buku);

  $sql_detail_pinjam="SELECT
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
                  tb_pinjam.id_hadir = tb_hadir.id_hadir
                WHERE nomor_pinjam='$nomor_pinjam' AND nama='$nama'";
  $query_detail_pinjam=mysqli_query($koneksi, $sql_detail_pinjam);
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
      <li class="nav-item active">
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
          <li class="breadcrumb-item"><a href="peminjaman.php">Data Peminjama Buku</a></li>
          <li class="breadcrumb-item active" aria-current="page">Data Detail Peminjaman Buku</li>
        </ol>
      </nav>
      <!-- <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#tambahPinjam">
      <i class="fas fa-plus"></i> Tambah Data Peminjaman Buku
      </button> -->
    </div>
  </div>
  <!-- =======Formulir Data======== -->
  <div class="card mt-4">

  </div>
</div>
<div class="card-body">
      <div class="container">
         
          
          
      </div>
      <div class="row ">
            <div class="col-12 col-sm-6 col-md-8"><b>No.Pinjam : <?= $nomor_pinjam;?></b></div>
                <div class="col-6 col-md-4"><b>Tanggal :  <?= $tanggal_pinjam?></b></div>
                <div class="col-12 col-sm-6 col-md-8"><b>Jumlah Pesanan : proses</b></div>
                <div class="col-6 col-md-4"><b>Nama Peminjam : <?= $nama;?></b></div>
            </div>
      <table class="table table-hover mt-4">
        <thead>
          <tr>
            <th scope="col">No.</th>
            <th scope="col">Nomor Pinjaman </th>
            <th scope="col">Nama</th>
            <th scope="col">Kelas</th>
            <th scope="col">Judul Buku</th>
            <th scope="col">Tanggal Pinjam</th>
            <th scope="col">Tanggal Kembali</th>
            <th scope="col">Keterangan</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody style="padding-left:30px ; padding-right:30px;">
        <?php $no=1; ?>
        <?php while ($pinjam = mysqli_fetch_array($query_detail_pinjam)) {?>  
          <tr>
            <th scope="row"><?= $no; ?></th>
            <td><?= $pinjam["nomor_pinjam"];  ?> </td>
            <td><?= $pinjam["nama"];  ?> </td>
            <td><?= $pinjam["kelas"] ?></td>
            <td><?= $pinjam["judul_buku"];  ?> </td>
            <td><?= tgl_indo($pinjam["tanggal_pinjam"]); ?></td>
            <td><?= tgl_indo($pinjam["tanggal_kembali"]);  ?></td>
            <td><?= $pinjam["status"];  ?> </td>
            <?php $level = $_SESSION['level'] == 'admin';
            if ($level) {
            ?>
            <td>
              <?php if ($pinjam["status"] =='Pinjam') {?>
               <a href="edit.php?id_status=<?= $pinjam['id_status'];?>&&nomor_pinjam=<?= $nomor_pinjam;?>&&nama=<?= $nama;?>&&tanggal_pinjam=<?= $tanggal_pinjam; ?>" class="btn btn-outline-warning">Kembali</i></a>
               <a href="edit2.php?id_status=<?= $pinjam['id_status'];?>&&nomor_pinjam=<?= $nomor_pinjam;?>&&nama=<?= $nama;?>&&tanggal_pinjam=<?= $tanggal_pinjam; ?>" class="btn btn-outline-info">Tagihan</i></a>
             <?php } ?> 
               <!-- <a class="btn btn-outline-danger" href="data_detail.php?nomor_pinjam=<?php echo $pinjam['nomor_pinjam'];?>&nama=<?php echo $pinjam['nama'];?>&aksi=hapus&id_status=<?php echo $pinjam['id_status'] ?>">Hapus</a> -->
            </td>
          <!-- <?php } ?> -->
            <?php $no++; ?>
          <?php }; ?>
          </tr>
        </tbody>
      </table>
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
            <select id="status" class="form-control" name="status">
              <option value="" selected>==Pilih==</option>
              <option value="Pinjam">Pinjam</option>
              <option value="Kembali">Kembali</option>
              <option value="Tagih">Tagih</option>
            </select>
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