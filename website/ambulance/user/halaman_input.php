<?php include ("inc_header.php") ?>
<?php
$nama = "";
$no_telp = "";
$keluhan = "";
$jenis_kerusakan = "";
$jenis_perbaikan = "";
$kategori_perbaikan = "";
$estimasi_waktu = "";
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
    $nama = $r1['nama'];
    $no_telp = $r1['no_telp'];
    $keluhan = $r1['keluhan'];
    $jenis_kerusakan = $r1['jenis_kerusakan'];
    $jenis_perbaikan = $r1['jenis_perbaikan'];
    $kategori_perbaikan = $r1['kategori_perbaikan'];
    $estimasi_waktu = $r1['estimasi_waktu'];
    $invoice = $r1['invoice']; // Retrieve the invoice path

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
    $estimasi_waktu = $_POST['estimasi_waktu'];

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
                        estimasi_waktu = '$estimasi_waktu',
                        invoice = '$invoice', 
                        tgl_isi = NOW()
                     WHERE id = '$id'";
        } else {
            $sql1 = "INSERT INTO complaints (nama, no_telp, keluhan, jenis_kerusakan, jenis_perbaikan, kategori_perbaikan, estimasi_waktu, invoice) 
                     VALUES ('$nama', '$no_telp', '$keluhan', '$jenis_kerusakan', '$jenis_perbaikan', '$kategori_perbaikan', '$estimasi_waktu', '$invoice')";
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

<h1>Halaman Pembayaran</h1>
<div class="mb-3-row">
    <a href="halaman.php">
        << kembali ke dashboard</a>
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
            <input type="text" class="form-control" id="nama" value="<?php echo $nama ?>" name="nama" readonly>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="no_telp" class="col-sm-2 col-form-label">Nomor Telfon</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="no_telp" value="<?php echo $no_telp ?>" name="no_telp" readonly>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="keluhan" class="col-sm-2 col-form-label">Keluhan</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="keluhan" value="<?php echo $keluhan ?>" name="keluhan" readonly>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="jenis_kerusakan" class="col-sm-2 col-form-label">Jenis Kerusakan</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="jenis_kerusakan" value="<?php echo $jenis_kerusakan ?>" name="jenis_kerusakan" readonly>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="jenis_perbaikan" class="col-sm-2 col-form-label">Jenis Perbaikan</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="jenis_perbaikan" value="<?php echo $jenis_perbaikan ?>" name="jenis_perbaikan" readonly>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="kategori_perbaikan" class="col-sm-2 col-form-label">Kategori Perbaikan</label>
        <div class="col-sm-10">
            <select class="form-control" id="kategori_perbaikan" name="kategori_perbaikan_disabled" disabled>
                <option value="minor" <?php if ($kategori_perbaikan == 'minor') echo 'selected'; ?>>Minor</option>
                <option value="sedang" <?php if ($kategori_perbaikan == 'sedang') echo 'selected'; ?>>Sedang</option>
                <option value="major" <?php if ($kategori_perbaikan == 'major') echo 'selected'; ?>>Major</option>
            </select>
            <input type="hidden" name="kategori_perbaikan" value="<?php echo $kategori_perbaikan; ?>">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="estimasi_waktu" class="col-sm-2 col-form-label">Estimasi Waktu</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="estimasi_waktu" name="estimasi_waktu" value="<?php echo $estimasi_waktu; ?>" readonly>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="invoice" class="col-sm-2 col-form-label">Invoice</label>
        <div class="col-sm-10">
            <?php if ($invoice): ?>
                <img src="<?php echo $invoice ?>" alt="Invoice Image" style="max-width: 70%;">
            <?php else: ?>
                <p>Invoice tidak tersedia.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="mb-3 row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
        <a href="bayar.php?id=<?php echo $r1['id']?>">
        <input type="button" class="btn btn-primary" value="Payment" />
    </a>
        </div>
    </div>
</form>
<?php include ("inc_footer.php") ?>

<script>
function updateEstimasiWaktu() {
    const kategori = document.getElementById('kategori_perbaikan').value;
    let estimasiWaktu = '';
    const startDate = new Date("2024-06-24");

    if (kategori === 'minor') {
        const endDate1 = new Date(startDate);
        endDate1.setDate(startDate.getDate() + 1);
        const endDate2 = new Date(startDate);
        endDate2.setDate(startDate.getDate() + 2);
        estimasiWaktu = `${endDate1.toLocaleDateString('en-CA')} sampai ${endDate2.toLocaleDateString('en-CA')}`;
    } else if (kategori === 'sedang') {
        const endDate1 = new Date(startDate);
        endDate1.setDate(startDate.getDate() + 3);
        const endDate2 = new Date(startDate);
        endDate2.setDate(startDate.getDate() + 7);
        estimasiWaktu = `${endDate1.toLocaleDateString('en-CA')} sampai ${endDate2.toLocaleDateString('en-CA')}`;
    } else if (kategori === 'major') {
        const endDate = new Date(startDate);
        endDate.setDate(startDate.getDate() + 7);
        estimasiWaktu = `> ${endDate.toLocaleDateString('en-CA')}`;
    }

    document.getElementById('estimasi_waktu').value = estimasiWaktu;
}

// Initialize the estimasi waktu on page load based on the current selection
document.addEventListener('DOMContentLoaded', function() {
    updateEstimasiWaktu();
});
</script>