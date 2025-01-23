<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fuzzy Input</title>
</head>
<body>
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

    <form action="{{ route('fuzzy.calculate') }}" method="POST">
        @csrf
        <label for="stok">Jumlah Stok:</label>
        <input type="number" name="stok" id="stok" required>
        <br><br>
        <label for="permintaan">Jumlah Permintaan:</label>
        <input type="number" name="permintaan" id="permintaan" required>
        <br><br>
        <button type="submit">Hitung</button>
    </form>
</body>
</html>
