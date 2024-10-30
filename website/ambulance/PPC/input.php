<?php include ("inc_header.php") ?>
<?php
$No = "";
$Deskripsi = "";
$Unit = "";
$Asal_Penyedia = "";
$Nama_Penyedia = "";
$Jumlah_Unit = "";
$error = "";
$sukses = "";

if(isset($_GET['No'])){
    $No = $_GET['No'];
}else{
    $No = "";
}

if($No != ""){
    $sql1 = "select * from part where No = '$No'";
    $q1   = mysqli_query($koneksi, $sql1);
    $r1   = mysqli_fetch_array($q1);
    $Deskripsi= $r1['Deskripsi'];
    $Unit = $r1['Unit'];
    $Asal_Penyedia = $r1['Asal_Penyedia'];
    $Nama_Penyedia = $r1['Nama_Penyedia'];
    $Jumlah_Unit = $r1['Jumlah_Unit'];

    if($Deskripsi == ''){
        $error = "Data tidak ditemukan";
    }

}

if (isset($_POST['simpan'])) {
    $Deskripsi = $_POST['Deskripsi'];
    $Unit = $_POST['Unit'];
    $Asal_Penyedia = $_POST['Asal_Penyedia'];
    $Jumlah_Unit = $_POST['Jumlah_Unit'];
    $Nama_Penyedia = $_POST['Nama_Penyedia'];

    if ($Deskripsi == '' or $Nama_Penyedia == '') {
        $error = "Silahkan masukan semua data";
    }

    if (empty($error)) {
        if ($No != "") {
            $sql1 = "UPDATE part SET 
                        Deskripsi = '$Deskripsi',
                        Unit = '$Unit',
                        Asal_Penyedia = '$Asal_Penyedia',
                        Nama_Penyedia = '$Nama_Penyedia',
                        Jumlah_Unit = '$Jumlah_Unit',
                        tgl_isi = NOW()
                     WHERE No = '$No'";
        } else {
            $sql1 = "INSERT INTO part (Deskripsi, Unit, Asal_Penyedia, Nama_Penyedia, Jumlah_Unit) 
                     VALUES ('$Deskripsi', '$Unit', '$Asal_Penyedia', '$Nama_Penyedia', '$Jumlah_Unit')";
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
<h1>Halaman PPC Input Jumlah Part Tersedia</h1>
<div class="mb-3-row">
    <a href="halaman.php">
        << kembali ke dashboard PPC</a>
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
        <label for="Deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="Deskripsi" value="<?php echo $Deskripsi ?>" name="Deskripsi">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="Unit" class="col-sm-2 col-form-label">Unit</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="Unit" value="<?php echo $Unit ?>" name="Unit">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="Asal_Penyedia" class="col-sm-2 col-form-label">Asal Penyedia</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="Asal_Penyedia" value="<?php echo $Asal_Penyedia ?>" name="Asal_Penyedia">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="Nama_Penyedia" class="col-sm-2 col-form-label">Nama_Penyedia</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="Nama_Penyedia" value="<?php echo $Nama_Penyedia ?>" name="Nama_Penyedia">
        </div>
    </div>
    <div class="mb-3 row">
    <label for="Jumlah_Unit" class="col-sm-2 col-form-label">Jumlah Unit</label>
    <div class="col-sm-10">
            <input type="text" class="form-control" id="Jumlah_Unit" value="<?php echo $Jumlah_Unit ?>" name="Jumlah_Unit">
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