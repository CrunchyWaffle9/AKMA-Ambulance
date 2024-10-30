<?php include ("inc_header.php") ?>
<?php
$nama = "";
$no_telp = "";
$keluhan = "";
$jenis_kerusakan = "";
$jenis_perbaikan = "";
$kategori_perbaikan = "";
$pemberitahuan_perbaikan = "";
$error = "";
$sukses = "";

if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    $id = "";
}

if($id != ""){
    $sql1 = "select * from complaints where id = '$id'";
    $q1   = mysqli_query($koneksi, $sql1);
    $r1   = mysqli_fetch_array($q1);
    $nama= $r1['nama'];
    $no_telp = $r1['no_telp'];
    $keluhan = $r1['keluhan'];
    $jenis_kerusakan = $r1['jenis_kerusakan'];
    $jenis_perbaikan = $r1['jenis_perbaikan'];
    $kategori_perbaikan = $r1['kategori_perbaikan'];
    $pemberitahuan_perbaikan = $r1['pemberitahuan_perbaikan'];

    if($nama == ''){
        $error = "Data tidak ditemukan";
    }

}

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $no_telp = $_POST['no_telp'];
    $keluhan = $_POST['keluhan'];
    $kategori_perbaikan = $_POST['kategori_perbaikan'];
    $jenis_kerusakan = $_POST['jenis_kerusakan'];
    $jenis_perbaikan = $_POST['jenis_perbaikan'];
    $pemberitahuan_perbaikan = $_POST['pemberitahuan_perbaikan'];

    if ($nama == '' or $keluhan == '') {
        $error = "Silahkan masukan semua data";
    }

    if (empty($error)) {
        if ($id != "") {
            $sql1 = "UPDATE complaints SET 
                        nama = '$nama',
                        no_telp = '$no_telp',
                        keluhan = '$keluhan',
                        jenis_kerusakan = '$jenis_kerusakan',
                        jenis_perbaikan = '$jenis_perbaikan',
                        kategori_perbaikan = '$kategori_perbaikan',
                        pemberitahuan_perbaikan = '$pemberitahuan_perbaikan',
                        tgl_isi = NOW()
                     WHERE id = '$id'";
        } else {
            $sql1 = "INSERT INTO complaints (nama, no_telp, keluhan, jenis_kerusakan, jenis_perbaikan, kategori_perbaikan, pemberitahuan_perbaikan) 
                     VALUES ('$nama', '$no_telp', '$keluhan', '$jenis_kerusakan', 'jenis_perbaikan', '$kategori_perbaikan', 'pemberitahuan_perbaikan')";
        }
        $q1 = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses = "Sukses memasukan data";
        } else {
            $error = "Gagal memasukan data";
        }
    }
}

?>
<h1>Halaman Montir Input Data</h1>
<div class="mb-3-row">
    <a href="halaman.php">
        << kembali ke dashboard Montir</a>
</div>

<?php
if ($error) {
?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error ?>
    </div>
<?php
}
?>

<?php
if ($sukses) {
?>
    <div class="alert alert-primary" role="alert">
        <?php echo $sukses ?>
    </div>
<?php
}
?>

<form action="" method="post">
    <div class="mb-3 row">
        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="nama" value="<?php echo $nama ?>" name="nama">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="no_telp" class="col-sm-2 col-form-label">Nomor Telfon</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="no_telp" value="<?php echo $no_telp ?>" name="no_telp">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="keluhan" class="col-sm-2 col-form-label">Keluhan</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="keluhan" value="<?php echo $keluhan ?>" name="keluhan">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="jenis_kerusakan" class="col-sm-2 col-form-label">Jenis Kerusakan</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="jenis_kerusakan" value="<?php echo $jenis_kerusakan ?>" name="jenis_kerusakan">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="jenis_perbaikan" class="col-sm-2 col-form-label">Jenis Perbaikan</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="jenis_perbaikan" value="<?php echo $jenis_perbaikan ?>" name="jenis_perbaikan">
        </div>
    </div>

    <div class="mb-3 row">
    <label for="pemberitahuan_perbaikan" class="col-sm-2 col-form-label">Pemberitahuan Perbaikan</label>
    <div class="col-sm-10">
        <input type="text" class="form-control mb-2" id="pemberitahuan_perbaikan" value="<?php echo $pemberitahuan_perbaikan ?>" name="pemberitahuan_perbaikan">
    </div>
</div>

    <div class="mb-3 row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
        </div>
    </div>
</form>
<?php include ("inc_footer.php") ?>