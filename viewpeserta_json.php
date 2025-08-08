<style>
    /* Gaya untuk tabel */
    table {
        width: 80%;
        border-collapse: collapse;
		margin: 20px Auto;
    }

    /* Gaya untuk judul tabel */
    th {
        background-color: #e5b3e1ff;  /* Warna latar belakang hijau untuk judul */
        color: white;  /* Warna teks putih */
        padding: 10px;
        text-align: left;
    }

    /* Gaya untuk data tabel */
    td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;  /* Garis bawah pada setiap baris */
    }

    /* Warna selang-seling pada baris data */
    tr:nth-child(odd) {
        background-color: #ebd4ebff;  /* Warna abu-abu terang untuk baris ganjil */
    }

    tr:nth-child(even) {
            background-color: #ffffff;  /* Warna putih untuk baris genap */
    }

    /* Gaya untuk tabel ketika disorot */
    tr:hover {
        background-color: #ddd;  /* Warna latar belakang saat baris disorot */
    }
</style>

<?php
define('FILE_JSON', 'barang.json');

function cekFileJson() {
    if(!file_exists(FILE_JSON)) {
        file_put_contents(FILE_JSON, json_encode([]));
    }
    $json = file_get_contents(FILE_JSON);	
    return json_decode($json, true);
}
// Hapus satu data
if (isset($_GET['hapus'])) {
    $namahapus = $_GET['hapus'];
    $data_barang = cekFileJson();
    $data_barang = array_filter($data_barang, function($item) use ($namahapus) {
        return $item['nama'] !== $namahapus;
    });
    file_put_contents(FILE_JSON, json_encode(array_values($data_barang), JSON_PRETTY_PRINT));
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?')); // Reload halaman tanpa query string
    exit();
}

// Hapus semua data
if (isset($_GET['hapus_semua'])) {
    file_put_contents(FILE_JSON, json_encode([]));
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?')); // Reload halaman
    exit();
}


$data_barang = cekFileJson();
$total_data = count($data_barang);
if ($total_data == 0) {
    echo "<p>Belum ada data barang yang disimpan.</p>";

} else {
	echo "<table border='1'>
      <th>No</th>
      <th>Nama</th>
      <th>Email</th>
      <th>Hp</th>
      <th>Alamat</th>
      <th>Aksi</th>";  // Tambahkan kolom aksi

for ($i = 0; $i < $total_data; $i++) {
    $barang = $data_barang[$i];

    echo "<tr><td>" .($i + 1) ."</td>";
    echo "<td>" .htmlspecialchars($barang['nama']) ."</td>";
    echo "<td>" .htmlspecialchars($barang['email']) ."</td>";    
    echo "<td>" .htmlspecialchars($barang['hp']) ."</td>";    
    echo "<td>" .htmlspecialchars($barang['alamat']) ."</td>";

    // Tombol hapus
    echo "<td><a href='?hapus=" .urlencode($barang['nama']) ."' onclick='return confirm(\"Yakin ingin menghapus barang ini?\");'>Hapus</a></td>";

    echo "</tr>";
}
echo "</table>";

	
	echo "<center>
        <button onclick='window.location.href=\"tambahpeserta.html\";'>Back</button>
        <button onclick='if(confirm(\"Yakin ingin menghapus semua data?\")) window.location.href=\"?hapus_semua=1\";'>Hapus Semua</button>
        <button onclick='window.location.href=\"tambahpeserta.html\";'>+</button>
      </center>";

}

?>