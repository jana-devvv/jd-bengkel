<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 80px;
            height: auto;
        }
        .header h1 {
            margin: 10px 0 5px;
            font-size: 22px;
            color: #333;
        }
        .header p {
            margin: 2px 0;
            font-size: 14px;
            color: #666;
        }
        h2 {
            text-align: center;
            margin: 20px 0;
            font-size: 18px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .footer {
            text-align: right;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo">
            <h1>JD Bengkel</h1>
            <p>Jln. Suka Coding RT 001 RW 010, Kecamatan Javascript, Kabupaten PHP, Indonesia</p>
            <p>Telepon: (021) 123-4567 | Email: info@jdbengkel.com</p>
        </div>

        <h2>Data Item POS Bengkel</h2>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Purchase (Rp)</th>
                    <th>Selling (Rp)</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach($items as $item): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $item->name ?></td>
                        <td><?= $item->category ?></td>
                        <td><?= $item->stock ?></td>
                        <td><?= number_format($item->purchase_price, 0, ',','.') ?></td>
                        <td><?= number_format($item->selling_price, 0, ',','.') ?></td>
                        <td><?= $item->date_in ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <div class="footer">
            <p>Dicetak pada : <?= date('d-m-Y') ?></p>
        </div>
    </div>
    
</body>
</html>