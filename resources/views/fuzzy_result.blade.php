<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hasil Fuzzy</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f7fa;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 800px;
      margin: auto;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    h1,
    h2,
    p {
      color: #333;
      text-align: center;
    }

    canvas {
      margin-top: 20px;
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    a {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      color: #fff;
      background-color: #007bff;
      padding: 10px 20px;
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    a:hover {
      background-color: #0056b3;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Hasil Perhitungan Fuzzy</h1>
    <p><strong>Stok:</strong> {{ $stok }}</p>
    <p><strong>Permintaan:</strong> {{ $permintaan }}</p>
    <table border="1" cellspacing="0" cellpadding="8" style="width: 100%; text-align: center;">
    <thead>
        <tr>
            <th>Stok</th>
            <th>Permintaan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <strong>Stok Rendah:</strong> {{ $stokRendah }}<br>
                <strong>Stok Sedang:</strong> {{ $stokSedang }}<br>
                <strong>Stok Tinggi:</strong> {{ $stokTinggi }}
            </td>
            <td>
                <strong>Permintaan Sedikit:</strong> {{ $permintaanRendah }}<br>
                <strong>Permintaan Sedang:</strong> {{ $permintaanSedang }}<br>
                <strong>Permintaan Banyak:</strong> {{ $permintaanTinggi }}
            </td>
        </tr>
    </tbody>
</table>

    <h2><strong>Kategori:</strong> {{ $kategori }}</h2>
    <h2><strong>Total Produksi:</strong> {{ $hasil }}</h2>

    <canvas id="myChart"></canvas>
    <a href="{{ route('fuzzy.index') }}">Kembali ke Form</a>
  </div>

  <script>
    const hasil = @json($hasil); // Nilai hasil (contoh: 15)
    const dynamicX = hasil;
    const dynamicY = 1;

    const ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, {
      type: 'scatter',
      data: {
        datasets: [{
          label: 'Hasil Produksi',
          data: [{
            x: dynamicX,
            y: dynamicY
          }],
          backgroundColor: 'red',
          borderColor: 'red',
          pointRadius: 10,
          pointHoverRadius: 12,
        }, ],
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false
          },
        },
        scales: {
          x: {
            type: 'linear',
            position: 'bottom',
            min: 0,
            max: 40,
            ticks: {
              callback: (value) => [0, 10, 25, 40].includes(value) ? value : null,
            },
            title: {
              display: true,
              text: 'Jumlah',
              color: '#555'
            },
          },
          y: {
            min: 0,
            max: 1,
            ticks: {
              stepSize: 1
            },
            title: {
              display: true,
              text: 'Keanggotaan',
              color: '#555'
            },
          },
        },
      },
    });
  </script>
</body>

</html>
