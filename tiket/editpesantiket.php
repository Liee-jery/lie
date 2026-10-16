<?php
include '../koneksi/koneksi.php';

$id_pesan = $_GET['id'];
$stmt = mysqli_prepare($koneksi, "SELECT * FROM pesan_tiket WHERE id_pesan=?");
mysqli_stmt_bind_param($stmt, "s", $id_pesan);
mysqli_stmt_execute($stmt);
$d = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$d) { die("Data tidak ditemukan."); }

$pelanggan = mysqli_query($koneksi, "SELECT id, nama FROM pelanggan ORDER BY nama ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Pesan Tiket</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
:root{
  --navy:#101a30; --navy2:#1c2b48; --blue:#4361ee; --blue-d:#3048d5; --blue-l:#eef2ff;
  --text:#202b40; --muted:#7d889c; --line:#e3e8f1; --bg:#f2f5fb; --orange:#f26b21; --ok:#0f9f75;
}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Inter',Arial,sans-serif;background:var(--bg);color:var(--text);min-height:100vh;font-size:14px}
a{color:inherit;text-decoration:none}

.hero{background:linear-gradient(120deg,var(--navy),#22397a 70%,#3450d8);color:#fff;padding:22px 24px 120px}
.hero-in{max-width:1040px;margin:auto}
.back{display:inline-flex;align-items:center;gap:8px;font-size:13px;color:#c8d4ff;margin-bottom:26px}
.back:hover{color:#fff}
.hero h1{font-size:28px;font-weight:800;letter-spacing:-.8px}
.hero p{margin-top:8px;color:#c8d4ff;font-size:14px}

.wrap{max-width:1040px;margin:-82px auto 50px;padding:0 24px;display:grid;grid-template-columns:minmax(0,1fr) 340px;gap:22px;align-items:start}

.card{background:#fff;border:1px solid var(--line);border-radius:18px;padding:26px;box-shadow:0 10px 30px rgba(25,40,90,.07)}
.step{margin-bottom:26px}
.step:last-of-type{margin-bottom:0}
.step h2{font-size:15px;font-weight:700;margin-bottom:4px}
.step>p{color:var(--muted);font-size:12.5px;margin-bottom:14px}
.step+.step{padding-top:24px;border-top:1px solid var(--line)}

label{display:block;font-size:12.5px;font-weight:600;margin-bottom:6px;color:#44516a}
.field{position:relative}
.field .ic{position:absolute;left:14px;top:50%;transform:translateY(-50%);font-size:15px;pointer-events:none;color:var(--blue)}
.field input,.field select{width:100%;height:50px;padding:0 14px 0 42px;border:1.5px solid var(--line);border-radius:12px;font:inherit;font-size:14px;background:#fbfcff;color:var(--text);outline:none;transition:border-color .15s,box-shadow .15s}
.field select{appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' fill='none' stroke='%237d889c' stroke-width='2'%3E%3Cpath d='M1 1l5 5 5-5'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 16px center;padding-right:40px}
.field input:focus,.field select:focus{border-color:var(--blue);background:#fff;box-shadow:0 0 0 4px rgba(67,97,238,.12)}
.hint{font-size:11.5px;color:var(--muted);margin-top:6px}

.route{display:grid;grid-template-columns:1fr 44px 1fr;gap:10px;align-items:end}
.swap{width:44px;height:44px;margin-bottom:3px;border-radius:50%;border:1.5px solid var(--line);background:#fff;color:var(--blue);font-size:18px;cursor:pointer;transition:transform .25s,background .15s}
.swap:hover{background:var(--blue-l)}
.swap:active{transform:rotate(180deg)}

.row2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.stepper{display:flex;align-items:center;height:50px;border:1.5px solid var(--line);border-radius:12px;background:#fbfcff;overflow:hidden}
.stepper button{width:50px;height:100%;border:0;background:transparent;font-size:20px;color:var(--blue);cursor:pointer}
.stepper button:hover{background:var(--blue-l)}
.stepper input{flex:1;min-width:0;height:100%;border:0;background:transparent;text-align:center;font:inherit;font-weight:700;font-size:15px;outline:none}
.stepper:focus-within{border-color:var(--blue);box-shadow:0 0 0 4px rgba(67,97,238,.12);background:#fff}

.price{position:relative}
.price b{position:absolute;left:14px;top:50%;transform:translateY(-50%);font-size:14px;color:var(--muted);font-weight:700}
.price input{width:100%;height:50px;padding:0 14px 0 46px;border:1.5px solid var(--line);border-radius:12px;font:inherit;font-size:16px;font-weight:700;background:#fbfcff;outline:none}
.price input:focus{border-color:var(--blue);background:#fff;box-shadow:0 0 0 4px rgba(67,97,238,.12)}

/* tiket ringkasan */
.side{position:sticky;top:20px}
.ticket{background:#fff;border-radius:18px;box-shadow:0 10px 30px rgba(25,40,90,.10);border:1px solid var(--line);position:relative}
.t-top{padding:22px 22px 20px;background:linear-gradient(135deg,var(--navy),#22397a);color:#fff;border-radius:17px 17px 0 0}
.t-top small{color:#aebcf0;font-size:12px}
.t-route{display:flex;align-items:center;gap:10px;margin-top:10px}
.t-route div{flex:1;min-width:0}
.t-route strong{display:block;font-size:19px;font-weight:800;letter-spacing:-.4px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.t-route div:last-child{text-align:right}
.t-route span{font-size:20px;color:#8fa4ff}
.t-cut{position:relative;height:0;border-top:2px dashed var(--line);margin:0 18px}
.t-cut::before,.t-cut::after{content:"";position:absolute;top:-13px;width:24px;height:24px;border-radius:50%;background:var(--bg);border:1px solid var(--line)}
.t-cut::before{left:-31px;clip-path:inset(0 0 0 50%)}
.t-cut::after{right:-31px;clip-path:inset(0 50% 0 0)}
.t-body{padding:20px 22px 6px}
.t-line{display:flex;justify-content:space-between;gap:14px;padding:9px 0;font-size:13px}
.t-line span{color:var(--muted)}
.t-line b{font-weight:600;text-align:right;overflow-wrap:anywhere}
.t-total{display:flex;justify-content:space-between;align-items:baseline;padding:16px 22px;border-top:1px solid var(--line)}
.t-total span{font-size:13px;color:var(--muted)}
.t-total b{font-size:22px;font-weight:800;color:var(--orange);letter-spacing:-.5px}
.t-act{padding:0 22px 22px}
.btn{width:100%;height:52px;border:0;border-radius:12px;background:var(--orange);color:#fff;font:inherit;font-size:15px;font-weight:700;cursor:pointer;transition:background .15s,transform .1s}
.btn:hover{background:#dc5a14}
.btn:active{transform:scale(.99)}
.cancel{display:block;text-align:center;margin-top:12px;font-size:13px;color:var(--muted)}
.cancel:hover{color:var(--text)}
:focus-visible{outline:3px solid rgba(67,97,238,.45);outline-offset:2px}

@media (max-width:900px){
  .wrap{grid-template-columns:1fr;margin-top:-82px}
  .side{position:static;order:2}
}
@media (max-width:560px){
  .hero{padding:18px 16px 110px}.hero h1{font-size:23px}
  .wrap{padding:0 14px}.card{padding:20px 16px}
  .route{grid-template-columns:1fr}
  .swap{justify-self:center;transform:rotate(90deg);margin:-2px 0}
  .swap:active{transform:rotate(270deg)}
  .row2{grid-template-columns:1fr}
}
@media (prefers-reduced-motion:reduce){*{transition:none!important}}
</style>
</head>
<body>

<header class="hero">
    <div class="hero-in">
        <a href="pesantiket.php" class="back">← Kembali ke daftar pesanan</a>
        <h1>Ubah pesanan tiket</h1>
        <p>Perbarui data perjalanan, ringkasan tiket ikut berubah.</p>
    </div>
</header>

<div class="wrap">

    <form class="card" id="formPesan" action="prosesubahtiket.php" method="POST">
        <input type="hidden" name="id_pesan" id="idpesan" value="<?= htmlspecialchars($d['id_pesan']); ?>">

        <div class="step">
            <h2>Siapa yang memesan?</h2>
            <p>Pilih pelanggan yang sudah terdaftar.</p>
            <label for="id_pel">Pelanggan</label>
            <div class="field">
                <span class="ic">👤</span>
                <select name="id_pel" id="id_pel" required>
                    <?php while ($p = mysqli_fetch_assoc($pelanggan)): ?>
                        <option value="<?= htmlspecialchars($p['id']); ?>"
                            <?= $p['id'] == $d['id_pel'] ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($p['id'] . ' - ' . $p['nama']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <div class="step">
            <h2>Mau ke mana?</h2>
            <p>Tentukan stasiun asal dan tujuan perjalanan.</p>
            <div class="route">
                <div>
                    <label for="dari">Dari</label>
                    <div class="field">
                        <span class="ic">●</span>
                        <input type="text" name="dari" id="dari" maxlength="50" placeholder="Contoh: Bandung" value="<?= htmlspecialchars($d['dari']); ?>" required>
                    </div>
                </div>
                <button type="button" class="swap" id="swap" aria-label="Tukar asal dan tujuan">⇄</button>
                <div>
                    <label for="tujuan">Tujuan</label>
                    <div class="field">
                        <span class="ic">📍</span>
                        <input type="text" name="tujuan" id="tujuan" maxlength="100" placeholder="Contoh: Yogyakarta" value="<?= htmlspecialchars($d['tujuan']); ?>" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="step">
            <h2>Penumpang dan kursi</h2>
            <p>Isi jumlah penumpang dan nomor kursi yang dipilih.</p>
            <div class="row2">
                <div>
                    <label for="jlh">Jumlah penumpang</label>
                    <div class="stepper">
                        <button type="button" id="minus" aria-label="Kurangi">−</button>
                        <input type="text" name="jlh_penumpang" id="jlh" inputmode="numeric" maxlength="30" value="<?= htmlspecialchars($d['jlh_penumpang']); ?>" required>
                        <button type="button" id="plus" aria-label="Tambah">+</button>
                    </div>
                </div>
                <div>
                    <label for="kursi">Nomor kursi</label>
                    <div class="field">
                        <span class="ic">💺</span>
                        <input type="text" name="no_kursi" id="kursi" maxlength="20" placeholder="Contoh: 12A" value="<?= htmlspecialchars($d['no_kursi']); ?>" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="step">
            <h2>Total harga</h2>
            <p>Masukkan harga tiket dalam rupiah, tanpa titik.</p>
            <label for="harga">Harga</label>
            <div class="price">
                <b>Rp</b>
                <input type="text" name="harga" id="harga" inputmode="numeric" maxlength="20" placeholder="0" value="<?= htmlspecialchars($d['harga']); ?>" required>
            </div>
        </div>
    </form>

    <aside class="side">
        <div class="ticket">
            <div class="t-top">
                <small>Ringkasan tiket</small>
                <div class="t-route">
                    <div><strong id="sDari">Asal</strong></div>
                    <span>→</span>
                    <div><strong id="sTujuan">Tujuan</strong></div>
                </div>
            </div>
            <div class="t-cut"></div>
            <div class="t-body">
                <div class="t-line"><span>Kode pesanan</span><b id="sId">-</b></div>
                <div class="t-line"><span>Pelanggan</span><b id="sPel">-</b></div>
                <div class="t-line"><span>Penumpang</span><b id="sJlh">-</b></div>
                <div class="t-line"><span>Nomor kursi</span><b id="sKursi">-</b></div>
            </div>
            <div class="t-total"><span>Total harga</span><b id="sHarga">Rp 0</b></div>
            <div class="t-act">
                <button type="submit" form="formPesan" class="btn">Simpan perubahan</button>
                <a href="pesantiket.php" class="cancel">Batal</a>
            </div>
        </div>
    </aside>

</div>

<script>
const $ = id => document.getElementById(id);
const digits = s => String(s).replace(/\D/g, '');
const rp = s => { const n = digits(s); return n ? 'Rp ' + Number(n).toLocaleString('id-ID') : 'Rp 0'; };
const show = (el, v, fallback) => { el.textContent = v && v.trim() ? v : fallback; };

function update() {
    show($('sDari'),   $('dari').value,   'Asal');
    show($('sTujuan'), $('tujuan').value, 'Tujuan');
    const sel = $('id_pel');
    show($('sPel'), sel.value ? sel.options[sel.selectedIndex].text.split(' - ').slice(1).join(' - ') : '', '-');
    show($('sJlh'),   $('jlh').value ? $('jlh').value + ' orang' : '', '-');
    show($('sKursi'), $('kursi').value, '-');
    show($('sId'),    $('idpesan').value, '-');
    const h = $('harga').value;
    $('sHarga').textContent = /^[\d.\s]*$/.test(h) || /^Rp/i.test(h) ? rp(h) : h;
}

$('harga').addEventListener('input', function () {
    // hanya angka supaya tersimpan rapi di database
    this.value = digits(this.value);
    update();
});

$('swap').addEventListener('click', function () {
    const t = $('dari').value; $('dari').value = $('tujuan').value; $('tujuan').value = t; update();
});

function step(d) {
    let n = parseInt($('jlh').value, 10); if (isNaN(n)) n = 1;
    $('jlh').value = Math.max(1, Math.min(99, n + d)); update();
}
$('minus').addEventListener('click', () => step(-1));
$('plus').addEventListener('click',  () => step(1));

document.querySelectorAll('input, select').forEach(el => {
    el.addEventListener('input', update); el.addEventListener('change', update);
});

update();
</script>

</body>
</html>