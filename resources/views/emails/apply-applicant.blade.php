<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Inline CSS for email */
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .bg-red {
            background-color: #f8d7da;
            padding: 20px;
            border-radius: 8px;
        }
        .text-red {
            color: #721c24;
        }
        .font-bold {
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .mb-4 {
            margin-bottom: 16px;
        }
        .text-lg {
            font-size: 16px;
        }
        .btn-primary {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-align: center;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
        }
        .btn-danger {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff0037;
            color: #ffffff;
            text-align: center;
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
            @if ($apply->intern->work_status == 'on progress')
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-lg text-gray-700 mb-4">
                        Halo {{ $apply->intern->name }}, terima kasih atas minat Anda untuk bergabung dengan tim kami. Kami telah meninjau pengajuan magang Anda.
                    </p>

                    @if ($apply->start_date_answer)
                        <div class="bg-blue-100 p-4 rounded-lg mb-6 text-center">
                            <p class="text-lg font-semibold text-blue-800 mb-2">
                                Namun Mohon Maaf harus kami informasikan Tanggal yang anda ajukan saat ini telah terisi penuh, apakah Anda bersedia merubah magang pada tanggal {{ $apply->start_date_answer }} hingga {{ $apply->end_date_answer }}?
                            </p>
                            <div class="flex justify-center space-x-4">
                                <a href="{{ route('apply.accepted', ['id' => $apply->intern->id]) }}" class="btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Baik, Saya Setuju
                                </a>
                                <a href="{{ route('apply.rejected', ['id' => $apply->intern->id]) }}" class="btn-danger bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Tidak, Saya Tidak Setuju
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="bg-red text-center">
                    <p class="text-lg text-red mb-4">
                        Halo {{ $apply->intern->name }}, kami mohon maaf untuk memberi tahu bahwa pengajuan magang Anda tidak dapat diterima.  Hal ini dikarenakan: {{ $apply->causes }}
                    </p>
                    <p class="text-lg text-red mb-4">
                        Terima kasih atas minat Anda dan kami berharap Anda sukses di masa depan.
                    </p>
                </div>
            @endif
        </div>
        <div class="email-footer">
            <p>&copy; 2024 Badan Pusat Statistik Kota Malang. All rights reserved.</p>
            <p>Jl. Janti Barat No.47, Bandungrejosari, Sukun - Kota Malang</p>
        </div>
    </div>
</body>
</html>
