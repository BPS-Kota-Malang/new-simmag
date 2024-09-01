<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Confirmation</title>
    <style>
        /* Fallback styles for email clients that support embedded CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #007BFF;
            padding: 20px;
            text-align: center;
            color: #ffffff;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
            line-height: 1.6;
        }
        .email-body p {
            margin: 0 0 20px;
        }
        .email-footer {
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #999999;
        }
        .email-footer a {
            color: #007BFF;
            text-decoration: none;
        }
        .btn-primary {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Terima Kasih Telah Mendaftar!</h1>
        </div>
        <div class="email-body">
            <p>Halo, {{ $intern->name }}</p>
            <p>Terima kasih telah mendaftar untuk mengikuti program kami. Pendaftaran Anda telah kami terima dan sedang dalam proses verifikasi.</p>
            <p>Untuk mengakses akun Anda dan melihat status pendaftaran, silakan klik tombol di bawah ini:</p>
            <a href="{{ route('login') }}" class="btn-primary">Login ke Akun Anda</a>
            <p>Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi kami.</p>
        </div>
        <div class="email-footer">
            <p>&copy; 2024 Badan Pusat Statistik Kota Malang. All rights reserved.</p>
            <p>Alamat Anda, Kota, Negara</p>
        </div>
    </div>
</body>
</html>
