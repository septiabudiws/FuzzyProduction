<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Fuzzy</title>
</head>
<body>
    <h1>Hasil Perhitungan Fuzzy</h1>
    <p>Stok : {{ $stok }}</p>
    <p>Permintaan : {{ $permintaan }}</p>
    <h2>Hasil Akhir : {{ $kategori }}</h2>
    <h2>Total Produksi : {{ $hasil }}</h2>
    <a href="{{ route('fuzzy.index') }}">Kembali ke Form</a>
</body>
</html>
