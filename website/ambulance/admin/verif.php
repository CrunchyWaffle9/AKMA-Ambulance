<?php include ("inc_header.php") ?>
<?php

$pembayaran = ""; 
$error = "";
$sukses = "";

if(isset($_GET['id'])){
    $id = $_GET['id'];
} else {
    $id = "";
}

if($id != ""){
    $sql1 = "SELECT * FROM complaints WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);

    if($r1){
        $pembayaran = $r1['pembayaran']; 
    } else {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['verif'])) {
    
    if (empty($error)) {
        if ($id != "") {
            $sql1 = "update complaints set pemberitahuan_admin = 'Ambulance dapat diambil' where id = '$id'";
        }
        $q1 = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses = "Verifikasi Bukti Pembayaran Berhasil";
        } else {
            $error = "Verifikasi Bukti Pembayaran Gagal";
        }
    }
}else if (isset($_POST['gagalverif'])) {
    
    if (empty($error)) {
        if ($id != "") {
            $sql1 = "update complaints set pemberitahuan_admin = 'Lakukan pembayaran ulang' where id = '$id'";
        }
        $q1 = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses = "Bukti Pembayaran Tidak Sesuai";
        } else {
            $error = "Gagal memasukan data";
        }
    }
}
?>

<h1>Halaman Verifikasi Pembayaran</h1>
<div class="mb-3-row">
    <a href="halaman.php">
        << kembali ke dashboard admin</a>
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

<form action="" method="post" enctype="multipart/form-data">
<div class="mb-3 row">
        <label for="pembayaran" class="col-sm-2 col-form-label">Bukti Pembayaran</label>
        <div class="col-sm-10">
            <?php if ($pembayaran): ?>
                <img src="<?php echo $pembayaran ?>" alt="Bukti Pembayaran" style="max-width: 30%;">
            <?php else: ?>
                <p>Bukti Pembayaran tidak tersedia.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
        <a href="halaman.php">
            <input type="submit" name="verif" value="Verifikasi Pembayaran" class="btn btn-primary" />
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <input type="submit" name="gagalverif" value="Reject" class="btn btn-primary" />
        </div>
    </div>
</form>
<?php include ("inc_footer.php") ?>
