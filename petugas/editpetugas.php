<?php
include '../koneksi/koneksi.php';

if (!isset($_GET['id']) || $_GET['id'] === '') {
    die("ID petugas tidak ditemukan.");
}

$id = $_GET['id'];

$stmt = mysqli_prepare($koneksi, "SELECT * FROM petugas WHERE id = ?");
mysqli_stmt_bind_param($stmt, "s", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data petugas tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ubah Data Petugas</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 25px;
            background:
                linear-gradient(
                    135deg,
                    rgba(9, 24, 52, 0.88),
                    rgba(30, 64, 125, 0.76)
                ),
                url("poto2.jpg") center/cover fixed no-repeat;
        }

        .container {
            width: 100%;
            max-width: 540px;
            background: rgba(255, 255, 255, 0.97);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.28);
            animation: muncul 0.5s ease;
        }

        @keyframes muncul {
            from {
                opacity: 0;
                transform: translateY(18px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: linear-gradient(135deg, #10264d, #2563eb);
            padding: 30px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .header::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            right: -35px;
            top: -65px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.09);
        }

        .header-icon {
            width: 52px;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            font-size: 27px;
            margin-bottom: 17px;
        }

        .header h2 {
            font-size: 25px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .header p {
            font-size: 13px;
            color: #dbeafe;
            line-height: 1.6;
        }

        .form-body {
            padding: 30px;
        }

        .info {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 13px 15px;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 12px;
            margin-bottom: 25px;
            color: #1d4ed8;
            font-size: 13px;
            line-height: 1.5;
        }

        .field {
            margin-bottom: 21px;
        }

        .field label {
            display: block;
            font-size: 13px;
            font-weight: 650;
            color: #334155;
            margin-bottom: 9px;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 17px;
            pointer-events: none;
        }

        .field input,
        .field textarea {
            width: 100%;
            padding: 13px 15px 13px 45px;
            border: 1px solid #dbe2ea;
            border-radius: 11px;
            background: #f8fafc;
            color: #1e293b;
            font-size: 14px;
            outline: none;
            transition: all 0.25s ease;
        }

        .field input:focus,
        .field textarea:focus {
            background: #fff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12);
        }

        .field input:disabled {
            background: #edf2f7;
            color: #64748b;
            cursor: not-allowed;
        }

        .field textarea {
            min-height: 95px;
            resize: vertical;
            line-height: 1.6;
        }

        .textarea-wrap .input-icon {
            top: 15px;
            transform: none;
        }

        .field small {
            display: block;
            margin-top: 7px;
            font-size: 11px;
            color: #94a3b8;
        }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 28px;
            padding-top: 23px;
            border-top: 1px solid #edf0f4;
        }

        .btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 13px 12px;
            border-radius: 11px;
            font-size: 13px;
            font-weight: 650;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .btn-back {
            color: #475569;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
        }

        .btn-back:hover {
            background: #e2e8f0;
            transform: translateY(-2px);
        }

        .btn-save {
            color: white;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            box-shadow: 0 5px 14px rgba(37, 99, 235, 0.22);
        }

        .btn-save:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.3);
            transform: translateY(-2px);
        }

        .footer {
            text-align: center;
            padding: 15px;
            background: #f8fafc;
            border-top: 1px solid #edf0f4;
            color: #94a3b8;
            font-size: 11px;
        }

        @media (max-width: 480px) {
            body {
                padding: 15px;
                background-attachment: scroll;
            }

            .header {
                padding: 24px;
            }

            .header h2 {
                font-size: 22px;
            }

            .form-body {
                padding: 22px;
            }

            .actions {
                flex-direction: column-reverse;
            }

            .btn {
                width: 100%;
                padding: 14px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div class="header-icon">👨‍💼</div>
        <h2>Ubah Data Petugas</h2>
        <p>Perbarui informasi petugas dengan mudah, praktis, dan pastikan data yang dimasukkan sudah benar.</p>
    </div>

    <div class="form-body">

        <div class="info">
            <span>ℹ️</span>
            <span>Periksa kembali informasi petugas sebelum menyimpan perubahan.</span>
        </div>

        <form action="prosesubah.php" method="POST">

            <input type="hidden" name="id"
                   value="<?= htmlspecialchars($data['id'], ENT_QUOTES, 'UTF-8'); ?>">

            <div class="field">
                <label for="id">ID Petugas</label>
                <div class="input-wrap">
                    <span class="input-icon">🆔</span>
                    <input type="text" id="id"
                           value="<?= htmlspecialchars($data['id'], ENT_QUOTES, 'UTF-8'); ?>"
                           disabled>
                </div>
                <small>ID petugas tidak dapat diubah.</small>
            </div>

            <div class="field">
                <label for="nik">NIK</label>
                <div class="input-wrap">
                    <span class="input-icon">🪪</span>
                    <input type="text" id="nik"
                           name="nik"
                           placeholder="Masukkan NIK petugas"
                           value="<?= htmlspecialchars($data['nik'], ENT_QUOTES, 'UTF-8'); ?>"
                           maxlength="16"
                           inputmode="numeric"
                           pattern="[0-9]{16}"
                           title="NIK harus terdiri dari 16 angka"
                           required>
                </div>
            </div>

            <div class="field">
                <label for="nama">Nama Lengkap</label>
                <div class="input-wrap">
                    <span class="input-icon">👤</span>
                    <input type="text" id="nama"
                           name="nama"
                           placeholder="Masukkan nama lengkap petugas"
                           value="<?= htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8'); ?>"
                           required>
                </div>
            </div>

            <div class="field">
                <label for="alamat">Alamat</label>
                <div class="input-wrap textarea-wrap">
                    <span class="input-icon">📍</span>
                    <textarea id="alamat"
                              name="alamat"
                              placeholder="Masukkan alamat lengkap petugas"
                              required><?= htmlspecialchars($data['alamat'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
            </div>

            <div class="field">
                <label for="no_hp">Nomor HP</label>
                <div class="input-wrap">
                    <span class="input-icon">📱</span>
                    <input type="tel" id="no_hp"
                           name="no_hp"
                           placeholder="Contoh: 081234567890"
                           value="<?= htmlspecialchars($data['no_hp'], ENT_QUOTES, 'UTF-8'); ?>"
                           inputmode="tel"
                           required>
                </div>
            </div>

            <div class="actions">
                <a href="../tampilPetugas.php" class="btn btn-back">
                    ← Kembali
                </a>

                <button type="submit" class="btn btn-save">
                    ✓ Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

    <div class="footer">
        Sistem Informasi Petugas &bull; Pengelolaan Data
    </div>

</div>

</body>
</html>