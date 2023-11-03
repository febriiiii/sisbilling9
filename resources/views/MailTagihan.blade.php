<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tagihan Jatuh Tempo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        p {
            padding: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Reminder Tagihan</h1>
        <p>Terimakasih, {{$trans->nama}}, telah berlangganan produk "{{$trans->productName}}". <br> Berikut detail tagihan Anda:</p>
        <table>
            <tr>
                <th>Email</th>
                <td>{{$trans->email}}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{$trans->nama}}</td>
            </tr>
            <tr>
                <th>Jatuh Tempo Tagihan</th>
                <td>{{$trans->jatuhTempoTagihan}}</td>
            </tr>
            <tr>
                <th>Amount</th>
                <td>{{number_format($trans->Amount, 2, '.', ',')}}</td>
            </tr>
            <tr>
                <th>ProductName</th>
                <td>{{$trans->productName}}</td>
            </tr>
        </table>
        <p>Silakan bayar tagihan sebesar {{number_format($trans->Amount, 2, '.', ',')}} sebelum tanggal jatuh tempo. Terimakasih!</p>
        <br>
        <br>
        <a style="font-size: 1.5em; font-weight:bold;" href="{{url('/')}}">Sis Billing</a>
    </div>
</body>
</html>
