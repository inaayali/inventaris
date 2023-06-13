<?php
    include "../config/koneksi.php";

    @$tgl_awal = $_GET['tgl_awal'];
    @$tgl_sampai = $_GET['tgl_sampai'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan</title>
    <!-- CSS Bootstrap -->
    <link href="../dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="row">
        <div class="col-lg-6" style="margin: 0 auto; float: none">
            <center>
                <h2>Laporan Peminjaman</h2>
                Periode : <?= date('d-m-Y', strtotime($tgl_awal))?> 
                            <b>S/D</b> 
                        <?= date('d-m-Y', strtotime($tgl_sampai)) ?>
            </center>
            <hr>
            <br>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Nama Inventaris</th>
                        <th>Jumlah</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Pengembalian</th>
                    </tr>
                </thead>
                <?php
                    $cari = '';
                    @$tgl_awal = $_GET['tgl_awal'];
                    @$tgl_sampai = $_GET['tgl_sampai'];

                    if (!empty($tgl_awal)) {
                        $cari .= "and tanggal_pinjam >='" . $tgl_awal . "'";
                    }
                    if (!empty($tgl_sampai)) {
                        $cari .= "and tanggal_pinjam <='" . $tgl_sampai . "'";
                    }

                    if (empty($tgl_awal) && empty($tgl_sampai)) {
                        $cari .= "and tanggal_pinjam >='" . $hari_ini . "' and tanggal_pinjam >= '" . $hari_ini . "'";
                    }

                    $sql = "SELECT *, detail_pinjam.jumlah as jml FROM detail_pinjam LEFT JOIN peminjaman ON peminjaman.id_peminjaman = detail_pinjam.id_peminjaman LEFT JOIN inventaris on inventaris.id_inventaris = detail_pinjam.id_inventaris LEFT JOIN pegawai ON pegawai.id_pegawai = peminjaman.id_pegawai WHERE 1=1 $cari";

                    $query = mysqli_query($koneksi, $sql);
                    $test = mysqli_num_rows($query);

                    if ($test > 0) {
                        $no = 1;
                        while ($data = mysqli_fetch_array($query)) {
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data['nama_pegawai'] ?></td>
                                <td><?= $data['nama'] ?></td>
                                <td><?= $data['jml'] ?></td>
                                <td><?= $data['tanggal_pinjam'] ?></td>
                                <td><?= $data['tanggal_kembali'] ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                            <tr>
                                <td colspan="6">Tidak Ada Data</td>
                            </tr>
                        <?php
                    }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
<script type="text/javascript">
    window.print();
</script>