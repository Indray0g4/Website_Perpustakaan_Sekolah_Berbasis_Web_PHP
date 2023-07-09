<?php 

require "koneksi.php";
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
$nomor_pinjam = $_GET["nomor_pinjam"];
$nama = $_GET["nama"];
$cetak2 = mysqli_query($koneksi, "SELECT
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
                WHERE nomor_pinjam='$nomor_pinjam' AND nama='$nama'
");
$cetak = mysqli_query($koneksi, "SELECT * FROM tb_buku INNER JOIN tb_pinjam ON tb_buku.id_buku = tb_pinjam.id_buku INNER JOIN tb_hadir ON tb_pinjam.id_hadir = tb_hadir.id_hadir WHERE nomor_pinjam = '$nomor_pinjam'");
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel = "stylesheet" type = "text/css" media = "print" href = "mystyle.css">

    <style type="text/css">
      @media print {
         .table {
          border-style: solid;
        border-width: 2px;
         }
         thead {
          border-style: solid;
        border-width: 2px;
         }
         tbody {
          border-style: solid;
        border-width: 2px;
         }
         tbody td {
          border-style: solid;
        border-width: 2px;
         }
         tbody tr {
          border-style: solid;
        border-width: 2px;
         }
         thead td {
          border-style: solid;
        border-width: 2px;
         }
         thead tr {
          border-style: solid;
        border-width: 2px;
         }
      }
    </style>

    <title>>Bukti Peminjaman Buku</title>
  </head>
  <body>
    <div class="container">

      <div class="text-center">
        <h5><b>PERPUSTAKAAN SMP NEGERI 2 WLINGI</b></h5>
        <h6><b>JL.Ki Hajar Dewantara No. 727 Babadan, Kabupaten Blitar</b></h6>
        <hr>

      </div>
      
    <div class="row">
      <div class="col-sm">
        Kode Pinjam : <b>P<?php echo $nomor_pinjam; ?></b>
      </div>
      <div class="col-sm">
        <h6>Tanggal : <?php echo tgl_indo(date("Y-m-d")); ?></h6>
      </div>
      <div class="col-sm text-right">
        Peminjam : <b><?php echo $nama; ?></b>
      </div>
    </div>
    <br>
  <table class="table">
    <thead class="thead bg-light">
      <tr>
        <td scope="col">No</td>
        <td scope="col">Nama</td>
        <td scope="col">Kelas</td>
        <td scope="col">Judul Buku</td>
        <td scope="col">Tanggal Pinjam</td>
        <td scope="col">Tanggal Kembali</td>
        <td scope="col">Keterangan</td>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1 ?>
      <?php foreach ($cetak as $ctk) { ?>
      <tr>
        <td><?= $no; ?></td>
        <td><?= $ctk["nama"]; ?></td>
        <td><?= $ctk["kelas"]; ?></td>
        <td><?= $ctk["judul_buku"]; ?></td>
        <td><?= tgl_indo($ctk["tanggal_pinjam"]); ?></td>
        <td><?= tgl_indo($ctk["tanggal_kembali"]); ?></td>
        <td><?= $ctk["status"]; ?></td>
      </tr>
      <?php $no++ ?>
      <?php } ?>
    </tbody>
  </table>
  <h4>
    Cacatan:
    <br>
    Wajib Mengembalikan buku tepat waktu
  </h4>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
      window.print();
    </script>
  </body>
</html>
