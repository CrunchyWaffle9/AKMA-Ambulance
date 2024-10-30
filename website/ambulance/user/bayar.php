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

if (isset($_POST['simpan'])) {
    if (isset($_FILES['pembayaran']) && $_FILES['pembayaran']['error'] == 0) {
        $allowed = array("jpg", "jpeg", "png", "gif", "pdf");
        $ext = pathinfo($_FILES['pembayaran']['name'], PATHINFO_EXTENSION);

        if (!in_array($ext, $allowed)) {
            $error = "Tipe file tidak didukung";
        } else {
            $upload_dir = "../uploads/pembayaran/";
            $pembayaran = $upload_dir . uniqid() . "." . $ext;
            move_uploaded_file($_FILES['pembayaran']['tmp_name'], $pembayaran);
        }
    } else {
        $error = "Silahkan masukan bukti pembayaran";
    }

    if (empty($error)) {
        if ($id != "") {
            $sql1 = "update complaints set pembayaran = '$pembayaran', tgl_isi = now() where id = '$id'";
        } else {
            $sql1 = "insert into complaints (pembayaran) values ('$pembayaran')";
        }
        $q1 = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses = "Sukses upload bukti pembayaran";
        } else {
            $error = "Gagal memasukan data";
        }
    }
}

?>

<h1>Halaman Pembayaran</h1>
<div class="mb-3-row">
    <a href="halaman.php">&lt;&lt; kembali ke dashboard</a>
</div>

<?php if ($error) { ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error ?>
    </div>
<?php } ?>

<?php if ($sukses) { ?>
    <div class="alert alert-primary" role="alert">
        <?php echo $sukses ?>
    </div>
<?php } ?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3 row">
        <label for="pembayaran" class="col-sm-2 col-form-label">Upload Bukti Pembayaran</label>
        <div class="col-sm-10">
            <input type="file" class="form-control" id="pembayaran" name="pembayaran">
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <input type="submit" name="simpan" value="Pay" class="btn btn-primary" />
        </div>
    </div>
</form>
<?php include ("inc_footer.php") ?>
