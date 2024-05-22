<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .no-data {
            text-align: center;
        }
        .success-message {
            color: green;
            font-weight: bold;
        }
        .error-message {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Upload Excel File</h1>
    <form action="import.php" method="post" enctype="multipart/form-data">
        <label for="file">Choose Excel file:</label>
        <input type="file" name="file" id="file" accept=".xls,.xlsx">
        <button type="submit">Upload</button>
    </form>

    <h1>Data from Database</h1>
    <?php
    session_start();
    if (isset($_SESSION['success_message'])) {
        echo "<p class='success-message'>" . $_SESSION['success_message'] . "</p>";
        unset($_SESSION['success_message']);
    }
    if (isset($_SESSION['error_message'])) {
        echo "<p class='error-message'>" . $_SESSION['error_message'] . "</p>";
        unset($_SESSION['error_message']);
    }
    ?>
    <?php
    require 'koneksi.php';

    $sql = "SELECT * FROM pokir";
    $result = $conn->query($sql);

    echo "<table>";
    echo "<tr><th>ID</th><th>ID Usulan</th><th>Tanggal Usul</th><th>Pengusul</th><th>Usulan</th><th>Masalah</th><th>Alamat Lokasi</th><th>Usulan Ke</th><th>OPD Tujuan Awal</th><th>OPD Tujuan Akhir</th><th>Status</th><th>Catatan</th><th>Rekomendasi Sekwan</th><th>Rekomendasi Mitra</th><th>Rekomendasi SKPD</th><th>Rekomendasi TAPD</th><th>Volume</th><th>Satuan</th><th>Anggaran</th><th>Jenis Belanja</th><th>Sub Kegiatan</th></tr>";

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['id_usulan'] . "</td>";
            echo "<td>" . $row['tanggal_usul'] . "</td>";
            echo "<td>" . $row['pengusul'] . "</td>";
            echo "<td>" . $row['usulan'] . "</td>";
            echo "<td>" . $row['masalah'] . "</td>";
            echo "<td>" . $row['alamat_lokasi'] . "</td>";
            echo "<td>" . $row['usulan_ke'] . "</td>";
            echo "<td>" . $row['opd_tujuan_awal'] . "</td>";
            echo "<td>" . $row['opd_tujuan_akhir'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td>" . $row['catatan'] . "</td>";
            echo "<td>" . $row['rekomendasi_sekwan'] . "</td>";
            echo "<td>" . $row['rekomendasi_mitra'] . "</td>";
            echo "<td>" . $row['rekomendasi_skpd'] . "</td>";
            echo "<td>" . $row['rekomendasi_tapd'] . "</td>";
            echo "<td>" . $row['volume'] . "</td>";
            echo "<td>" . $row['satuan'] . "</td>";
            echo "<td>" . $row['anggaran'] . "</td>";
            echo "<td>" . $row['jenis_belanja'] . "</td>";
            echo "<td>" . $row['sub_kegiatan'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<tr><td colspan='21' class='no-data'>Tidak ada data.</td></tr>";
    }

    $conn->close();
    ?>
</body>
</html>
