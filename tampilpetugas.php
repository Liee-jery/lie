<?php
include 'koneksi/koneksi.php';

// Mengambil data dari database
$query  = "SELECT * FROM petugas ORDER BY id ASC";
$query2 = "SELECT * FROM pelanggan ORDER BY id ASC";
$query3 = "SELECT * FROM kereta ORDER BY id ASC";

// JOIN: gabungkan pesan_tiket dengan pelanggan supaya nama pelanggan tampil
$query4 = "SELECT pt.*, p.nama AS nama_pelanggan
           FROM pesan_tiket pt
           JOIN pelanggan p ON pt.id_pel = p.id
           ORDER BY pt.id_pesan ASC";

$result  = mysqli_query($koneksi, $query);
$result2 = mysqli_query($koneksi, $query2);
$result3 = mysqli_query($koneksi, $query3);
$result4 = mysqli_query($koneksi, $query4);

// Menghitung jumlah data
$totalPetugas = mysqli_num_rows($result);
$totalPelanggan = mysqli_num_rows($result2);
$totalKereta = mysqli_num_rows($result3);
$totalPesan = mysqli_num_rows($result4);

// Mengembalikan pointer hasil query ke awal
mysqli_data_seek($result, 0);
mysqli_data_seek($result2, 0);
mysqli_data_seek($result3, 0);
mysqli_data_seek($result4, 0);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Admin</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

:root {
    --navy: #101a30;
    --navy-light: #1c2b48;
    --blue: #4361ee;
    --blue-light: #eef2ff;
    --text: #202b40;
    --muted: #8993a7;
    --border: #edf0f5;
    --bg: #f5f7fb;
    --green: #0f9f75;
    --red: #e05260;
    --orange: #d97706;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
    scroll-padding-top: 25px;
}

body {
    font-family: 'Inter', Arial, sans-serif;
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
}

button, input {
    font: inherit;
}

.layout {
    min-height: 100vh;
}

/* SIDEBAR */
.sidebar {
    width: 255px;
    background: var(--navy);
    color: white;
    position: fixed;
    inset: 0 auto 0 0;
    padding: 28px 18px;
    display: flex;
    flex-direction: column;
    z-index: 100;
    transition: transform .3s ease;
}

.brand {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0 10px 32px;
    border-bottom: 1px solid rgba(255,255,255,.09);
}

.brand-icon {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #6680ff, #3450d8);
    display: grid;
    place-items: center;
    border-radius: 14px;
    font-size: 23px;
    box-shadow: 0 8px 20px rgba(67,97,238,.3);
}

.brand h2 {
    font-size: 16px;
    letter-spacing: -.4px;
}

.brand p {
    color: #9caac5;
    font-size: 10px;
    margin-top: 5px;
}

.nav-title {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.5px;
    color: #72809c;
    padding: 29px 12px 12px;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 13px;
    text-decoration: none;
    color: #aab5cb;
    padding: 13px 14px;
    border-radius: 11px;
    font-size: 12px;
    font-weight: 500;
    margin-bottom: 5px;
    transition: .2s;
}

.nav-link .nav-icon {
    width: 22px;
    text-align: center;
    font-size: 17px;
}

.nav-link:hover,
.nav-link.active {
    background: linear-gradient(100deg, #354fd0, #293da8);
    color: white;
    box-shadow: 0 5px 15px rgba(20,35,100,.25);
}

.sidebar-bottom {
    margin-top: auto;
    background: rgba(255,255,255,.055);
    border: 1px solid rgba(255,255,255,.08);
    padding: 17px;
    border-radius: 14px;
}

.sidebar-bottom .status {
    display: inline-block;
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #36d399;
    margin-right: 6px;
}

.sidebar-bottom p {
    color: #aab5cb;
    font-size: 11px;
    line-height: 1.8;
}

/* MAIN */
.main {
    margin-left: 255px;
    min-width: 0;
    padding: 30px 35px;
}

.topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    margin-bottom: 34px;
}

.breadcrumb {
    font-size: 11px;
    color: var(--muted);
    margin-bottom: 8px;
}

.breadcrumb span {
    color: var(--blue);
    font-weight: 600;
}

.topbar h1 {
    font-size: 25px;
    letter-spacing: -1px;
    font-weight: 800;
}

.topbar p {
    color: var(--muted);
    font-size: 12px;
    margin-top: 8px;
}

.admin-profile {
    display: flex;
    align-items: center;
    gap: 11px;
    background: white;
    padding: 10px 14px;
    border: 1px solid var(--border);
    border-radius: 13px;
}

.admin-avatar {
    width: 39px;
    height: 39px;
    display: grid;
    place-items: center;
    border-radius: 12px;
    background: var(--blue-light);
    color: var(--blue);
    font-size: 19px;
}

.admin-profile strong {
    display: block;
    font-size: 12px;
}

.admin-profile small {
    display: block;
    color: var(--muted);
    font-size: 10px;
    margin-top: 4px;
}

.menu-toggle {
    display: none;
    border: none;
    background: white;
    border-radius: 9px;
    width: 40px;
    height: 40px;
    font-size: 20px;
    cursor: pointer;
}

/* WELCOME */
.welcome {
    position: relative;
    overflow: hidden;
    padding: 30px 32px;
    border-radius: 20px;
    color: white;
    background: linear-gradient(115deg, #182c55, #344fc2 75%, #6278ed);
    margin-bottom: 27px;
    box-shadow: 0 12px 28px rgba(41,65,150,.12);
}

.welcome::before {
    content: "";
    position: absolute;
    width: 250px;
    height: 250px;
    border: 40px solid rgba(255,255,255,.06);
    border-radius: 50%;
    right: -50px;
    top: -115px;
}

.welcome::after {
    content: "";
    position: absolute;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: rgba(255,255,255,.05);
    right: 160px;
    bottom: -85px;
}

.welcome .eyebrow {
    color: #c8d4ff;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.8px;
    margin-bottom: 13px;
}

.welcome h2 {
    font-size: 24px;
    letter-spacing: -.6px;
    margin-bottom: 10px;
    position: relative;
    z-index: 1;
}

.welcome p {
    max-width: 520px;
    color: #dce4ff;
    font-size: 12px;
    line-height: 1.9;
    position: relative;
    z-index: 1;
}

/* STATISTICS */
.section-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    margin-bottom: 17px;
}

.section-heading h2 {
    font-size: 16px;
    font-weight: 750;
}

.section-heading p {
    font-size: 11px;
    color: var(--muted);
    margin-top: 6px;
}

.stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 18px;
    margin-bottom: 35px;
}

.stat-card {
    background: white;
    padding: 23px;
    border-radius: 16px;
    border: 1px solid var(--border);
    box-shadow: 0 4px 15px rgba(30,45,75,.025);
    transition: transform .2s, box-shadow .2s;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 25px rgba(30,45,75,.07);
}

.stat-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.stat-icon {
    width: 43px;
    height: 43px;
    display: grid;
    place-items: center;
    font-size: 21px;
    border-radius: 13px;
}

.icon-blue {
    color: #4361ee;
    background: #eef2ff;
}

.icon-green {
    color: #0f9f75;
    background: #e6faf2;
}

.icon-orange {
    color: #d97706;
    background: #fff4e5;
}

.stat-label {
    font-size: 11px;
    font-weight: 600;
    color: var(--muted);
}

.stat-number {
    font-size: 31px;
    font-weight: 800;
    letter-spacing: -1px;
    color: var(--text);
}

.stat-desc {
    font-size: 10px;
    color: var(--muted);
    margin-top: 8px;
}

/* TABLE CARDS */
.data-section {
    background: white;
    border: 1px solid var(--border);
    border-radius: 17px;
    margin-bottom: 26px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(30,45,75,.025);
    scroll-margin-top: 25px;
}

.data-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    padding: 23px 24px;
    border-bottom: 1px solid var(--border);
}

.data-title {
    display: flex;
    align-items: center;
    gap: 12px;
}

.data-title-icon {
    width: 42px;
    height: 42px;
    display: grid;
    place-items: center;
    border-radius: 12px;
    font-size: 19px;
    background: #eef2ff;
}

.data-title h2 {
    font-size: 14px;
    font-weight: 750;
}

.data-title p {
    font-size: 10px;
    color: var(--muted);
    margin-top: 5px;
}

.btn-add {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    text-decoration: none;
    background: var(--blue);
    color: white;
    padding: 11px 15px;
    border-radius: 10px;
    font-size: 11px;
    font-weight: 650;
    white-space: nowrap;
    transition: .2s;
}

.btn-add:hover {
    background: #3048d5;
    transform: translateY(-2px);
    box-shadow: 0 5px 13px rgba(67,97,238,.2);
}

.table-tools {
    padding: 17px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.search-box {
    width: 100%;
    max-width: 310px;
    position: relative;
}

.search-box span {
    position: absolute;
    top: 50%;
    left: 13px;
    transform: translateY(-50%);
    color: #9aa4b7;
    pointer-events: none;
}

.search-box input {
    width: 100%;
    padding: 11px 13px 11px 37px;
    border: 1px solid #e6eaf1;
    border-radius: 10px;
    outline: none;
    background: #fafbfe;
    font-size: 11px;
    transition: .2s;
}

.search-box input:focus {
    border-color: #8294ff;
    box-shadow: 0 0 0 3px rgba(67,97,238,.09);
    background: white;
}

.record-count {
    font-size: 10px;
    color: var(--muted);
    white-space: nowrap;
}

.table-wrapper {
    width: 100%;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    white-space: nowrap;
}

thead th {
    padding: 14px 20px;
    background: #f8f9fc;
    color: #7c879c;
    text-align: left;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .35px;
    border-top: 1px solid #f0f2f7;
    border-bottom: 1px solid #edf0f5;
}

tbody td {
    padding: 15px 20px;
    font-size: 11px;
    color: #47546a;
    border-bottom: 1px solid #f0f2f7;
}

tbody tr:last-child td {
    border-bottom: none;
}

tbody tr {
    transition: background .2s;
}

tbody tr:hover td {
    background: #f8faff;
}

.number-cell {
    color: #a0a9b9;
    font-weight: 600;
}

.id-badge {
    display: inline-block;
    padding: 6px 9px;
    border-radius: 7px;
    background: #f0f3ff;
    color: #4056d6;
    font-size: 10px;
    font-weight: 700;
}

.person {
    display: flex;
    align-items: center;
    gap: 10px;
}

.person-avatar {
    width: 33px;
    height: 33px;
    flex-shrink: 0;
    display: grid;
    place-items: center;
    background: #edf1ff;
    color: #4056d6;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 700;
}

.person strong {
    display: block;
    font-size: 11px;
    color: #27344a;
}

.person small {
    display: block;
    margin-top: 4px;
    font-size: 9px;
    color: #9aa4b7;
}

.address-cell {
    max-width: 220px;
    white-space: normal;
    line-height: 1.6;
}

.actions {
    display: flex;
    gap: 7px;
}

.btn-edit,
.btn-delete {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    text-decoration: none;
    padding: 8px 10px;
    border-radius: 8px;
    font-size: 10px;
    font-weight: 650;
    transition: .2s;
}

.btn-edit {
    color: #a66a00;
    background: #fff5df;
}

.btn-edit:hover {
    background: #ffebba;
}

.btn-delete {
    color: #d34150;
    background: #fff0f1;
}

.btn-delete:hover {
    background: #ffdcdf;
}

.empty {
    padding: 32px !important;
    text-align: center;
    color: #98a2b3 !important;
    white-space: normal;
}

.table-footer {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    padding: 15px 24px;
    background: #fcfcfe;
    border-top: 1px solid #f0f2f7;
    color: var(--muted);
    font-size: 10px;
}

.hidden-row {
    display: none;
}

.no-search-result {
    display: none;
}

/* FOOTER */
.footer {
    display: flex;
    justify-content: space-between;
    gap: 15px;
    padding: 22px 0 5px;
    color: #99a2b2;
    font-size: 10px;
}

/* RESPONSIVE */
@media (max-width: 1100px) {
    .main {
        padding: 25px 22px;
    }

    .stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .stat-card {
        padding: 18px;
    }
}

@media (max-width: 800px) {
    .sidebar {
        transform: translateX(-100%);
        box-shadow: 10px 0 35px rgba(0,0,0,.12);
    }

    .sidebar.open {
        transform: translateX(0);
    }

    .main {
        margin-left: 0;
        padding: 22px 18px;
    }

    .menu-toggle {
        display: block;
    }

    .topbar {
        justify-content: flex-start;
    }

    .topbar-left {
        flex: 1;
    }

    .admin-profile {
        padding: 7px;
    }

    .admin-profile > div:last-child {
        display: none;
    }

    .stats {
        grid-template-columns: 1fr;
    }

    .stat-card {
        padding: 20px;
    }
}

@media (max-width: 520px) {
    .main {
        padding: 17px 12px;
    }

    .topbar {
        flex-wrap: wrap;
        margin-bottom: 23px;
    }

    .topbar h1 {
        font-size: 21px;
    }

    .topbar p {
        line-height: 1.7;
    }

    .welcome {
        padding: 24px 20px;
        border-radius: 16px;
    }

    .welcome h2 {
        font-size: 20px;
    }

    .data-header {
        align-items: flex-start;
        padding: 18px 15px;
    }

    .data-title {
        gap: 8px;
    }

    .data-title-icon {
        width: 35px;
        height: 35px;
    }

    .data-title h2 {
        font-size: 12px;
    }

    .btn-add {
        padding: 10px;
        font-size: 10px;
    }

    .table-tools {
        padding: 14px 15px;
        align-items: flex-start;
        flex-direction: column;
    }

    .search-box {
        max-width: none;
    }

    .data-header .btn-add {
        max-width: 130px;
        white-space: normal;
        text-align: center;
    }

    .table-footer {
        padding: 13px 15px;
        flex-wrap: wrap;
    }

    .footer {
        flex-direction: column;
        line-height: 1.7;
    }
}
</style>
</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <div class="brand">
            <div class="brand-icon">🚆</div>
            <div>
                <h2>Railway Admin</h2>
                <p>SYSTEM MANAGEMENT</p>
            </div>
        </div>

        <div class="nav-title">MENU UTAMA</div>

        <a href="#dashboard" class="nav-link active">
            <span class="nav-icon">▦</span>
            Dashboard
        </a>

        <a href="#petugas" class="nav-link">
            <span class="nav-icon">♙</span>
            Data Petugas
        </a>

        <a href="#pelanggan" class="nav-link">
            <span class="nav-icon">♧</span>
            Data Pelanggan
        </a>

        <a href="#kereta" class="nav-link">
            <span class="nav-icon">🚆</span>
            Data Kereta
        </a>

        <a href="tiket/pesantiket.php" class="nav-link">
            <span class="nav-icon">🎫</span>
            Pesan Tiket
        </a>

        <div class="nav-title">INFORMASI</div>

        <a href="#dashboard" class="nav-link">
            <span class="nav-icon">⌂</span>
            Ringkasan Sistem
        </a>

        <div class="sidebar-bottom">
            <p>
                <span class="status"></span>
                Sistem database aktif
            </p>
            <p>Railway Management System</p>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="main" id="dashboard">

        <header class="topbar">

            <button class="menu-toggle" id="menuToggle"
                    aria-label="Buka menu">☰</button>

            <div class="topbar-left">
                <div class="breadcrumb">
                    Home / <span>Dashboard</span>
                </div>
                <h1>Dashboard Overview</h1>
                <p>Kelola seluruh informasi perkeretaapian dalam satu tempat.</p>
            </div>

            <div class="admin-profile">
                <div class="admin-avatar">♙</div>
                <div>
                    <strong>Administrator</strong>
                    <small>Pengelola Sistem</small>
                </div>
            </div>

        </header>

        <!-- WELCOME -->
        <section class="welcome">
            <div class="eyebrow">RAILWAY MANAGEMENT SYSTEM</div>
            <h2>Selamat datang di Dashboard 👋</h2>
            <p>
                Pantau dan kelola data petugas, pelanggan, kereta,
                serta pemesanan tiket dengan tampilan yang lebih praktis,
                terorganisir, dan efisien.
            </p>
        </section>

        <!-- STATISTICS -->
        <section>
            <div class="section-heading">
                <div>
                    <h2>Ringkasan Data</h2>
                    <p>Jumlah data yang tersimpan dalam database.</p>
                </div>
            </div>

            <div class="stats">

                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Total Petugas</span>
                        <div class="stat-icon icon-blue">♙</div>
                    </div>
                    <div class="stat-number">
                        <?= $totalPetugas; ?>
                    </div>
                    <div class="stat-desc">Data petugas terdaftar</div>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Total Pelanggan</span>
                        <div class="stat-icon icon-green">♧</div>
                    </div>
                    <div class="stat-number">
                        <?= $totalPelanggan; ?>
                    </div>
                    <div class="stat-desc">Data pelanggan terdaftar</div>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Total Kereta</span>
                        <div class="stat-icon icon-orange">🚆</div>
                    </div>
                    <div class="stat-number">
                        <?= $totalKereta; ?>
                    </div>
                    <div class="stat-desc">Data kereta tersimpan</div>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Total Pesanan</span>
                        <div class="stat-icon icon-blue">🎫</div>
                    </div>
                    <div class="stat-number">
                        <?= $totalPesan; ?>
                    </div>
                    <div class="stat-desc">Tiket yang sudah dipesan</div>
                </div>

            </div>
        </section>

        <!-- PETUGAS -->
        <section class="data-section" id="petugas">

            <div class="data-header">
                <div class="data-title">
                    <div class="data-title-icon">♙</div>
                    <div>
                        <h2>Data Petugas</h2>
                        <p>Informasi lengkap petugas kereta api.</p>
                    </div>
                </div>

                <a href="petugas/formpetugas.php" class="btn-add">
                    <span>＋</span> Tambah Petugas
                </a>
            </div>

            <div class="table-tools">
            <form action="petugas/prosescaripetugas.php" method="POST">
                <div class="search-box">
                    <span>⌕</span>
                    <input type="search" name="cari" class="table-search"
                           data-target="tablePetugas"
                           placeholder="Cari id, nama...">
                </div>
                </form>
                <div class="record-count">
                    Total <?= $totalPetugas; ?> data
                </div>
            </div>

            <div class="table-wrapper">
                <table id="tablePetugas">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>ID PETUGAS</th>
                            <th>IDENTITAS PETUGAS</th>
                            <th>ALAMAT</th>
                            <th>NO. HP</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $no = 1;
                    if ($totalPetugas > 0):
                        while ($data = mysqli_fetch_assoc($result)):
                    ?>
                        <tr>
                            <td class="number-cell"><?= $no++; ?></td>

                            <td>
                                <span class="id-badge">
                                    <?= htmlspecialchars($data['id']); ?>
                                </span>
                            </td>

                            <td>
                                <div class="person">
                                    <div class="person-avatar">
                                        <?= strtoupper(substr($data['nama'], 0, 1)); ?>
                                    </div>
                                    <div>
                                        <strong>
                                            <?= htmlspecialchars($data['nama']); ?>
                                        </strong>
                                        <small>
                                            NIK: <?= htmlspecialchars($data['nik']); ?>
                                        </small>
                                    </div>
                                </div>
                            </td>

                            <td class="address-cell">
                                <?= htmlspecialchars($data['alamat']); ?>
                            </td>

                            <td><?= htmlspecialchars($data['no_hp']); ?></td>

                            <td>
                                <div class="actions">
                                    <a class="btn-edit"
                                       href="petugas/editPetugas.php?id=<?= urlencode($data['id']); ?>">
                                        ✎ Edit
                                    </a>
                                    <a class="btn-delete"
                                       href="petugas/hapus.php?id=<?= urlencode($data['id']); ?>"
                                       onclick="return confirm('Yakin ingin menghapus data petugas ini?')">
                                        × Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php
                        endwhile;
                    else:
                    ?>
                        <tr>
                            <td colspan="6" class="empty">
                                Belum ada data petugas.
                                Silakan tambahkan data baru.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>

                    <tbody class="no-search-result">
                        <tr>
                            <td colspan="6" class="empty">
                                Data yang dicari tidak ditemukan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <span>Informasi data petugas</span>
                <span>Railway Management System</span>
            </div>

        </section>

        <!-- PELANGGAN -->
        <section class="data-section" id="pelanggan">

            <div class="data-header">
                <div class="data-title">
                    <div class="data-title-icon"
                         style="background:#e6faf2;">♧</div>
                    <div>
                        <h2>Data Pelanggan</h2>
                        <p>Informasi pelanggan yang terdaftar.</p>
                    </div>
                </div>

                <a href="pelanggan/formpelanggan.php" class="btn-add">
                    <span>＋</span> Tambah Pelanggan
                </a>
            </div>

            <div class="table-tools">
                <form action="pelanggan/prosescaripelanggan.php" method="POST">
                <div class="search-box">
                    <span>⌕</span>
                    <input type="search" name="cari" class="table-search"
                           data-target="tablePelanggan"
                           placeholder="Cari id, nama...">
                </div>
                    </form>
                <div class="record-count">
                    Total <?= $totalPelanggan; ?> data
                </div>
            </div>

            <div class="table-wrapper">
                <table id="tablePelanggan">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>ID</th>
                            <th>NAMA PELANGGAN</th>
                            <th>ALAMAT</th>
                            <th>NO. HP</th>
                            <th>EMAIL</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $no = 1;
                    if ($totalPelanggan > 0):
                        while ($data2 = mysqli_fetch_assoc($result2)):
                    ?>
                        <tr>
                            <td class="number-cell"><?= $no++; ?></td>

                            <td>
                                <span class="id-badge">
                                    <?= htmlspecialchars($data2['id']); ?>
                                </span>
                            </td>

                            <td>
                                <div class="person">
                                    <div class="person-avatar"
                                         style="background:#e6faf2;color:#0f9f75;">
                                        <?= strtoupper(substr($data2['nama'], 0, 1)); ?>
                                    </div>
                                    <div>
                                        <strong>
                                            <?= htmlspecialchars($data2['nama']); ?>
                                        </strong>
                                        <small>
                                            NIK: <?= htmlspecialchars($data2['nik']); ?>
                                        </small>
                                    </div>
                                </div>
                            </td>

                            <td class="address-cell">
                                <?= htmlspecialchars($data2['alamat']); ?>
                            </td>

                            <td><?= htmlspecialchars($data2['no_hp']); ?></td>
                            <td><?= htmlspecialchars($data2['email']); ?></td>

                            <td>
                                <div class="actions">
                                    <a class="btn-edit"
                                       href="pelanggan/editpelanggan.php?id=<?= urlencode($data2['id']); ?>">
                                        ✎ Edit
                                    </a>
                                    <a class="btn-delete"
                                       href="pelanggan/hapus2.php?id=<?= urlencode($data2['id']); ?>"
                                       onclick="return confirm('Yakin ingin menghapus data pelanggan ini?')">
                                        × Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php
                        endwhile;
                    else:
                    ?>
                        <tr>
                            <td colspan="7" class="empty">
                                Belum ada data pelanggan.
                                Silakan tambahkan data baru.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>

                    <tbody class="no-search-result">
                        <tr>
                            <td colspan="7" class="empty">
                                Data yang dicari tidak ditemukan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <span>Informasi data pelanggan</span>
                <span>Railway Management System</span>
            </div>

        </section>

        <!-- KERETA -->
        <section class="data-section" id="kereta">

            <div class="data-header">
                <div class="data-title">
                    <div class="data-title-icon"
                         style="background:#fff4e5;">🚆</div>
                    <div>
                        <h2>Data Kereta</h2>
                        <p>Informasi kereta, kelas, dan nomor kursi.</p>
                    </div>
                </div>

                <a href="kereta/formkereta.php" class="btn-add">
                    <span>＋</span> Tambah Kereta
                </a>
            </div>

            <div class="table-tools">
            <form action="kereta/prosescarikereta.php" method="POST">
                <div class="search-box">
                    <span>⌕</span>
                    <input type="search" name="cari" class="table-search"
                           data-target="tableKereta"
                           placeholder="Cari nama kereta, kursi...">
                </div>
                    </form>
                <div class="record-count">
                    Total <?= $totalKereta; ?> data
                </div>
            </div>

            <div class="table-wrapper">
                <table id="tableKereta">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>ID KERETA</th>
                            <th>NAMA KERETA</th>
                            <th>KELAS</th>
                            <th>NO. KURSI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $no = 1;
                    if ($totalKereta > 0):
                        while ($data3 = mysqli_fetch_assoc($result3)):
                    ?>
                        <tr>
                            <td class="number-cell"><?= $no++; ?></td>

                            <td>
                                <span class="id-badge">
                                    <?= htmlspecialchars($data3['id']); ?>
                                </span>
                            </td>

                            <td>
                                <div class="person">
                                    <div class="person-avatar"
                                         style="background:#fff4e5;color:#d97706;">
                                        🚆
                                    </div>
                                    <div>
                                        <strong>
                                            <?= htmlspecialchars($data3['nama_kereta']); ?>
                                        </strong>
                                        <small>Data armada kereta</small>
                                    </div>
                                </div>
                            </td>

                            <td><?= htmlspecialchars($data3['kelas']); ?></td>
                            <td><?= htmlspecialchars($data3['no_kursi']); ?></td>

                            <td>
                                <div class="actions">
                                    <a class="btn-edit"
                                       href="kereta/editkereta.php?id=<?= urlencode($data3['id']); ?>">
                                        ✎ Edit
                                    </a>
                                    <a class="btn-delete"
                                       href="kereta/hapus3.php?id=<?= urlencode($data3['id']); ?>"
                                       onclick="return confirm('Yakin ingin menghapus data kereta ini?')">
                                        × Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php
                        endwhile;
                    else:
                    ?>
                        <tr>
                            <td colspan="6" class="empty">
                                Belum ada data kereta.
                                Silakan tambahkan data baru.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>

                    <tbody class="no-search-result">
                        <tr>
                            <td colspan="6" class="empty">
                                Data yang dicari tidak ditemukan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <span>Informasi data kereta</span>
                <span>Railway Management System</span>
            </div>

        </section>

        <footer class="footer">
            <span>© <?= date('Y'); ?> Railway Management System</span>
            <span>Dashboard Pengelolaan Data</span>
        </footer>

    </main>
</div>

<script>
// Pencarian untuk masing-masing tabel
document.querySelectorAll('.table-search').forEach(function(input) {
    input.addEventListener('input', function() {
        const table = document.getElementById(this.dataset.target);
        const query = this.value.toLowerCase().trim();
        const rows = table.querySelectorAll('tbody:not(.no-search-result) tr');
        const noResult = table.querySelector('.no-search-result');
        let visible = 0;

        rows.forEach(function(row) {
            // Abaikan baris pesan ketika database kosong
            if (row.querySelector('.empty')) {
                row.style.display = query ? 'none' : '';
                return;
            }

            const match = row.textContent.toLowerCase().includes(query);
            row.classList.toggle('hidden-row', !match);

            if (match) {
                visible++;
            }
        });

        noResult.style.display =
            query && visible === 0 ? 'table-row-group' : 'none';
    });
});

// Sidebar untuk perangkat mobile
const sidebar = document.getElementById('sidebar');
const menuToggle = document.getElementById('menuToggle');

menuToggle.addEventListener('click', function() {
    sidebar.classList.toggle('open');
});

document.querySelectorAll('.nav-link').forEach(function(link) {
    link.addEventListener('click', function() {
        document.querySelectorAll('.nav-link').forEach(function(item) {
            item.classList.remove('active');
        });

        this.classList.add('active');
        sidebar.classList.remove('open');
    });
});
</script>

</body>
</html>