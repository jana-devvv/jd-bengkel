<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 20px;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header img {
            height: 60px;
        }
        .header-info {
            text-align: left;
        }
        .header-info h1 {
            margin: 0;
            font-size: 1.5em;
        }
        .header-info p {
            margin: 2px 0;
            font-size: 0.9em;
        }
        .transaction-info, .footer {
            margin-top: 20px;
        }
        .transaction-info p {
            margin: 2px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
            font-size: 0.9em;
        }
        .table-header {
            background-color: #f2f2f2;
        }
        .total-section {
            text-align: right;
            margin-top: 20px;
        }
        .total-section p {
            margin: 5px 0;
            font-size: 1.1em;
        }
        .signature, .thank-you {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>
<body>
    
    <div class="header">
        <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo">
        <div class="header-info">
            <h1>JD Bengkel</h1>
            <p>Address: Jln. Suka Coding RT 001 RW 010, Kecamatan Javascript, Kabupaten PHP, Indonesia</p>
            <p>Telephone: (021) 123-4567</p>
            <p>Email: info@jdbengkel.com</p>
            <p>Printed at: <?= date('d-m-Y') ?></p>
        </div>
    </div>

    <div class="transaction-info">
        <p><strong>Name Customer:</strong> <?= $sales->customer_name ?></p>
        <p><strong>Date Transaction:</strong> <?= $sales->sale_date ?></p>
    </div>

    <table>
        <thead>
            <tr class="table-header">
                <th>No.</th>
                <th>Type</th>
                <th>Name</th>
                <th>Price (Rp)</th>
                <th>Quantity</th>
                <th>Subtotal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($sales_detail as $data): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $data->id_service ? "Service" : "Item" ?></td>
                    <td><?= $data->id_service ? $data->service_name : $data->item_name ?></td>
                    <td><?= $data->id_service ? number_format($data->service_price, 0, ',','.') : number_format($data->item_price, 0, ',','.') ?></td>
                    <td><?= $data->amount ?></td>
                    <td><?= number_format($data->subtotal, 0, ',','.') ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <div class="total-section">
        <p><strong>Total:</strong> Rp. <?= number_format($sales->sale_total, 0, ',','.') ?></p>
    </div>

    <div class="thank-you">
        <p>Thank you for trusting our services. We look forward to serving you again!</p>
    </div>

    <div class="signature">
        <p>________________________</p>
        <p><strong>JD Bengkel</strong></p>
    </div>
    
</body>
</html>