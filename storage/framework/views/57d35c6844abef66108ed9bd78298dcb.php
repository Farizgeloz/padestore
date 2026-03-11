<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo e($judul); ?></title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #4CAF50; color: white; }
        .judul { background-color: #E6EE9C; font-weight: bold; text-align: center; padding: 10px; font-size: 16px; }
        .section-title { font-weight: bold; text-align: left; padding: 5px; background-color: #BBDEFB; }
        .total { background-color: #C8E6C9; font-weight: bold; }
    </style>
</head>
<body>
    <div class="judul"><?php echo e($judul); ?></div>

    <?php if($harian->count()): ?>
        <div class="section-title">--- PER HARI ---</div>
        <table>
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Total Pemasukan</th>
                    <th>Total Pengeluaran</th>
                    <th>Laba (Pemasukan - Pengeluaran)</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $harian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($row['periode']); ?></td>
                        <td><?php echo e(number_format($row['total_pemasukan'])); ?></td>
                        <td><?php echo e(number_format($row['total_pengeluaran'])); ?></td>
                        <td><?php echo e(number_format($row['laba'])); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php if($bulanan->count()): ?>
        <div class="section-title">--- PER BULAN ---</div>
        <table>
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Total Pemasukan</th>
                    <th>Total Pengeluaran</th>
                    <th>Laba (Pemasukan - Pengeluaran)</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $bulanan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($row['periode']); ?></td>
                        <td><?php echo e(number_format($row['total_pemasukan'])); ?></td>
                        <td><?php echo e(number_format($row['total_pengeluaran'])); ?></td>
                        <td><?php echo e(number_format($row['laba'])); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php if($tahunan->count()): ?>
        <div class="section-title">--- PER TAHUN ---</div>
        <table>
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Total Pemasukan</th>
                    <th>Total Pengeluaran</th>
                    <th>Laba (Pemasukan - Pengeluaran)</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $tahunan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($row['periode']); ?></td>
                        <td><?php echo e(number_format($row['total_pemasukan'])); ?></td>
                        <td><?php echo e(number_format($row['total_pengeluaran'])); ?></td>
                        <td><?php echo e(number_format($row['laba'])); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>

    <table>
        <tbody>
            <tr class="total">
                <td>TOTAL KESELURUHAN</td>
                <td><?php echo e(number_format($totalPemasukan)); ?></td>
                <td><?php echo e(number_format($totalPengeluaran)); ?></td>
                <td><?php echo e(number_format($totalLaba)); ?></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH D:\PROJECT\LARAVEL\padepokan_store\resources\views/pdf/laba_full.blade.php ENDPATH**/ ?>