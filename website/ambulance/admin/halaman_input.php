<?php include ("inc_header.php") ?>
<?php
$nama = "";
$no_telp = "";
$keluhan = "";
$email = "";
$invoice = ""; // Variable for storing the invoice path
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
    $email = $r1['email'];
    $invoice = $r1['invoice']; // Retrieve the invoice path

    if($keluhan == ''){
        $error = "Data tidak ditemukan";
    }

}

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $keluhan = $_POST['keluhan'];
    $no_telp = $_POST['no_telp'];
    $email = $_POST['email'];

    if ($nama == '' or $keluhan == '') {
        $error = "Silahkan masukan semua data yakni adalah data keluhan dan nama";
    }

    // Handle image upload
    if (isset($_FILES['invoice']) && $_FILES['invoice']['error'] == 0) {
        $allowed = array("jpg", "jpeg", "png", "gif", "pdf");
        $ext = pathinfo($_FILES['invoice']['name'], PATHINFO_EXTENSION);

        if (!in_array($ext, $allowed)) {
            $error = "Tipe file tidak didukung";
        } else {
            $upload_dir = "../uploads/invoices/";

            $invoice = $upload_dir . uniqid() . "." . $ext;
            move_uploaded_file($_FILES['invoice']['tmp_name'], $invoice);
        }
    }

    if (empty($error)) {
        if($id != ""){
            $sql1 = "update complaints set nama = '$nama', no_telp = '$no_telp', keluhan = '$keluhan', email = '$email', invoice = '$invoice', tgl_isi = now() where id = '$id'";
        } else {
            $sql1 = "insert into complaints (nama, no_telp, keluhan, email, invoice) values ('$nama', '$no_telp', '$keluhan', '$email', '$invoice')";
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
<h1>Halaman Admin Pelayanan Input Data</h1>
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
        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="email" value="<?php echo $email ?>" name="email">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="keluhan" class="col-sm-2 col-form-label">Keluhan</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="keluhan" value="<?php echo $keluhan ?>" name="keluhan">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="invoice" class="col-sm-2 col-form-label">Upload Invoice</label>
        <div class="col-sm-10">
            <input type="file" class="form-control" id="invoice" name="invoice">
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
