<?php
function hitungNilaiAkhir($nilai, $benar, $jumlah_soal) {
    return $nilai + ($benar / $jumlah_soal) * (100 - $nilai);
}

$nama = "";
$nim = "";
$jurusan = "";
$kelas = "";
$nilai = 0.0;
$jumlah_soal = 30;
$lulus = false;
$keterangan = "";
$warna = "";
$error = "";
$sudah_hitung = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST["nama"] ?? "");
    $nim = trim($_POST["nim"] ?? "");
    $jurusan = $_POST["jurusan"] ?? "";
    $kelas = trim($_POST["kelas"] ?? "");

    if (!is_numeric($_POST["nilai"] ?? "")) {
        $error = "Nilai harus berupa angka.";
    } else {
        $nilai = (float) $_POST["nilai"];

        if ($nilai < 0 || $nilai > 100) {
            $error = "Nilai harus antara 0 sampai 100.";
        } else {
            $sudah_hitung = true;

            if ($nilai >= 85) {
                $lulus = true;
                $keterangan = "Anda dinyatakan lulus";
                $warna = "hijau";
            } elseif ($nilai >= 70) {
                $keterangan = "Perlu perbaikan";
                $warna = "kuning";
            } else {
                $keterangan = "Anda dinyatakan tidak lulus";
                $warna = "merah";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perhitungan Nilai Mahasiswa</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
/* ==============================
   1. GLOBAL & PALET WARNA
============================== */
* {
    box-sizing: border-box;
}

:root {
    --primary: #7c6cf0;
    --primary-dark: #5b4bd6;
    --primary-soft: #efecff;
    --text: #25254a;
    --muted: #7d7fa3;
    --line: rgba(124, 108, 240, 0.16);
    --glass: rgba(255, 255, 255, 0.62);
    --glass-strong: rgba(255, 255, 255, 0.82);
    --shadow: 0 20px 60px rgba(92, 78, 200, 0.12);
    --ease: cubic-bezier(0.22, 1, 0.36, 1);
}

html {
    scroll-behavior: smooth;
}

/* ==============================
   2. LATAR BELAKANG AESTHETIC
   Gradasi aurora + bola cahaya
   yang bergerak pelan + pola titik
============================== */
body {
    position: relative;
    min-height: 100vh;
    margin: 0;
    padding: 56px 22px;
    font-family: "Plus Jakarta Sans", "Segoe UI", Arial, sans-serif;
    line-height: 1.7;
    color: var(--text);
    background:
        radial-gradient(60% 50% at 8% 8%, #ffd9ec 0%, transparent 60%),
        radial-gradient(55% 55% at 92% 12%, #d4e3ff 0%, transparent 60%),
        radial-gradient(60% 60% at 85% 95%, #d3f6ee 0%, transparent 60%),
        radial-gradient(55% 55% at 10% 90%, #e5dbff 0%, transparent 60%),
        #f7f5ff;
    background-attachment: fixed;
    overflow-x: hidden;
}

/* bola cahaya blur */
body::before {
    content: "";
    position: fixed;
    inset: -10%;
    z-index: -2;
    pointer-events: none;
    background:
        radial-gradient(circle 260px at 20% 30%, rgba(255, 170, 210, 0.45), transparent 70%),
        radial-gradient(circle 300px at 80% 25%, rgba(140, 170, 255, 0.42), transparent 70%),
        radial-gradient(circle 280px at 65% 80%, rgba(130, 230, 205, 0.38), transparent 70%);
    filter: blur(40px);
    animation: drift 24s ease-in-out infinite alternate;
}

/* pola titik halus */
body::after {
    content: "";
    position: fixed;
    inset: 0;
    z-index: -1;
    pointer-events: none;
    background-image: radial-gradient(rgba(124, 108, 240, 0.18) 1px, transparent 1.2px);
    background-size: 28px 28px;
    -webkit-mask-image: radial-gradient(ellipse at center, #000 30%, transparent 85%);
    mask-image: radial-gradient(ellipse at center, #000 30%, transparent 85%);
}

@keyframes drift {
    0%   { transform: translate3d(0, 0, 0) scale(1); }
    50%  { transform: translate3d(3%, -4%, 0) scale(1.08); }
    100% { transform: translate3d(-3%, 3%, 0) scale(1.03); }
}

/* ==============================
   3. KONTAINER
============================== */
.container {
    width: 100%;
    max-width: 880px;
    margin: 0 auto;
    animation: fadeUp 0.9s var(--ease) both;
}

/* ==============================
   4. HEADER
============================== */
.header {
    margin-bottom: 36px;
    text-align: center;
}

.header::before {
    content: "Sistem Akademik Mahasiswa";
    display: inline-block;
    margin-bottom: 18px;
    padding: 7px 18px;
    border: 1px solid rgba(255, 255, 255, 0.9);
    border-radius: 999px;
    background: var(--glass);
    -webkit-backdrop-filter: blur(12px);
    backdrop-filter: blur(12px);
    box-shadow: 0 6px 20px rgba(124, 108, 240, 0.12);
    color: var(--primary-dark);
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.4px;
}

.header h1 {
    margin: 0 0 12px;
    font-size: clamp(28px, 5.5vw, 44px);
    line-height: 1.2;
    font-weight: 800;
    letter-spacing: -1.2px;
    background: linear-gradient(110deg, #2b2a6b 0%, #7c6cf0 55%, #e86cb0 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.header p {
    max-width: 460px;
    margin: 0 auto;
    color: var(--muted);
    font-size: 15px;
}

/* ==============================
   5. KARTU (GLASS)
============================== */
.card {
    position: relative;
    overflow: hidden;
    margin-bottom: 26px;
    padding: 34px;
    border: 1px solid rgba(255, 255, 255, 0.85);
    border-radius: 26px;
    background: var(--glass);
    -webkit-backdrop-filter: blur(22px) saturate(160%);
    backdrop-filter: blur(22px) saturate(160%);
    box-shadow: var(--shadow), inset 0 1px 0 rgba(255, 255, 255, 0.9);
    transition: transform 0.5s var(--ease), box-shadow 0.5s var(--ease);
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 28px 70px rgba(92, 78, 200, 0.17), inset 0 1px 0 rgba(255, 255, 255, 0.9);
}

.card h2 {
    display: flex;
    align-items: center;
    gap: 13px;
    margin: 0 0 28px;
    font-size: 21px;
    font-weight: 700;
    letter-spacing: -0.4px;
}

.card h2::before {
    content: "";
    flex-shrink: 0;
    width: 6px;
    height: 26px;
    border-radius: 10px;
    background: linear-gradient(180deg, #a99cff, #e86cb0);
    box-shadow: 0 4px 12px rgba(168, 120, 230, 0.35);
}

/* ==============================
   6. FORM
============================== */
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 22px;
}

.field {
    min-width: 0;
}

label {
    display: block;
    margin-bottom: 8px;
    color: #4a4b73;
    font-size: 13px;
    font-weight: 600;
}

input,
select {
    display: block;
    width: 100%;
    min-height: 52px;
    padding: 12px 16px;
    border: 1.5px solid rgba(124, 108, 240, 0.14);
    border-radius: 14px;
    outline: none;
    background: rgba(255, 255, 255, 0.7);
    color: var(--text);
    font-family: inherit;
    font-size: 14px;
    transition:
        border-color 0.35s var(--ease),
        background 0.35s var(--ease),
        box-shadow 0.35s var(--ease);
}

input::placeholder {
    color: #b3b4cf;
}

input:hover,
select:hover {
    border-color: rgba(124, 108, 240, 0.35);
    background: rgba(255, 255, 255, 0.92);
}

input:focus,
select:focus {
    border-color: var(--primary);
    background: #ffffff;
    box-shadow: 0 0 0 5px rgba(124, 108, 240, 0.14);
}

/* ==============================
   7. TOMBOL
============================== */
.button {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    min-height: 54px;
    margin-top: 30px;
    padding: 13px 20px;
    overflow: hidden;
    border: none;
    border-radius: 15px;
    background: linear-gradient(120deg, #8b7cf6, #6c5ce0 50%, #c76ad6);
    background-size: 200% 100%;
    background-position: 0% 0;
    color: #ffffff;
    font-family: inherit;
    font-size: 15px;
    font-weight: 700;
    letter-spacing: 0.2px;
    cursor: pointer;
    box-shadow: 0 10px 24px rgba(108, 92, 224, 0.3);
    transition:
        background-position 0.6s var(--ease),
        transform 0.35s var(--ease),
        box-shadow 0.35s var(--ease);
}

.button::after {
    content: "→";
    font-size: 19px;
    transition: transform 0.35s var(--ease);
}

.button:hover {
    background-position: 100% 0;
    transform: translateY(-2px);
    box-shadow: 0 16px 32px rgba(108, 92, 224, 0.38);
}

.button:hover::after {
    transform: translateX(5px);
}

.button:active {
    transform: translateY(0) scale(0.99);
}

.button:focus-visible {
    outline: 3px solid #c3bbff;
    outline-offset: 4px;
}

/* ==============================
   8. PESAN ERROR
============================== */
.alert {
    margin-bottom: 26px;
    padding: 16px 20px;
    border-radius: 16px;
    font-size: 14px;
    font-weight: 600;
    animation: fadeUp 0.5s var(--ease) both;
}

.alert-error {
    border: 1px solid #ffc9d4;
    background: rgba(255, 240, 243, 0.85);
    -webkit-backdrop-filter: blur(10px);
    backdrop-filter: blur(10px);
    color: #c12e4b;
    box-shadow: 0 8px 22px rgba(193, 46, 75, 0.08);
}

/* ==============================
   9. HASIL
============================== */
.result {
    animation: fadeUp 0.7s var(--ease) both;
}

.section {
    margin-bottom: 24px;
    padding: 24px;
    border: 1px solid rgba(255, 255, 255, 0.9);
    border-radius: 20px;
    background: var(--glass-strong);
    transition: box-shadow 0.4s var(--ease);
}

.section:last-child {
    margin-bottom: 0;
}

.section:hover {
    box-shadow: 0 10px 30px rgba(92, 78, 200, 0.08);
}

.section-title {
    display: flex;
    align-items: center;
    gap: 11px;
    margin: 0 0 18px;
    color: #34346a;
    font-size: 16px;
    font-weight: 700;
}

.section-title::before {
    content: "▦";
    display: grid;
    place-items: center;
    width: 34px;
    height: 34px;
    border-radius: 11px;
    background: var(--primary-soft);
    color: var(--primary);
    font-size: 17px;
}

/* ==============================
   10. TABEL
============================== */
.table-wrap {
    width: 100%;
    overflow-x: auto;
    border: 1px solid var(--line);
    border-radius: 16px;
    background: rgba(255, 255, 255, 0.85);
}

table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 14px;
}

th,
td {
    padding: 13px 18px;
    text-align: left;
    border-bottom: 1px solid rgba(124, 108, 240, 0.08);
}

th {
    background: rgba(239, 236, 255, 0.9);
    color: var(--primary-dark);
    font-size: 13px;
    font-weight: 700;
}

tbody tr:last-child td {
    border-bottom: none;
}

tbody tr {
    transition: background 0.3s var(--ease);
}

tbody tr:hover td {
    background: rgba(124, 108, 240, 0.05);
}

td.label {
    width: 35%;
    color: var(--muted);
    font-weight: 500;
}

td:not(.label) {
    color: #2f3055;
    font-weight: 600;
}

/* ==============================
   11. STATUS KELULUSAN
============================== */
.status {
    position: relative;
    margin-top: 20px;
    padding: 16px 18px 16px 52px;
    border: 1px solid transparent;
    border-radius: 15px;
    font-size: 14px;
    font-weight: 700;
    transition: transform 0.4s var(--ease);
}

.status:hover {
    transform: translateX(4px);
}

.status::before {
    position: absolute;
    top: 50%;
    left: 17px;
    display: grid;
    place-items: center;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    font-size: 13px;
    transform: translateY(-50%);
}

.hijau {
    border-color: #b8ecd0;
    background: linear-gradient(110deg, #e9fff3, #f4fffa);
    color: #18734a;
}

.hijau::before {
    content: "✓";
    background: #c4f3d9;
    color: #146c43;
}

.kuning {
    border-color: #f6dfa0;
    background: linear-gradient(110deg, #fff8e5, #fffcf2);
    color: #946300;
}

.kuning::before {
    content: "!";
    background: #ffecb8;
    color: #946300;
}

.merah {
    border-color: #ffc9d4;
    background: linear-gradient(110deg, #ffeef1, #fff8f9);
    color: #ba304b;
}

.merah::before {
    content: "×";
    background: #ffd6de;
    color: #ba304b;
}

/* ==============================
   12. SIMULASI
============================== */
tr.lolos td {
    background: rgba(214, 248, 230, 0.7);
    color: #18734a;
    font-weight: 700;
}

tr.lolos td:first-child {
    border-left: 3px solid #35b878;
}

tr.lolos:hover td {
    background: rgba(196, 243, 217, 0.9);
}

.formula {
    margin: 16px 0 0;
    padding: 13px 16px;
    border: 1px dashed rgba(124, 108, 240, 0.3);
    border-radius: 12px;
    background: rgba(247, 245, 255, 0.8);
    color: var(--muted);
    font-size: 12.5px;
}

/* ==============================
   13. FOOTER
============================== */
.footer {
    padding: 18px 0 6px;
    color: #9a9bbd;
    font-size: 12.5px;
    text-align: center;
}

.footer::before {
    content: "";
    display: block;
    width: 48px;
    height: 3px;
    margin: 0 auto 16px;
    border-radius: 10px;
    background: linear-gradient(90deg, #a99cff, #f0a6d0);
}

/* ==============================
   14. ANIMASI
============================== */
@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ==============================
   15. RESPONSIF
============================== */
@media (max-width: 600px) {
    body {
        padding: 30px 14px;
    }

    .header {
        margin-bottom: 26px;
    }

    .header p {
        font-size: 14px;
    }

    .card {
        padding: 24px 18px;
        border-radius: 20px;
    }

    .card h2 {
        font-size: 19px;
        margin-bottom: 22px;
    }

    .form-grid {
        grid-template-columns: minmax(0, 1fr);
        gap: 18px;
    }

    .section {
        padding: 16px 12px;
        border-radius: 16px;
    }

    th,
    td {
        padding: 11px 12px;
        white-space: nowrap;
    }

    .status {
        padding-right: 12px;
        font-size: 13px;
    }
}

/* ==============================
   16. AKSESIBILITAS
============================== */
@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
        scroll-behavior: auto !important;
    }
}
    </style>
</head>

<body>
<div class="container">

    <header class="header">
        <h1>Perhitungan Nilai Mahasiswa</h1>
        <p>Masukkan data anda untuk melihat hasil.</p>
    </header>

    <section class="card">
        <h2>Input Data Mahasiswa</h2>

        <form method="POST">
            <div class="form-grid">
                <div class="field">
                    <label for="nama">Nama Mahasiswa</label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        placeholder="Masukkan nama lengkap"
                        value="<?= htmlspecialchars($nama, ENT_QUOTES, 'UTF-8') ?>"
                        required>
                </div>

                <div class="field">
                    <label for="nim">NIM</label>
                    <input
                        type="text"
                        id="nim"
                        name="nim"
                        placeholder="Masukkan NIM"
                        value="<?= htmlspecialchars($nim, ENT_QUOTES, 'UTF-8') ?>"
                        required>
                </div>

                <div class="field">
                    <label for="jurusan">Jurusan</label>
                    <select id="jurusan" name="jurusan" required>
                        <option value="">-- Pilih Jurusan --</option>
                        <?php
                        $daftar_jurusan = [
                            "Teknik Informatika",
                            "Sistem Informasi",
                            "Ilmu Komputer"
                        ];

                        foreach ($daftar_jurusan as $opsi) {
                            $selected = ($jurusan === $opsi) ? "selected" : "";
                            echo '<option value="' .
                                htmlspecialchars($opsi, ENT_QUOTES, 'UTF-8') .
                                '" ' . $selected . '>' .
                                htmlspecialchars($opsi, ENT_QUOTES, 'UTF-8') .
                                '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="field">
                    <label for="kelas">Kelas</label>
                    <input
                        type="text"
                        id="kelas"
                        name="kelas"
                        placeholder="Contoh: 3A"
                        value="<?= htmlspecialchars($kelas, ENT_QUOTES, 'UTF-8') ?>"
                        required>
                </div>

                <div class="field">
                    <label for="nilai">Nilai (0–100)</label>
                    <input
                        type="number"
                        id="nilai"
                        name="nilai"
                        min="0"
                        max="100"
                        step="any"
                        placeholder="Masukkan nilai"
                        value="<?= $sudah_hitung || $error !== "" ? htmlspecialchars((string)($_POST["nilai"] ?? ""), ENT_QUOTES, 'UTF-8') : "" ?>"
                        required>
                </div>
            </div>

            <button class="button" type="submit">
                Hitung Nilai
            </button>
        </form>
    </section>

    <?php if ($error !== "") { ?>
        <div class="alert alert-error" role="alert">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php } ?>

    <?php if ($sudah_hitung) { ?>
        <section class="card result" aria-live="polite">
            <h2>Hasil Perhitungan</h2>

            <div class="section">
                <h3 class="section-title">Data Mahasiswa</h3>

                <div class="table-wrap">
                    <table>
                        <tbody>
                            <tr>
                                <td class="label">Nama</td>
                                <td><?= htmlspecialchars($nama, ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                            <tr>
                                <td class="label">NIM</td>
                                <td><?= htmlspecialchars($nim, ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                            <tr>
                                <td class="label">Jurusan</td>
                                <td><?= htmlspecialchars($jurusan, ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                            <tr>
                                <td class="label">Kelas</td>
                                <td><?= htmlspecialchars($kelas, ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                            <tr>
                                <td class="label">Nilai</td>
                                <td><?= htmlspecialchars((string)$nilai, ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="status <?= $warna ?>">
                    Keterangan: <?= htmlspecialchars($keterangan, ENT_QUOTES, 'UTF-8') ?>
                </div>
            </div>

            <?php if (!$lulus) { ?>
                <div class="section">
                    <h3 class="section-title">
                        Simulasi Nilai Ulangan (<?= $jumlah_soal ?> Soal)
                    </h3>

                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Soal Benar</th>
                                    <th>Nilai Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($benar = 0; $benar <= $jumlah_soal; $benar++) {
                                    $nilai_akhir = hitungNilaiAkhir(
                                        $nilai,
                                        $benar,
                                        $jumlah_soal
                                    );

                                    $kelas_baris = $nilai_akhir >= 85 ? "lolos" : "";
                                ?>
                                    <tr class="<?= $kelas_baris ?>">
                                        <td><?= $benar ?></td>
                                        <td><?= number_format($nilai_akhir, 1, '.', '') ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <p class="formula">
                        Nilai akhir = nilai awal + (soal benar / jumlah soal)
                        × (100 − nilai awal).
                    </p>
                </div>
            <?php } ?>
        </section>
    <?php } ?>

    <footer class="footer">
        Perhitungan Nilai Mahasiswa &bull; PHP
    </footer>

</div>
</body>
</html>