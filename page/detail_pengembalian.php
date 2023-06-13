<?php
$id_peminjaman = $_GET['id_peminjaman'];
if (empty($id_peminjaman)) {
?>
    <script type="text/javascript">
        window.location.href = "?p=pengembalian";
    </script>
<?php
}
$hari = date('d-m-y');
$d_peminjaman = "SELECT *, detail_pinjam.jumlah as jml FROM detail_pinjam LEFT JOIN peminjaman ON peminjaman.id_peminjaman = detail_pinjam.id_peminjaman LEFT JOIN inventaris on inventaris.id_inventaris = detail_pinjam.id_inventaris LEFT JOIN pegawai ON pegawai.id_pegawai = peminjaman.id_pegawai WHERE peminjaman.id_peminjaman = '$id_peminjaman'";
$d_query = mysqli_query($koneksi, $d_peminjaman);
$data = mysqli_fetch_array($d_query)
?>

<div class="col-lg-6">
    <div class="panel panel-primary">
        <div class="panel-heading">Konfirmasi Pengembalian Inventaris</div>
        <div class="panel-body">
        <form action="" method="post">
                <div class="form-group">
                    <label for="">Kode Peminjaman</label>
                    <input type="text" class="form-control" name="kode_peminjam" value="<?= $data['id_peminjaman'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="">Tanggal Peminjaman</label>
                    <input type="text" class="form-control" name="tgl_pinjam" value="<?= $hari ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="">Nama Peminjaman</label>
                    <input type="text" class="form-control" name="nama_pegawai" value="<?= $data['nama_pegawai'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="">Nama Barang</label>
                    <input type="text" class="form-control" name="nama" value="<?= $data['nama'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="">Jumlah</label>
                    <input type="number" class="form-control" name="jml" value="<?= $data['jml'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="">Tanggal Pengembalian</label>
                    <input type="date" class="form-control" name="tgl_kembali">
                </div>
                <div class="form-group">
                    <button class="btn btn-md btn-primary" type="submit" name="simpan">Simpan</button>
                    <a href="?p=pengembalian" class="btn btn-md btn-default">Kembali</a>
                </div>
            </form>
        </div>
        <?php
            if (isset($_POST['simpan'])) {
                $tgl_kembali = $_POST['tgl_kembali'];

                $sql_pengembalian = "UPDATE peminjaman SET tanggal_kembali = '$tgl_kembali', status_peminjaman = '2' WHERE id_peminjaman = '$id_peminjaman'";
                $q_pengembalian = mysqli_query($koneksi, $sql_pengembalian);

                if ($q_pengembalian) {
            ?>
                    <script type="text/javascript">
                        window.location.href = "?p=pengembalian";
                    </script>
                <?php
                } else {
                ?>
                    <div class="text-center alert alert-danger" role="alert">
                        Barang Gagal Untuk Diupdate
                    </div>
            <?php
                }
            }
        ?>
    </div>
</div>