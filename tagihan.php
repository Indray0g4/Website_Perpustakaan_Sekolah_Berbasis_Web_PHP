<?php  
  include "koneksi.php";
  session_start();
  if (!isset($_SESSION["level"]) ) {
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
  $sql_hadir="SELECT * FROM tb_hadir WHERE keperluan = 'Tagih'";
  $query_hadir=mysqli_query($koneksi,$sql_hadir);
  $sql_buku="SELECT * FROM tb_buku";
  $query_buku=mysqli_query($koneksi,$sql_buku);
  $sql_pinjam="SELECT * FROM tb_pinjam INNER JOIN tb_hadir ON tb_pinjam.id_hadir = tb_hadir.id_hadir INNER JOIN tb_buku ON tb_pinjam.id_buku = tb_buku.id_buku WHERE status = 'Tagih' GROUP BY tb_pinjam.nomor_pinjam";
  $query_pinjam=mysqli_query($koneksi, $sql_pinjam);
  $sql_tagih="SELECT
  tb_hadir.id_hadir, 
  tb_hadir.nama, 
  tb_hadir.kelas, 
  tb_hadir.no_induk, 
  tb_hadir.tanggal_hadir, 
  tb_hadir.keperluan, 
  tb_pinjam.id_status, 
  tb_pinjam.id_hadir, 
  tb_pinjam.id_buku, 
  tb_pinjam.nomor_pinjam, 
  tb_pinjam.tanggal_pinjam, 
  tb_pinjam.tanggal_kembali, 
  tb_pinjam.status, 
  tb_tagih.id_tagih, 
  tb_tagih.id_hadir, 
  tb_tagih.id_status, 
  tb_tagih.hari, 
  tb_tagih.denda
FROM
  tb_hadir
  INNER JOIN
  tb_tagih
  ON 
    tb_hadir.id_hadir = tb_tagih.id_hadir
  INNER JOIN
  tb_pinjam
  ON 
    tb_tagih.id_status = tb_pinjam.id_status
  WHERE status='Tagih'";
    $query_tagih=mysqli_query($koneksi, $sql_tagih);
    $query_tagih=mysqli_query($koneksi, $sql_tagih);

    function rupiah($angka){
    $hasil_rupiah="Rp" . number_format($angka,2,',',',');
    return $hasil_rupiah;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Daftar Tagihan | Perpustakaan SMP Negeri 2 Wlingi</title>
  <link rel="shortcut icon" href="sekolah.jpeg">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link href="fontawesome/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
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
      <li class="nav-item active">
        <a class="nav-link" href="tagihan.php"><i class="fas fa-file-invoice"></i> Tagihan</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="laporan.php"><i class="fas fa-download"></i> Laporan</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <button class="btn btn-outline-dark text-white my-2 my-sm-0" href="#" type="submit">Admin</button>
      <h6 class="text-white"> | </h6>
      <button class="btn btn-outline-dark text-white my-2 my-sm-0" type="submit">Logout</button>
    </form>
  </div>
</nav>

<!-- ============Header============= -->
<div class="container mt-5">
  <!-- ==========Card=============== -->
  <div class="card">
    <div class="card-header text-white bg-primary">
      Data Daftar Hadir
    </div>
    <div class="card-body">
      <h5 class="card-title"></h5>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">Data Tagihan Buku</li>
        </ol>
      </nav>
<!--       <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">
      <i class="fas fa-plus"></i> Tambah Data Tagihan Buku
      </button> -->
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
      <table class="table table-hover mt-4" id="myTable">
        <thead>
          <tr>
            <th scope="col">No.</th>
            <th scope="col">Nama</th>
            <th scope="col">Tanggal Pinjam</th>
            <th scope="col">Tanggal Kembali</th>
            <th scope="col">Terlambat (Hari)</th>
            <th scope="col">Denda</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no=1; ?>
          <?php foreach ($query_pinjam as $tagih) {?>
          <tr>
            <th scope="row"><?= $no; ?></th>
            <td><?= $tagih["nama"];?></td>
            <td><?= tgl_indo($tagih["tanggal_pinjam"]);?></td>
            <td><?= tgl_indo($tagih["tanggal_kembali"]);?></td>
            <td><?= $tagih["lambat"];?></td>
            <td><?= rupiah($tagih["denda"]); ?></td>
            <td>
              <a href=""></a>
              <a href=""></a>
            </td>
            <?php $no++; ?>
          <?php } ?>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Mobil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<!-- Form -->
      <form action="#" method="post">
        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-4 col-form-label">Nama Pemilik Mobil</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="inputEmail3" placeholder="Masukkan Nama Mobil" name="nama_pemilik_mobil" autocomplete="off">
          </div>
        </div>
        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-4 col-form-label">Merk Mobil</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="inputEmail3" placeholder="Masukkan Merk Mobil" name="merk_mobil" autocomplete="off">
          </div>
        </div>        
        <div class="form-group row">
          <label for="jenis_transmisi" class="col-sm-4 col-form-label">Jenis Mobil</label>
          <div class="col-sm-8">
            <select id="jenis_transmisi" class="form-control" name="jenis_transmisi">
          <option value="Manual" selected>Manual</option>
          <option value="Matic">Matic</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="inputPassword3" class="col-sm-4 col-form-label">Jumlah Mobil</label>
          <div class="col-sm-8">
            <input type="number" class="form-control" id="inputPassword3" placeholder="Masukkan Jumlah Mobil" name="jumlah_mobil" autocomplete="off">
          </div>
        </div>
        <div class="form-group row">
          <label for="inputPassword3" class="col-sm-4 col-form-label">Harga Sewa</label>
          <div class="col-sm-8">
            <input type="number" class="form-control" id="inputPassword3" placeholder="Masukkan Harga Sewa" name="harga_sewa" autocomplete="off">
          </div>
        </div>
        <div class="modal-footer">
          <input class="btn btn-outline-primary" type="submit" name="simpan_data" value="Simpan">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>        
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
    <script type="text/javascript">
      $(document).ready( function () {
        $('#myTable').DataTable();
      } );
    </script> 
</body>
</html>