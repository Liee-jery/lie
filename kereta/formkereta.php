
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Data Kereta</title>

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
            background: rgba(255, 255, 255, 0.93);
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
            margin-bottom: 20px;
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

        input {
            width: 100%;
            padding: 14px 14px 14px 44px;
            border: 1.5px solid #dbe3f0;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.9);
            outline: none;
            font-size: 14px;
            color: #1e293b;
            transition: 0.25s;
        }

        input:focus {
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12);
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
            }

            .header h2 {
                font-size: 25px;
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
        <div class="logo">🚆</div>
        <h2>Data Kereta</h2>
        <p>Silakan lengkapi informasi kereta<br>
           dengan benar dan sesuai data.</p>
    </div>

    <form action="proseskereta.php" method="POST">

        <div class="form-group">
            <label for="id">ID Kereta</label>
            <div class="input-box">
                <span class="icon">🆔</span>
                <input type="text" id="id" name="id"
                    placeholder="Masukkan ID kereta" required>
            </div>
        </div>

        <div class="form-group">
            <label for="nama_kereta">Nama Kereta</label>
            <div class="input-box">
                <span class="icon">🚆</span>
                <input type="text" id="nama_kereta" name="nama_kereta"
                    placeholder="Contoh: Argo Parahyangan" required>
            </div>
        </div>

        <div class="form-group">
            <label for="kelas">Kelas Kereta</label>
            <div class="input-box">
                <span class="icon">🎫</span>
                <input type="text" id="kelas" name="kelas"
                    placeholder="Contoh: Ekonomi atau Eksekutif" required>
            </div>
        </div>

        <div class="form-group">
            <label for="no_kursi">Nomor Kursi</label>
            <div class="input-box">
                <span class="icon">💺</span>
                <input type="text" id="no_kursi" name="no_kursi"
                    placeholder="Contoh: A1 atau 01A" required>
            </div>
        </div>

        <div class="button-row">
            <a href="../tampilpetugas.php" class="btn btn-kembali">
                ← Kembali
            </a>

            <button type="submit" class="btn btn-simpan">
                💾 Simpan Data
            </button>
        </div>

    </form>

    <div class="footer">
        Sistem Informasi Kereta · Kelola Data dengan Mudah
    </div>

</div>

</body>
</html>
