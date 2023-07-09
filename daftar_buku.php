<?php  
session_start();
if ( !isset($_SESSION["level"]) ) {
      header("Location: login.php");
      exit;
    }
  include "koneksi.php";
  $query="select * from tb_buku";
  $buku=mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Daftar Buku | Perpustakaan SMP Negeri 2 Wlingi</title>
  <link rel="shortcut icon" href="sekolah.jpeg">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link href="fontawesome/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css">
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
      <li class="nav-item active">
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

<!-- ============Header============= -->
<div class="container mt-5">
  <!-- ==========Card=============== -->
  <div class="card">
    <div class="card-header text-white bg-primary">
      Data Buku
    </div>
    <div class="card-body">
      <h5 class="card-title"></h5>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">Data Buku</li>
        </ol>
      </nav>
      <?php $level = $_SESSION['level'] == 'admin';
            if ($level) {
            ?>
      <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">
      <i class="fas fa-plus"></i> Tambah Buku
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
      <table class="table table-hover mt-4" id="myTable">
        <thead>
          <tr>
            <th scope="col">No.</th>
            <th scope="col">Judul Buku</th>
            <th scope="col">Jenis Buku</th>
            <th scope="col">Stok</th>
            <?php $level = $_SESSION['level'] == 'admin';
                if ($level) {
              ?>
            <th scope="col">Aksi</th>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
          <?php $no=1; ?>
          <?php foreach ($buku as $baca) {?>
          <tr>
            <th scope="row"><?= $no; ?></th>
            <td><?= $baca["judul_buku"] ?></td>
            <td><?= $baca["jenis_buku"] ?></td>
            <td><?= $baca["stok"] ?></td>
            <td>
              <?php $level = $_SESSION['level'] == 'admin';
                if ($level) {
              ?>
              <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#ubahbuku" data-id_buku="<?php echo $baca['id_buku']; ?>" data-judul_buku="<?php echo $baca['judul_buku']; ?>" data-jenis_buku="<?php echo $baca['jenis_buku']; ?>" data-stok="<?php echo $baca['stok']; ?>" >Ubah</button>
            <a href="hapus.php?id_buku=<?php echo $baca['id_buku']; ?>"><button type="button" class="btn btn-outline-danger" onclick="return confirm('Hapus?')">Hapus</button></a>
              <?php } ?>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Buku</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<!-- Form -->
      <form action="tambah.php" method="post">
        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-4 col-form-label">Judul Buku</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="inputEmail3" placeholder="Masukkan Judul Buku" name="judul_buku" autocomplete="off">
          </div>
        </div>       
        <div class="form-group row">
          <label for="jenis_buku" class="col-sm-4 col-form-label">Jenis Buku</label>
          <div class="col-sm-8">
            <select id="jenis_buku" class="form-control" name="jenis_buku">
              <option value="Pendidikan" selected>Pendidikan</option>
              <option value="Olahraga">Olahraga</option>
              <option value="Sejarah">Sejarah</option>
              <option value="Teknologi">Teknologi</option>
              <option value="Dongeng">Dongeng</option>
              <option value="Agama">Agama</option>
              <option value="Olahraga">Olahraga</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="inputPassword3" class="col-sm-4 col-form-label">Stok</label>
          <div class="col-sm-8">
            <input type="number" class="form-control" id="inputPassword3" placeholder="Masukkan Stok" name="stok" autocomplete="off" onkeypress="return hanyaAngka(event)">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>        
          <button type="submit" class="btn btn-outline-primary" name="tambah_buku">Tambah</button>
        </div>        
      </form>
      </div>
    </div>
  </div>
</div>
<!-- Ubah Data Daftar Buku -->
<div class="modal fade" id="ubahbuku" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
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
                <label for="stok">Stok</label>
                <input type="number" class="form-control" id="stok" name="stok" autocomplete="off" required="" onkeypress="return hanyaAngka(event)">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-outline-success" name="ubah_buku">Simpan</button>
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
      $('#ubahbuku').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id_buku = button.data('id_buku');
        var judul_buku = button.data('judul_buku');
        var jenis_buku = button.data('jenis_buku');
        var stok = button.data('stok');
        var modal = $(this)
        
        modal.find('.modal-body #id_buku').val(id_buku)
        modal.find('.modal-body #judul_buku').val(judul_buku)
        modal.find('.modal-body #jenis_buku').val(jenis_buku)
        modal.find('.modal-body #stok').val(stok)
      })
      function hanyaAngka(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
       if (charCode > 31 && (charCode < 48 || charCode > 57))
 
        return false;
      return true;
    }
      $(document).ready( function () {
        $('#myTable').DataTable();
      } );
    </script> 
</body>
</html>