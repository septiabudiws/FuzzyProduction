import sys
import json

# Fungsi keanggotaan untuk stok
def stok_rendah(stok):
    if stok <= 20:
        return 1
    elif 20 < stok <= 50:
        return (50 - stok) / 30
    else:
        return 0

def stok_sedang(stok):
    if 20 < stok <= 50:
        return (stok - 20) / 30
    elif 50 < stok <= 80:
        return (80 - stok) / 30
    else:
        return 0

def stok_tinggi(stok):
    if stok > 80:
        return 1
    elif 50 < stok <= 80:
        return (stok - 50) / 30
    else:
        return 0

# Fungsi keanggotaan untuk permintaan
def permintaan_rendah(permintaan):
    if permintaan <= 30:
        return 1
    elif 30 < permintaan <= 60:
        return (60 - permintaan) / 30
    else:
        return 0

def permintaan_sedang(permintaan):
    if 30 < permintaan <= 60:
        return (permintaan - 30) / 30
    elif 60 < permintaan <= 90:
        return (90 - permintaan) / 30
    else:
        return 0

def permintaan_tinggi(permintaan):
    if permintaan > 90:
        return 1
    elif 60 < permintaan <= 90:
        return (permintaan - 60) / 30
    else:
        return 0

# Fungsi inferensi berdasarkan rule base
def inferensi(stok, permintaan):
    rules = []

    # Aturan fuzzy
    rules.append(("Rendah", min(stok_rendah(stok), permintaan_tinggi(permintaan))))  # Rule 1
    rules.append(("Sedang", min(stok_sedang(stok), permintaan_sedang(permintaan))))  # Rule 2
    rules.append(("Tinggi", min(stok_tinggi(stok), permintaan_rendah(permintaan))))  # Rule 3

    return rules

# Defuzzifikasi dengan rata-rata berbobot
def defuzzifikasi(rules):
    # Nilai tetap untuk output fuzzy (Rendah, Sedang, Tinggi)
    output_values = {
        "Rendah": 100,
        "Sedang": 300,
        "Tinggi": 500
    }

    total_weight = 0
    total_value = 0

    for key, value in rules:
        total_value += value * output_values[key]
        total_weight += value

    if total_weight == 0:
        return 0  # Jika tidak ada aturan yang aktif, return 0
    return total_value / total_weight

# Fungsi utama
if __name__ == "__main__":
    # Ambil input JSON dari Laravel
    input_data = json.loads(sys.argv[1])

    stok = input_data["stok"]
    permintaan = input_data["permintaan"]

    # Hitung inferensi dan defuzzifikasi
    rules = inferensi(stok, permintaan)
    final_output = defuzzifikasi(rules)

    # Output hasil dalam format JSON
    result = {
        "final_output": final_output,
        "output_values": {rule[0]: rule[1] for rule in rules}
    }

    print(json.dumps(result))
