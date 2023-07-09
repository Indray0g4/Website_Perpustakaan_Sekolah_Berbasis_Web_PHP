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
  $query="SELECT * FROM tb_hadir";
  $absen=mysqli_query($koneksi, $query);

  if (isset($_POST["tambah_hadir"])) {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $no_induk = $_POST['no_induk'];
    $tanggal_hadir = $_POST['tanggal_hadir'];
    $keperluan = $_POST['keperluan'];

    $query="INSERT INTO `tb_hadir` (`id_hadir`, `nama`, `kelas`, `no_induk`, `tanggal_hadir`, `keperluan`) VALUES (NULL, '$nama', '$kelas', '$no_induk', '$tanggal_hadir', '$keperluan');";
    mysqli_query($koneksi, $query);

    if (mysqli_affected_rows($koneksi) > 0) {
      echo "<script>
            alert('Data Berhasil Ditambahkan!');
            document.location.href = 'daftar_hadir.php';
            </script>";
    }else{
      echo "<script>
            alert('Data Gagal Ditambahkan!');
            document.location.href = 'daftar_hadir.php';
            </script>";
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Daftar Hadir | Perpustakaan SMP Negeri 2 Wlingi</title>
  <link rel="shortcut icon" href="sekolah.jpeg">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link href="fontawesome/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>

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
      <button class="btn btn-outline-dark text-white my-2 my-sm-0"  type="submit"><a href="logout.php" style="text-decoration: none; color: white;">Logout</a></button>
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
          <li class="breadcrumb-item active" aria-current="page">Data Hadir</li>
        </ol>
      </nav>
      <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#tambahadir">
      <i class="fas fa-plus"></i> Tambah Data Hadir
      </button>
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
            <th scope="col">Kelas</th>
            <th scope="col">No.Induk</th>
            <th scope="col">Tanggal hadir</th>
            <th scope="col">Keperluan</th>
            <?php $level = $_SESSION['level'] == 'admin';
              if ($level) {
              ?>
            <th scope="col">Aksi</th>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
        <?php $no=1; ?>
        <?php foreach ($absen as $abn) { ?>  
          <tr>
            <th scope="row"><?= $no; ?></th>
            <td><?= $abn["nama"];  ?> </td>
            <td><?= $abn["kelas"];  ?> </td>
            <td><?= $abn["no_induk"];  ?> </td>
            <!-- (date('Y-m-d')) -->
            <td><?= tgl_indo($abn["tanggal_hadir"]); ?></td>
            <td><?= $abn["keperluan"];  ?> </td>
            <td>
              <?php $level = $_SESSION['level'] == 'admin';
              if ($level) {
              ?>
               <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#ubahdaftar" data-id_hadir="<?php echo $abn['id_hadir']; ?>" data-nama="<?php echo $abn['nama']; ?>" data-kelas="<?php echo $abn['kelas']; ?>" data-no_induk="<?php echo $abn['no_induk']; ?>" data-tanggal_hadir="<?php echo $abn['tanggal_hadir']; ?>" data-keperluan="<?php echo $abn['keperluan']; ?>">Ubah</button>
              <a href="hapus.php?id_hadir=<?php echo $abn['id_hadir']; ?>"><button type="button" class="btn btn-outline-danger" onclick="return confirm('Hapus?')">Hapus</button></a>
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
<!-- Modal -->
<div class="modal fade" id="tambahadir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Daftar Hadir</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<!-- Form -->
      <form action="#" method="POST">
        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-4 col-form-label">Nama</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="inputEmail3" placeholder="Masukkan Nama Lengkap" name="nama" autocomplete="off"  onkeypress="return event.charCode < 48 || event.charCode  >57">
          </div>
        </div>
        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-4 col-form-label">kelas</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="inputEmail3" placeholder="Masukkan kelas" name="kelas" autocomplete="off">
          </div>
        </div>    
        <div class="form-group row">
          <label for="inputPassword3" class="col-sm-4 col-form-label">No.Induk</label>
          <div class="col-sm-8">
            <input type="number" class="form-control" id="inputPassword3" placeholder="Masukkan No.Induk" name="no_induk" autocomplete="off" onkeypress="return hanyaAngka(event)">
          </div>
        </div>
        <div class="form-group row">
          <label for="tanggal_hadir" class="col-sm-4 col-form-label">Tanggal Hadir</label>
          <div class="col-sm-8">
            <input type="date" class="form-control" id="tanggal_hadir" name="tanggal_hadir" value="<?= $tanggal; ?>"readonly>
          </div>
        </div>             
        <div class="form-group row">
          <label for="keperluan" class="col-sm-4 col-form-label">Keperluan</label>
          <div class="col-sm-8">
            <select id="keperluan" class="form-control" name="keperluan">
              <option value="Membaca" selected>Membaca</option>
              <option value="Pinjam" >Pinjam</option>
              <option value="Kembali">Kembali</option>
              <option value="Tagih">Tagih</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-outline-primary" name="tambah_hadir">Tambah</button>        
        </div>        
      </form>
      </div>
      
    </div>
  </div>
</div>

<!-- Ubah Data Daftar Hadir -->
<div class="modal fade" id="ubahdaftar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel2">Ubah Data Hadir</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" action="ubah.php">
              <input type="hidden" class="form-control" id="id_hadir" name="id_hadir" autocomplete="off" required="">
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" autocomplete="off" required="" onkeypress="return hanyaAngka()">
              </div>
              <div class="form-group">
                <label for="kelas">Kelas</label>
                <input type="text" class="form-control" id="kelas" name="kelas" autocomplete="off" required="">
              </div>
              <div class="form-group">
                <label for="no_induk">No.Induk</label>
                <input type="number" class="form-control" id="no_induk" name="no_induk" autocomplete="off" required="">
              </div>
              <div class="form-group">
                <label for="tanggal_hadir">Tanggal Hadir</label>
                <input type="date" class="form-control" id="tanggal_hadir" name="tanggal_hadir" autocomplete="off" required="">
              </div>
              <div class="form-group">
                <label for="keperluan">Pilih Keperluan</label>
                <select class="form-control" id="keperluan" name="keperluan" autocomplete="off" required="">
                  <option value="">==Pilih Keperluan==</option>
                  <option value="Membaca">Membaca</option>
                  <option value="Pinjam">Pinjam</option>
                  <option value="Kembali">Kembali</option>
                  <option value="Tagih">Tagih</option>
                </select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" name="ubah_daftar">Simpan</button>
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
    <script type="text/javascript" src="DataTables/datatables.min.js"></script>
    <script type="text/javascript">
      $('#ubahdaftar').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id_hadir = button.data('id_hadir');
        var nama = button.data('nama');
        var kelas = button.data('kelas');
        var no_induk = button.data('no_induk');
        var tanggal_hadir = button.data('tanggal_hadir');
        var keperluan = button.data('keperluan');
        var modal = $(this)
        
        modal.find('.modal-body #id_hadir').val(id_hadir);
        modal.find('.modal-body #nama').val(nama);
        modal.find('.modal-body #kelas').val(kelas);
        modal.find('.modal-body #no_induk').val(no_induk);
        modal.find('.modal-body #tanggal_hadir').val(tanggal_hadir);
        modal.find('.modal-body #keperluan').val(keperluan);
      })
      $(document).ready( 
        function () {
        $('#myTable').DataTable();
      } );
      // function validation(){
      //     var validasiHuruf = /^[a-zA-Z ]+$/;
      //     var nama = document.getElementById("nama");
      //     if (nama.value.match(validasiHuruf)) {
      //         alert("Nama Anda adalah " + nama.value);
      //     } else {
      //         alert("Wajib huruf!");
      //         nama.value="";
      //         nama.focus();
      //         return false;
      //     }
      //   }
      function hanyaAngka(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
       if (charCode > 31 && (charCode < 48 || charCode > 57))
 
        return false;
      return true;
    }
    
    </script> 
</body>
</html>