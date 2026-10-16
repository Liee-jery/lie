<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kereta</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            /* Background gradasi yang santai, lembut, dan modern */
            background: linear-gradient(135deg, #e0f2fe 0%, #f0fdf4 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
            color: #1e293b;
        }

        .container {
            width: 100%;
            max-width: 900px;
        }

        .header-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        h2 {
            color: #0f172a;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .table-container {
            overflow-x: auto;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }

        .styled-table {
            border-collapse: collapse;
            width: 100%;
            text-align: left;
            font-size: 14px;
        }

        .styled-table th {
            background-color: #3b82f6;
            color: #ffffff;
            padding: 16px 20px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.8px;
        }

        .styled-table th:first-child {
            border-top-left-radius: 16px;
        }

        .styled-table th:last-child {
            border-top-right-radius: 16px;
        }

        .styled-table td {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
        }

        .styled-table tbody tr {
            transition: all 0.2s ease;
        }

        .styled-table tbody tr:hover {
            background-color: rgba(59, 130, 246, 0.04);
            transform: scale(1.002);
        }

        .styled-table tbody tr:last-of-type td {
            border-bottom: none;
        }

        .no-data {
            text-align: center;
            padding: 40px 20px;
            color: #64748b;
            font-style: normal;
            font-weight: 500;
        }

        /* Desain responsif untuk layar kecil */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }
            h2 {
                font-size: 20px;
            }
            .styled-table th, .styled-table td {
                padding: 12px 14px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header-wrapper">
            <h2>Hasil Pencarian Kereta</h2>
        </div>

        <div class="table-container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kereta</th>
                        <th>Kelas</th>
                        <th>No Kursi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "../koneksi/koneksi.php";
                    
                    // Pastikan menggunakan isset agar tidak error jika diakses langsung
                    if (isset($_POST['cari'])) {
                        $a = $_POST['cari'];
                        // Sesuaikan nama tabel ("kereta") dan kolom jika berbeda di database Anda
                        $cari = mysqli_query($koneksi, "SELECT * FROM kereta WHERE id='$a' OR nama_kereta='$a'");
                        
                        // Cek apakah data ditemukan
                        if (mysqli_num_rows($cari) > 0) {
                            while($data2 = mysqli_fetch_array($cari)){
                                echo "
                                <tr>
                                    <td><strong>" . $data2['id'] . "</strong></td>
                                    <td>" . $data2['nama_kereta'] . "</td>
                                    <td>" . $data2['kelas'] . "</td>
                                    <td>" . $data2['no_kursi'] . "</td>
                                </tr>
                                ";
                            }
                        } else {
                            echo '<tr><td colspan="4" class="no-data">Data tidak ditemukan.</td></tr>';
                        }
                    } else {
                        echo '<tr><td colspan="4" class="no-data">Silakan lakukan pencarian terlebih dahulu.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>