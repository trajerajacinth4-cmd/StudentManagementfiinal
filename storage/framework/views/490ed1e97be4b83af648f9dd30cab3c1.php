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
        <p>Generated on <?php echo e(\Carbon\Carbon::now()->format('F d, Y h:i A')); ?></p>
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
            <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($student->id); ?></td>
                    <td><?php echo e($student->name); ?></td>
                    <td><?php echo e($student->email); ?></td>
                    <td><?php echo e($student->course); ?></td>
                    <td><?php echo e($student->age); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" style="text-align: center;">No student records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        Total Students: <?php echo e(count($students)); ?>

    </div>

</body>
</html>
<?php /**PATH C:\laragon\www\StudentManagement\resources\views/students/pdf.blade.php ENDPATH**/ ?>