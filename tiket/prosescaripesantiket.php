<?php
include '../koneksi/koneksi.php';

$kata = trim($_POST['cari'] ?? '');
$cari = '%' . $kata . '%';

// JOIN supaya bisa mencari berdasarkan nama pelanggan juga
$stmt = mysqli_prepare($koneksi,
    "SELECT pt.*, p.nama AS nama_pelanggan
     FROM pesan_tiket pt
     JOIN pelanggan p ON pt.id_pel = p.id
     WHERE pt.id_pesan LIKE ? OR pt.dari LIKE ? OR pt.tujuan LIKE ?
        OR pt.no_kursi LIKE ? OR p.nama LIKE ?
     ORDER BY pt.id_pesan ASC");
mysqli_stmt_bind_param($stmt, "sssss", $cari, $cari, $cari, $cari, $cari);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$jumlah = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hasil Pencarian Pesan Tiket</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
:root{
  --navy:#101a30; --blue:#4361ee; --blue-l:#eef2ff; --text:#202b40; --muted:#7d889c;
  --line:#e3e8f1; --bg:#f2f5fb; --orange:#f26b21;
}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Inter',Arial,sans-serif;background:var(--bg);color:var(--text);min-height:100vh;font-size:14px}
a{color:inherit;text-decoration:none}

.hero{background:linear-gradient(120deg,var(--navy),#22397a 70%,#3450d8);color:#fff;padding:22px 24px 110px}
.hero-in{max-width:1040px;margin:auto}
.back{display:inline-flex;align-items:center;gap:8px;font-size:13px;color:#c8d4ff;margin-bottom:26px}
.back:hover{color:#fff}
.hero h1{font-size:28px;font-weight:800;letter-spacing:-.8px}
.hero p{margin-top:8px;color:#c8d4ff;font-size:14px}

.wrap{max-width:1040px;margin:-72px auto 50px;padding:0 24px}

/* kotak cari */
.searchbar{background:#fff;border:1px solid var(--line);border-radius:18px;padding:14px;display:flex;gap:10px;box-shadow:0 10px 30px rgba(25,40,90,.08)}
.searchbar .field{position:relative;flex:1}
.searchbar .field span{position:absolute;left:16px;top:50%;transform:translateY(-50%);color:var(--blue);font-size:17px;pointer-events:none}
.searchbar input{width:100%;height:50px;padding:0 16px 0 46px;border:1.5px solid var(--line);border-radius:12px;font:inherit;font-size:14px;background:#fbfcff;outline:none;transition:border-color .15s,box-shadow .15s}
.searchbar input:focus{border-color:var(--blue);background:#fff;box-shadow:0 0 0 4px rgba(67,97,238,.12)}
.searchbar button{height:50px;padding:0 26px;border:0;border-radius:12px;background:var(--orange);color:#fff;font:inherit;font-weight:700;font-size:14px;cursor:pointer;transition:background .15s}
.searchbar button:hover{background:#dc5a14}

.summary{display:flex;justify-content:space-between;align-items:center;gap:14px;margin:24px 4px 14px;font-size:13px;color:var(--muted)}
.summary b{color:var(--text)}
.summary a{color:var(--blue);font-weight:600}
.summary a:hover{text-decoration:underline}

/* kartu tiket */
.tickets{display:grid;gap:14px}
.ticket{display:grid;grid-template-columns:minmax(0,1fr) 230px;background:#fff;border:1px solid var(--line);border-radius:16px;box-shadow:0 4px 16px rgba(25,40,90,.05);position:relative;transition:box-shadow .2s,transform .2s}
.ticket:hover{box-shadow:0 10px 26px rgba(25,40,90,.10);transform:translateY(-2px)}
.t-main{padding:20px 24px}
.t-id{display:inline-block;padding:4px 10px;border-radius:7px;background:var(--blue-l);color:#4056d6;font-size:12px;font-weight:700;margin-bottom:12px}
.t-route{display:flex;align-items:center;gap:14px}
.t-route strong{font-size:20px;font-weight:800;letter-spacing:-.5px;overflow-wrap:anywhere}
.t-route .arrow{flex:1;max-width:90px;height:2px;background:repeating-linear-gradient(90deg,#b9c4e4 0 6px,transparent 6px 11px);position:relative}
.t-route .arrow::after{content:"";position:absolute;right:-2px;top:-4px;border:5px solid transparent;border-left:8px solid #b9c4e4}
.t-meta{display:flex;flex-wrap:wrap;gap:8px 26px;margin-top:16px}
.t-meta div span{display:block;font-size:11.5px;color:var(--muted)}
.t-meta div b{font-size:13.5px;font-weight:600}

.t-stub{padding:20px 22px;border-left:2px dashed var(--line);display:flex;flex-direction:column;justify-content:space-between;gap:16px;position:relative}
.t-stub::before,.t-stub::after{content:"";position:absolute;left:-13px;width:24px;height:24px;border-radius:50%;background:var(--bg);border:1px solid var(--line)}
.t-stub::before{top:-13px;clip-path:inset(50% 0 0 0)}
.t-stub::after{bottom:-13px;clip-path:inset(0 0 50% 0)}
.t-price span{display:block;font-size:11.5px;color:var(--muted)}
.t-price b{font-size:21px;font-weight:800;color:var(--orange);letter-spacing:-.5px}
.t-act{display:flex;gap:8px}
.btn-edit,.btn-del{flex:1;display:inline-flex;align-items:center;justify-content:center;height:38px;border-radius:10px;font-size:12.5px;font-weight:600;transition:background .15s}
.btn-edit{background:#fff5df;color:#a66a00}.btn-edit:hover{background:#ffebba}
.btn-del{background:#fff0f1;color:#d34150}.btn-del:hover{background:#ffdcdf}

/* kosong */
.empty{background:#fff;border:1px solid var(--line);border-radius:18px;padding:54px 24px;text-align:center;box-shadow:0 4px 16px rgba(25,40,90,.05)}
.empty .em-ic{font-size:44px;margin-bottom:14px}
.empty h2{font-size:18px;font-weight:700;margin-bottom:8px}
.empty p{color:var(--muted);max-width:380px;margin:0 auto 22px;line-height:1.7}
.empty a{display:inline-flex;align-items:center;height:46px;padding:0 22px;border-radius:12px;background:var(--blue);color:#fff;font-weight:600}
.empty a:hover{background:#3048d5}

:focus-visible{outline:3px solid rgba(67,97,238,.45);outline-offset:2px}

@media (max-width:720px){
  .hero{padding:18px 16px 100px}.hero h1{font-size:23px}
  .wrap{padding:0 14px}
  .searchbar{flex-direction:column}
  .searchbar button{width:100%}
  .ticket{grid-template-columns:1fr}
  .t-stub{border-left:0;border-top:2px dashed var(--line)}
  .t-stub::before,.t-stub::after{top:-13px;bottom:auto;clip-path:none;width:24px}
  .t-stub::before{left:-13px;clip-path:inset(0 0 0 50%)}
  .t-stub::after{left:auto;right:-13px;clip-path:inset(0 50% 0 0)}
  .t-route strong{font-size:18px}
}
@media (prefers-reduced-motion:reduce){*{transition:none!important}}
</style>
</head>
<body>

<header class="hero">
    <div class="hero-in">
        <a href="pesantiket.php" class="back">← Kembali ke daftar pesanan</a>
        <h1>Hasil pencarian tiket</h1>
        <p>Cari berdasarkan nama pelanggan, kota asal, tujuan, kursi, atau kode pesanan.</p>
    </div>
</header>

<div class="wrap">

    <form class="searchbar" action="prosescaripesantiket.php" method="POST">
        <div class="field">
            <span>⌕</span>
            <input type="search" name="cari" value="<?= htmlspecialchars($kata); ?>"
                   placeholder="Cari pelanggan, tujuan, kursi..." autofocus>
        </div>
        <button type="submit">Cari tiket</button>
    </form>

    <div class="summary">
        <span>
            <?php if ($kata !== ''): ?>
                Ditemukan <b><?= $jumlah; ?> pesanan</b> untuk "<b><?= htmlspecialchars($kata); ?></b>"
            <?php else: ?>
                Menampilkan semua <b><?= $jumlah; ?> pesanan</b>
            <?php endif; ?>
        </span>
        <a href="pesantiket.php">Lihat semua pesanan</a>
    </div>

    <?php if ($jumlah > 0): ?>
    <div class="tickets">
        <?php while ($d = mysqli_fetch_assoc($result)): ?>
        <article class="ticket">
            <div class="t-main">
                <span class="t-id"><?= htmlspecialchars($d['id_pesan']); ?></span>
                <div class="t-route">
                    <strong><?= htmlspecialchars($d['dari']); ?></strong>
                    <span class="arrow"></span>
                    <strong><?= htmlspecialchars($d['tujuan']); ?></strong>
                </div>
                <div class="t-meta">
                    <div><span>Pelanggan</span><b><?= htmlspecialchars($d['nama_pelanggan']); ?></b></div>
                    <div><span>Penumpang</span><b><?= htmlspecialchars($d['jlh_penumpang']); ?> orang</b></div>
                    <div><span>Nomor kursi</span><b><?= htmlspecialchars($d['no_kursi']); ?></b></div>
                </div>
            </div>
            <div class="t-stub">
                <div class="t-price">
                    <span>Total harga</span>
                    <b><?= is_numeric($d['harga']) ? 'Rp ' . number_format((float) $d['harga'], 0, ',', '.') : htmlspecialchars($d['harga']); ?></b>
                </div>
                <div class="t-act">
                    <a class="btn-edit" href="editpesantiket.php?id=<?= urlencode($d['id_pesan']); ?>">✎ Edit</a>
                    <a class="btn-del" href="hapus4.php?id=<?= urlencode($d['id_pesan']); ?>"
                       onclick="return confirm('Yakin ingin menghapus pesanan ini?')">× Hapus</a>
                </div>
            </div>
        </article>
        <?php endwhile; ?>
    </div>

    <?php else: ?>
    <div class="empty">
        <div class="em-ic">🎫</div>
        <h2>Tiket tidak ditemukan</h2>
        <p>Tidak ada pesanan yang cocok dengan "<?= htmlspecialchars($kata); ?>". Coba kata kunci lain, misalnya nama kota atau nama pelanggan.</p>
        <a href="pesantiket.php">Kembali ke daftar pesanan</a>
    </div>
    <?php endif; ?>

</div>

</body>
</html>