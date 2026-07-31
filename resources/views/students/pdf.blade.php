<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student List PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            color: #1a252f;
            font-size: 20px;
        }
        .header p {
            margin: 5px 0 0;
            color: #7f8c8d;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #bdc3c7;
            padding: 8px 10px;
            text-align: left;
        }
        table th {
            background-color: #2c3e50;
            color: #ffffff;
            font-weight: bold;
        }
        table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Student Directory Report</h2>
        <p>Generated on {{ \Carbon\Carbon::now()->format('F d, Y h:i A') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 8%;">ID</th>
                <th style="width: 30%;">Name</th>
                <th style="width: 32%;">Email</th>
                <th style="width: 20%;">Course</th>
                <th style="width: 10%;">Age</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->course }}</td>
                    <td>{{ $student->age }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">No student records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Total Students: {{ count($students) }}
    </div>

</body>
</html>
