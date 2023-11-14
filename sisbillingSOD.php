<?php

// Ganti URL dengan URL yang sesuai
$url = 'https://sisbilling.gks.co.id/eod';

// Buat context HTTP untuk mengirim permintaan
$context = stream_context_create([
    'http' => [
        'method' => 'GET',
    ],
]);

// Kirim permintaan ke URL
$response = file_get_contents($url, false, $context);

// Tampilkan respons atau tangani kesalahan jika ada
if ($response === false) {
    echo "Gagal mengirim permintaan ke URL: $url\n";
} else {
    echo "Permintaan berhasil dikirim ke URL: $url\n";
}
