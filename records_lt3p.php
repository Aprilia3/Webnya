<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diskarpus Depok</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="style_php.css">
    <style>
        #backButton {
            position: fixed;
            bottom: 60px; 
            right: 30px;  
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            text-decoration: none; 
        }
        #backButton:hover {
            background-color: #0056b3;
        }
        .table-container {
            margin-bottom: 50px; 
        }
        .text-center {
            text-align: center; /* Menambahkan teks tengah untuk semua kolom */
        }
    </style>
    <script>
        function toggleForm() {
            const form = document.getElementById('dataForm');
            const table = document.getElementById('dataTable');
            const addButton = document.getElementById('addButton');
            const backButton = document.getElementById('backButton');

            if (form.style.display === 'none') {
                form.style.display = 'block';
                table.style.display = 'none';
                addButton.style.display = 'none'; 
                backButton.style.display = 'none'; // Sembunyikan tombol kembali
            } else {
                form.style.display = 'none';
                table.style.display = 'table';
                addButton.style.display = 'block'; 
                backButton.style.display = 'block'; // Tampilkan kembali tombol
            }
        }

        function fillForm(data) {
            const form = document.getElementById('dataForm');
            form.style.display = 'block';
            document.getElementById('id_barang').value = data.id_barang;
            document.getElementsByName('nama_barang')[0].value = data.nama_barang;
            document.getElementsByName('merk')[0].value = data.merk;
            document.getElementsByName('no_seri')[0].value = data.no_seri;
            document.getElementsByName('ukuran')[0].value = data.ukuran;
            document.getElementsByName('bahan')[0].value = data.bahan;
            document.getElementsByName('pembelian')[0].value = data.pembelian;
            document.getElementsByName('kode_barang')[0].value = data.kode_barang;
            document.getElementsByName('jumlah_barang')[0].value = data.jumlah_barang;
            document.getElementsByName('keadaan_barang')[0].value = data.keadaan_barang;
            document.getElementsByName('keterangan_barang')[0].value = data.keterangan_barang;

            // Sembunyikan bagian tabel, tombol tambah, dan tombol kembali
            document.getElementById('dataTable').style.display = 'none';
            document.getElementById('addButton').style.display = 'none';
            document.getElementById('backButton').style.display = 'none';
            form.style.display = 'block'; // Tampilkan form
        }
    </script>
</head>
<body>
<nav class="navbar">
    <img src="img/depok.png" />
    <a href="#" class="navbar-logo">DINAS KEARSIPAN DAN PERPUSTAKAAN <span><br />WALIKOTA DEPOK</span></a>
</nav>

<div class="container">
    <h4 class="mt-4"><center>Daftar Barang</center></h4>

    <?php
    include "koneksi.php";

    // Proses penyimpanan dan update data
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_barang = htmlspecialchars($_POST["id_barang"] ?? '');
        $nama_barang = htmlspecialchars($_POST["nama_barang"]);
        $merk = htmlspecialchars($_POST["merk"]);
        $no_seri = htmlspecialchars($_POST["no_seri"]);
        $ukuran = htmlspecialchars($_POST["ukuran"]);
        $bahan = htmlspecialchars($_POST["bahan"]);
        $pembelian = htmlspecialchars($_POST["pembelian"]);
        $kode_barang = htmlspecialchars($_POST["kode_barang"]);
        $jumlah_barang = htmlspecialchars($_POST["jumlah_barang"]);
        $keadaan_barang = htmlspecialchars($_POST["keadaan_barang"]);
        $keterangan_barang = htmlspecialchars($_POST["keterangan_barang"]);

        if ($id_barang) {
            $sql = "UPDATE records_lt3p SET 
                nama_barang='$nama_barang', 
                merk='$merk', 
                no_seri='$no_seri', 
                ukuran='$ukuran', 
                bahan='$bahan', 
                pembelian='$pembelian', 
                kode_barang='$kode_barang', 
                jumlah_barang='$jumlah_barang', 
                keadaan_barang='$keadaan_barang', 
                keterangan_barang='$keterangan_barang' 
                WHERE id_barang='$id_barang'";
        } else {
            $sql = "INSERT INTO records_lt3p (nama_barang, merk, no_seri, ukuran, bahan, pembelian, kode_barang, jumlah_barang, keadaan_barang, keterangan_barang) 
                    VALUES ('$nama_barang', '$merk', '$no_seri', '$ukuran', '$bahan', '$pembelian', '$kode_barang', '$jumlah_barang', '$keadaan_barang', '$keterangan_barang')";
        }

        if (mysqli_query($kon, $sql)) {
            header("Location: records_lt3p.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'> Data gagal disimpan.</div>";
        }
    }

    // Hapus data jika ada id_barang
    if (isset($_GET['id_barang'])) {
        $id_barang = htmlspecialchars($_GET["id_barang"]);
        $sql = "DELETE FROM records_lt3p WHERE id_barang='$id_barang'";
        if (mysqli_query($kon, $sql)) {
            header("Location: records_lt3p.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'> Data gagal dihapus.</div>";
        }
    }
    ?>

    <div class="table-container">
        <table id="dataTable" class="table table-bordered my-3">
            <thead class="table-primary">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama Barang</th>
                    <th class="text-center">Model/Merk</th>
                    <th class="text-center">No. Seri</th>
                    <th class="text-center">Ukuran</th>
                    <th class="text-center">Bahan</th>
                    <th class="text-center">Pembelian/Pembuatan</th>
                    <th class="text-center">Kode Barang</th>
                    <th class="text-center">Jumlah Barang</th>
                    <th class="text-center">Keadaan Barang</th>
                    <th class="text-center">Keterangan Barang</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM records_lt3p ORDER BY id_barang ASC";
                $hasil = mysqli_query($kon, $sql);
                $no = 0;
                while ($data = mysqli_fetch_array($hasil)) {
                    $no++;
                    echo "<tr>
                        <td class='text-center'>{$no}</td>
                        <td class='text-center'>{$data['nama_barang']}</td>
                        <td class='text-center'>{$data['merk']}</td>
                        <td class='text-center'>{$data['no_seri']}</td>
                        <td class='text-center'>{$data['ukuran']}</td>
                        <td class='text-center'>{$data['bahan']}</td>
                        <td class='text-center'>{$data['pembelian']}</td>
                        <td class='text-center'>{$data['kode_barang']}</td>
                        <td class='text-center'>{$data['jumlah_barang']}</td>
                        <td class='text-center'>{$data['keadaan_barang']}</td>
                        <td class='text-center'>{$data['keterangan_barang']}</td>
                        <td class='text-center'>
                            <button onclick='fillForm(" . json_encode($data) . ")' class='btn btn-warning'>Update</button>
                            <a href='?id_barang={$data['id_barang']}' class='btn btn-danger'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <button id="addButton" class="btn btn-primary" onclick="toggleForm()">Tambah Data</button>

    <div id="dataForm" style="display:none; margin-top: 20px;">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="id_barang" id="id_barang" />
            <div class="form-group">
                <label>Nama Barang:</label>
                <input type="text" name="nama_barang" class="form-control" required />
            </div>
            <div class="form-group">
                <label>Model/Merk:</label>
                <input type="text" name="merk" class="form-control" required />
            </div>
            <div class="form-group">
                <label>No. Seri:</label>
                <input type="text" name="no_seri" class="form-control" required />
            </div>
            <div class="form-group">
                <label>Ukuran:</label>
                <input type="text" name="ukuran" class="form-control" required />
            </div>
            <div class="form-group">
                <label>Bahan:</label>
                <textarea name="bahan" class="form-control" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label>Pembelian/Pembuatan:</label>
                <textarea name="pembelian" class="form-control" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label>Kode Barang:</label>
                <input type="text" name="kode_barang" class="form-control" required />
            </div>
            <div class="form-group">
                <label>Jumlah Barang:</label>
                <input type="number" name="jumlah_barang" class="form-control" required />
            </div>
            <div class="form-group">
                <label>Keadaan Barang:</label>
                <textarea name="keadaan_barang" class="form-control" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label>Keterangan Barang:</label>
                <textarea name="keterangan_barang" class="form-control" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Simpan Data</button>
            <button type="button" class="btn btn-secondary" onclick="toggleForm()">Batal</button>
        </form>
    </div>

    <a id="backButton" href="lantai3a.html">Kembali</a>
</div>

</body>
</html>
