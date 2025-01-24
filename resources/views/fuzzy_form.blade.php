<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fuzzy Input</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-top: 10px;
            color: #555;
            font-weight: bold;
        }
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #0056b3;
        }
         .loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.9);
        z-index: 1000;
    }

    .loading-spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .spinner {
        animation: rotate 1.5s linear infinite;
        width: 80px;
        height: 80px;
    }

    .path {
        stroke: #007bff;
        stroke-linecap: round;
        animation: dash 1.5s ease-in-out infinite;
    }

    @keyframes rotate {
        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes dash {
        0% {
            stroke-dasharray: 1, 150;
            stroke-dashoffset: 0;
        }
        50% {
            stroke-dasharray: 90, 150;
            stroke-dashoffset: -35;
        }
        100% {
            stroke-dasharray: 90, 150;
            stroke-dashoffset: -125;
        }
    }

    .loading-spinner p {
        margin-top: 20px;
        font-size: 18px;
        color: #333;
        font-weight: bold;
        font-family: 'Arial', sans-serif;
    }
    </style>
</head>
<body>
    <div class="container">
        <h1>Input Data Fuzzy</h1>

        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="fuzzyForm" action="{{ route('fuzzy.calculate') }}" method="POST">
            @csrf
            <label for="stok">Jumlah Stok:</label>
            <input type="number" name="stok" id="stok" required placeholder="Masukkan jumlah stok">

            <label for="permintaan">Jumlah Permintaan:</label>
            <input type="number" name="permintaan" id="permintaan" required placeholder="Masukkan jumlah permintaan">

            <button type="submit">Hitung</button>
        </form>
    </div>

    <!-- Animasi Loading -->
    <div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <svg class="spinner" viewBox="0 0 50 50">
            <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
        </svg>
        <p>Memproses data... Harap tunggu.</p>
    </div>
</div>


    <script>
    const form = document.getElementById('fuzzyForm');
    const loadingOverlay = document.getElementById('loadingOverlay');

    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Mencegah pengiriman formulir langsung

        loadingOverlay.style.display = 'block'; // Menampilkan overlay animasi

        // Mengatur durasi loading selama 2 detik (2000 ms)
        setTimeout(() => {
            form.submit(); // Melanjutkan pengiriman formulir setelah 2 detik
        }, 1000);
    });
</script>


</body>
</html>
