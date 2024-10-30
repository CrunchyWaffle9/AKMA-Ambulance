<?php include ("inc_header.php") ?>
<?php
$sukses = "";
$katakunci = (isset($_GET['katakunci'])) ? $_GET['katakunci'] : "";
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete') {
    $No = $_GET['No'];
    $sql1 = "delete from part where No = '$No'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Delete Success";
    }
}
?>
<h1>Daftar Persediaan Part Interior Ambulance</h1>
<p>
    <a href="input.php">
        <input type="button" class="btn btn-primary" value="Input Stock" />
    </a>
</p>
<?php
if ($sukses) {
    ?>
    <div class="alert alert-primary" role="alert">
        <?php echo $sukses?>
    </div>
    <?php
}
?>
<form class="row g-3" method="get">
    <div class="col-auto">
        <input type="text" class="form-control" placeholder="Masukkan kata kunci" name="katakunci"
            value="<?php echo $katakunci ?>" />
    </div>
    <div class="col-auto">
        <input type="submit" name="cari" value="Cari tulisan" class="btn btn-secondary" />
    </div>
</form>
<table class="table table striped">
    <thead>
        <tr>
            <th class="col-1">No</th>
            <th>Deskripsi</th>
            <th>Unit</th>
            <th>Asal Penyedia</th>
            <th>Nama Penyedia</th>
            <th>Jumlah Unit</th>
            <th class="col-1">Act</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sqltambahan = "";
        $per_halaman = 100;
        if ($katakunci != '') {
            $array_katakunci = explode(" ", $katakunci);
            for ($x = 0; $x < count($array_katakunci); $x++) {
                $sqlcari[] = "(No like '%" . $array_katakunci[$x] . "%' or Deskripsi like '%" . $array_katakunci[$x] . "%' or Unit like '%" . $array_katakunci[$x] . "%')";
            }
            $sqltambahan = "where " . implode(" or ", $sqlcari);
        }
        $sql1 = "select * from part $sqltambahan";
        $page = isset($GET['page'])?(int)$_GET['page']:1;
        $mulai =($page > 1) ? ($page *$per_halaman) - $per_halaman : 0;
        $q1  = mysqli_query($koneksi, $sql1);
        $total = mysqli_num_rows($q1);
        $pages = ceil($total / $per_halaman);
        $nomor = $mulai + 1;
        $sql1 = $sql1." order by No asc limit $mulai,$per_halaman";

        $q1 = mysqli_query($koneksi, $sql1);

        while ($r1 = mysqli_fetch_array($q1)) {
            ?>
            <tr>
                <td><?php echo $nomor++ ?></td>
                <td><?php echo $r1['Deskripsi'] ?></td>
                <td><?php echo $r1['Unit'] ?></td>
                <td><?php echo $r1['Asal_Penyedia'] ?></td>
                <td><?php echo $r1['Nama_Penyedia'] ?></td>
                <td><?php echo $r1['Jumlah_Unit'] ?></td>
                <td>
                    <a href="input.php?No=<?php echo $r1['No']?>">
                    <span class="badge bg-warning text-dark">Input</span>
                    </a>
                    <a href="halaman.php?op=delete&No=<?php echo $r1['No'] ?>"
                        onclick="return confirm('Apakah yakin ingin delete?')">
                        <span class="badge bg-danger">Delete</span>
                    </a>
                </td>
            </tr>
            <?php
        }
        ?>

    </tbody>
</table>

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php
                $cari = (isset($_GET['cari']))?$_GET['cari']:"";
                for($i=1; $i <= $pages; $i++){
                    ?>
                    <li class="page-item">
                        <a class="page-link" href="halaman.php?katakunci=<?php echo $katakunci?>&cari=<?php echo $cari?>&page=<?php echo $i?>"><?php echo $i?></a>
                    </li>
                    <?php
                }
        ?>
    </ul>
</nav>
<?php include ("inc_footer.php") ?>