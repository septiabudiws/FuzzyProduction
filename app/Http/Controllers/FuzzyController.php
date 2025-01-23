<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FuzzyController extends Controller
{
    public function index()
    {
        return view('fuzzy_form');
    }

    // Memproses input dan menghitung fuzzy
    public function calculate(Request $request)
    {
        // Validasi input
        $request->validate([
            'stok' => 'required|numeric',
            'permintaan' => 'required|numeric',
        ]);

        // Input dari form
        $stok = $request->input('stok');
        $permintaan = $request->input('permintaan');

        // Format data sebagai JSON string
        $inputData = json_encode([
            'stok' => $stok,
            'permintaan' => $permintaan,
        ]);

        // Lokasi file Python
        $pythonScript = public_path('scripts/fuzzy.py');

        // Jalankan Python dan tangkap output
        $command = "python $pythonScript '$inputData'";
        $output = shell_exec($command);
        if ($output === null) {
            return back()->withErrors(['error' => 'Tidak ada output dari perintah Python.']);
        }

        $result = json_decode($output, true);
        if ($result === null) {
            return back()->withErrors(['error' => 'Gagal mendecode hasil JSON dari Python.']);
        }

        // Decode output JSON dari Python
        $result = json_decode($output, true);

        // Validasi hasil dari Python
        if (!$result || !isset($result['final_output']) || !isset($result['output_values'])) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memproses data dengan Python.']);
        }

        // Tampilkan hasil ke view
        return view('fuzzy_result', [
            'final_output' => $result['final_output'],
            'output_values' => $result['output_values'],
        ]);
    }

    public function fuzzy(Request $request){
        $stok = $request->stok;
        $permintaan = $request->permintaan;
        
    }
}
