
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Data Petugas</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px 15px;

            background:
                linear-gradient(
                    135deg,
                    rgba(15, 23, 42, 0.72),
                    rgba(37, 99, 235, 0.55)
                ),
                url("poto.jpg");

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .container {
            width: 100%;
            max-width: 600px;
            padding: 35px;
            border-radius: 24px;

            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);

            border: 1px solid rgba(255, 255, 255, 0.65);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);

            animation: muncul 0.7s ease;
        }

        @keyframes muncul {
            from {
                opacity: 0;
                transform: translateY(25px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            width: 65px;
            height: 65px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 15px;

            background: linear-gradient(135deg, #2563eb, #7c3aed);
            color: white;
            border-radius: 20px;
            font-size: 30px;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
        }

        .header {
            text-align: center;
            margin-bottom: 28px;
        }

        .header h2 {
            color: #172554;
            font-size: 29px;
            margin-bottom: 8px;
        }

        .header p {
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            color: #334155;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .input-box {
            position: relative;
        }

        .input-box .icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 17px;
            pointer-events: none;
        }

        input,
        textarea {
            width: 100%;
            padding: 13px 14px 13px 43px;
            border: 1.5px solid #dbe3f0;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.85);
            outline: none;
            font-size: 14px;
            color: #1e293b;
            transition: 0.25s;
        }

        input:focus,
        textarea:focus {
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12);
        }

        textarea {
            height: 100px;
            resize: vertical;
            padding-top: 13px;
        }

        .textarea-box .icon {
            top: 17px;
            transform: none;
        }

        .button-row {
            display: flex;
            gap: 12px;
            margin-top: 28px;
        }

        .btn {
            flex: 1;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            padding: 14px 18px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.25s;
        }

        .btn-kembali {
            color: #334155;
            background: #e9eef7;
            border: 1px solid #d8e1ef;
        }

        .btn-kembali:hover {
            background: #dbe5f5;
            transform: translateY(-2px);
        }

        .btn-simpan {
            color: white;
            border: none;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            box-shadow: 0 6px 15px rgba(79, 70, 229, 0.25);
        }

        .btn-simpan:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 22px rgba(79, 70, 229, 0.35);
        }

        .footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 17px;
            border-top: 1px solid #e2e8f0;
            color: #94a3b8;
            font-size: 12px;
        }

        @media (max-width: 480px) {
            .container {
                padding: 25px 20px;
                border-radius: 18px;
            }

            .header h2 {
                font-size: 24px;
            }

            .button-row {
                flex-direction: column-reverse;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="header">
            <div class="logo">👤</div>
            <h2>Data Petugas</h2>
            <p>Silakan lengkapi informasi petugas<br>
               dengan benar dan sesuai data.</p>
        </div>

        <form action="prosespetugas.php" method="POST">

            <div class="form-group">
                <label for="id">ID Petugas</label>
                <div class="input-box">
                    <span class="icon">🆔</span>
                    <input type="text" id="id" name="id"
                        placeholder="Masukkan ID petugas" required>
                </div>
            </div>

            <div class="form-group">
                <label for="nik">NIK</label>
                <div class="input-box">
                    <span class="icon">📇</span>
                    <input type="text" id="nik" name="nik"
                        placeholder="Masukkan NIK" required>
                </div>
            </div>

            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <div class="input-box">
                    <span class="icon">👤</span>
                    <input type="text" id="nama" name="nama"
                        placeholder="Masukkan nama lengkap" required>
                </div>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat Lengkap</label>
                <div class="input-box textarea-box">
                    <span class="icon">📍</span>
                    <textarea id="alamat" name="alamat"
                        placeholder="Masukkan alamat lengkap"
                        required></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="no_hp">Nomor HP</label>
                <div class="input-box">
                    <span class="icon">📱</span>
                    <input type="tel" id="no_hp" name="no_hp"
                        placeholder="Contoh: 081234567890" required>
                </div>
            </div>

            <div class="button-row">
                <a href="index.php" class="btn btn-kembali">
                    ← Kembali
                </a>

                <button type="submit" class="btn btn-simpan">
                    💾 Simpan Data
                </button>
            </div>

        </form>

        <div class="footer">
            Sistem Informasi Petugas · Kelola Data dengan Mudah
        </div>

    </div>

</body>
</html>
