<?php
// Definisikan nama file JSON, yaitu barang.json
define('FILE_JSON', 'barang.json');

/* prosedur untuk cek apakah file JSON ada, jika tidak ada, maka buat file JSON dengan data kosong*/
function cekFileJson() {
    // jika file JSON tidak ada, maka
    if (!file_exists(FILE_JSON)) {
        // buat file JSON dengan data kosong
        file_put_contents(FILE_JSON, json_encode([]));
    }
}

// fungsi untuk membaca data dari file JSON
function bacaDataJson() {
    /*php tidak mengenal tipe data JSON, yang ada tipe data array,jadi lakukan koversi data JSON ke array dengan perintah "json_decode".
    setelah dikonversi,kembalikan hasil konversi ke fungsi yg memanggilnya menggunakan perintah "return"*/
    return json_decode(file_get_contents(FILE_JSON), true);
}
    // proses saat form dikirim
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        //panggil prosedur cekfileJson()
        cekFileJson();

        /*simpan ke variabel ambil data dari form (name input type)*/
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $hp = $_POST['hp'];
        $alamat = $_POST['alamat'];

        //panggil fungsi data son()
        $data_barang = bacaDataJson();

        //cek apakah kode barang sudah ada
        for ($i = 0; $i     < count($data_barang); $i++) {
            if ($data_barang[$i]['nama']=== $nama) {
                //tampilan pesan barang sudah ada
                echo "<script>alert('Barang dengan nama: $nama sudah ada!');<?script>";
                // setelah tombol OK diklik pd pesan,alihkan halaman ke frmBarang.html
                echo "<script>window.location.href = 'tambahpeserta.html';</script>";
                exit;
            }
        }
    
    $data_barang[] = [
    'nama' => $nama,
    'email' => $email,
    'hp'=> $hp,
    'alamat' => $alamat
];

file_put_contents(FILE_JSON, json_encode($data_barang, JSON_PRETTY_PRINT));

echo "<script>alert('Data berhasil ditambahkan!');</script>";
echo "<script>window.location.href = 'tambahpeserta.html';</script>";
}

?>