<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculateController extends Controller
{
    // Fungsi stok rendah
    private function stok_rendah($stok)
    {
        if ($stok <= 30) {
            return 1;
        } elseif (30 <= $stok && $stok <= 40) {
            return (40 - $stok) / (40 - 30);
        } else {
            return 0;
        }
    }

    // Fungsi stok tinggi
    private function stok_tinggi($stok)
    {
        if ($stok > 45) {
            return 1;
        } elseif (40 <= $stok && $stok <= 45) {
            return ($stok - 40) / (45 - 40);
        } else {
            return 0;
        }
    }

    // Fungsi stok sedang
    private function stok_sedang($stok)
    {
        if ($stok <= 35 || $stok > 45) {
            return 0;
        } elseif (35 <= $stok && $stok <= 40) {
            return ($stok - 35) / (40 - 35);
        } elseif (40 <= $stok && $stok <= 45) {
            return (45 - $stok) / (45 - 40);
        } else {
            return 1;
        }
    }

    // Fungsi permintaan rendah
    private function permintaan_rendah($permintaan)
    {
        if ($permintaan <= 10) {
            return 1;
        } elseif (10 <= $permintaan && $permintaan <= 30) {
            return (30 + $permintaan) / (30 - 10);
        } else {
            return 0;
        }
    }

    // Fungsi permintaan tinggi
    private function permintaan_tinggi($permintaan)
    {
        if ($permintaan > 40) {
            return 1;
        } elseif (20 <= $permintaan && $permintaan <= 40) {
            return ($permintaan - 20) / (40 - 20);
        } else {
            return 0;
        }
    }

    // Fungsi permintaan sedang
    private function permintaan_sedang($permintaan)
    {
        if ($permintaan <= 10 || $permintaan > 40) {
            return 0;
        } elseif (10 <= $permintaan && $permintaan <= 20) {
            return ($permintaan - 10) / (20 - 10);
        } elseif (20 <= $permintaan && $permintaan <= 40) {
            return (40 - $permintaan) / (40 - 20);
        } else {
            return 1;
        }
    }

    // Metode fuzzy
    public function fuzzy(Request $request)
    {
        $stok = $request->stok;
        $permintaan = $request->permintaan;

        // Rule base
        //Tidak produksi
        $rules2 = min($this->stok_sedang($stok), $this->permintaan_rendah($permintaan));
        $rules3 = min($this->stok_tinggi($stok), $this->permintaan_rendah($permintaan));
        $rules6 = min($this->stok_tinggi($stok), $this->permintaan_sedang($permintaan));

        //Kecil
        $rules1 = min($this->stok_rendah($stok), $this->permintaan_rendah($permintaan));
        $rules5 = min($this->stok_sedang($stok), $this->permintaan_sedang($permintaan));
        $rules9 = min($this->stok_tinggi($stok), $this->permintaan_tinggi($permintaan));

        //Sedang
        $rules4 = min($this->stok_rendah($stok), $this->permintaan_sedang($permintaan));
        $rules8 = min($this->stok_sedang($stok), $this->permintaan_tinggi($permintaan));

        //Besar
        $rules7 = min($this->stok_rendah($stok), $this->permintaan_tinggi($permintaan));

        // Hasil perhitungan rule
        $hasilRule = [];

        // Tidak produksi
        $hasilRule[] = $rules2 * 0;
        $hasilRule[] = $rules3 * 0;
        $hasilRule[] = $rules6 * 0;

        // Kecil
        $hasilRule[] = $rules1 * 10;
        $hasilRule[] = $rules5 * 10;
        $hasilRule[] = $rules9 * 10;

        // Sedang
        $hasilRule[] = $rules4 * 25;
        $hasilRule[] = $rules8 * 25;

        // Besar
        $hasilRule[] = $rules7 * 40;

        // Total hasil semua rules
        $totalHasil = array_sum($hasilRule);

        // Menyimpan hasil penjumlahan tiap rule
        $jumlah_mu = $rules1 + $rules2 + $rules3 + $rules4 + $rules5 + $rules6 + $rules7 + $rules8 + $rules9;

        $hasil = $totalHasil / $jumlah_mu;

        if ($hasil == 0) {
            $kategori = "Tidak Produksi";
        } elseif (0 < $hasil && $hasil <= 10) {
            $kategori = "Produksi Kecil";
        } elseif (10 < $hasil && $hasil <= 25) {
            $kategori = "Produksi Sedang";
        } elseif ($hasil > 25) {
            $kategori = "Produksi Besar";
        }

        $hasil = max($tidak_produksi, $sedang, $kecil, $rules7);

        // Cari tahu dari mana nilai tertinggi berasal
        if ($hasil === $tidak_produksi) {
            $kategori = "Tidak Produksi";
        } elseif ($hasil === $sedang) {
            $kategori = "Sedang";
        } elseif ($hasil === $kecil) {
            $kategori = "Kecil";
        } elseif ($hasil === $rules7) {
            $kategori = "Besar";
        }

        // Defuzzifikasi
        $total_nilai = ($rules1 * 10) + ($rules2 * 0) + ($rules3 * 0) + ($rules4 * 25) +
            ($rules5 * 10) + ($rules6 * 0) + ($rules7 * 40) + ($rules8 * 25) + ($rules9 * 10);

         $total_bobot = $rules1 + $rules2 + $rules3 + $rules4 + $rules5 + $rules6 + $rules7 + $rules8;

        // Defuzzifikasi
        $total_nilai = ($rules1 * 0) + ($rules2 * 10) + ($rules3 * 25) + ($rules4 * 40);

        $total_bobot = $rules1 + $rules2 + $rules3 + $rules4 ;

        $hasil_akhir = $total_bobot > 0 ? $total_nilai / $total_bobot : 0;

        // Redirect ke view fuzzy_result dengan data
        return view('fuzzy_result', compact('hasil', 'kategori', 'stok', 'permintaan'));
    }
}
