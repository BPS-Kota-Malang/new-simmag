<!-- resources/views/pdf/attendance.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Attendance Report</h2>
    <p><strong>Intern:</strong> {{ $intern->name }}</p>
    <p><strong>Date Range:</strong> {{ $start_date }} to {{ $end_date }}</p>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Check-In Time</th>
                <th>Check-Out Time</th>
                <th>Work Hours</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->date }}</td>
                    <td>{{ $attendance->check_in }}</td>
                    <td>{{ $attendance->check_out }}</td>
                    <td>{{ $attendance->workhours }}</td>
                    <td>{{ $attendance->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
