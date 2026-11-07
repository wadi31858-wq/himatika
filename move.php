<?php
$content = file_get_contents('resources/views/home.blade.php');
$b3 = strpos($content, '{{-- ==================== BAGIAN 3: KABAR TERBARU ==================== --}}');
$b4 = strpos($content, '{{-- ==================== BAGIAN 4: LAYANAN MAHASISWA (Akademik) ==================== --}}');
$b7 = strpos($content, '{{-- ==================== SECTION 6: MATEMATIKA PEDULI ==================== --}}');

$part1 = substr($content, 0, $b3);
$part2 = substr($content, $b3, $b4 - $b3);
$part3 = substr($content, $b4, $b7 - $b4);
$part4 = substr($content, $b7);

file_put_contents('resources/views/home.blade.php', $part1 . $part3 . $part2 . $part4);
echo "Berhasil memindahkan section!";
