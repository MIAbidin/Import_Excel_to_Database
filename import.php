<?php
session_start();
require 'vendor/autoload.php';
require 'koneksi.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$requiredColumns = ['id_usulan', 'tanggal_usul', 'pengusul', 'usulan', 'masalah', 'alamat_lokasi', 'usulan_ke', 'opd_tujuan_awal', 'opd_tujuan_akhir', 'status', 'catatan', 'rekomendasi_sekwan', 'rekomendasi_mitra', 'rekomendasi_skpd', 'rekomendasi_tapd', 'volume', 'satuan', 'anggaran', 'jenis_belanja', 'sub_kegiatan'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file']) && $_FILES['file']['size'] > 0) {
    $file = $_FILES['file']['tmp_name'];

    $spreadsheet = IOFactory::load($file);
    $worksheet = $spreadsheet->getActiveSheet();

    $excelColumns = [];
    foreach ($worksheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);

        foreach ($cellIterator as $cell) {
            $excelColumns[] = $cell->getValue();
        }

        break;
    }

    $headerRow = $worksheet->getRowIterator()->current();
    $headerCells = $headerRow->getCellIterator();
    $headerCells->setIterateOnlyExistingCells(false);

    $columnMap = [];
    foreach ($headerCells as $cell) {
        $columnMap[$cell->getColumn()] = $cell->getValue();
    }

    $missingColumns = array_diff($requiredColumns, $columnMap);
    if (!empty($missingColumns)) {
        $errorMessage = "Kolom '" . implode("', '", $missingColumns) . "' diperlukan dan tidak ada dalam file Excel.";
        $_SESSION['error_message'] = $errorMessage;
        header("Location: index.php");
        exit();
    }

    $rowCount = 0;
    $errorMessages = [];
    foreach ($worksheet->getRowIterator() as $row) {
        if ($row->getRowIndex() == 1) {
            continue;
        }

        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);

        $data = [];
        $nullColumns = [];
        foreach ($columnMap as $column => $columnName) {
            $cell = $worksheet->getCell($column . $row->getRowIndex());
            $value = $cell->getValue();
            if ($value === null) {
                $nullColumns[] = $columnName;
            }
            $data[] = $value;
        }

        if (!empty($nullColumns)) {
            $errorMessages[] = "Kolom '" . implode(", ", $nullColumns) . "' tidak boleh null, harap diisi (Baris: " . $row->getRowIndex() . ")";
            continue;        }

        $stmt = $conn->prepare("INSERT INTO pokir (id_usulan, tanggal_usul, pengusul, usulan, masalah, alamat_lokasi, usulan_ke, opd_tujuan_awal, opd_tujuan_akhir, status, catatan, rekomendasi_sekwan, rekomendasi_mitra, rekomendasi_skpd, rekomendasi_tapd, volume, satuan, anggaran, jenis_belanja, sub_kegiatan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssssssssssss", ...$data);

        if ($stmt->execute()) {
            $rowCount++;
        } else {
            echo "Error: " . $stmt->error . "<br>";
        }
    }

    $stmt->close();
    $conn->close();

    if (!empty($errorMessages)) {
        $_SESSION['error_message'] = implode("<br>", $errorMessages);
        header("Location: index.php");
        exit();
    }

    $_SESSION['success_message'] = "File berhasil diimpor! $rowCount baris dimasukkan.";
    header("Location: index.php");
    exit();

} else {
    $_SESSION['error_message'] = "Tidak ada file yang diunggah.";
    header("Location: index.php");
    exit();
}
?>
