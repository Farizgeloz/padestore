
 
<?php $__env->startSection("content"); ?>
<div class="mt-1 mb-5 card bg-body-tertiary">
   <?php
        $tanggalStr = (string) $tanggal;

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggalStr)) {
            // Format YYYY-MM-DD → Harian
            $formatTanggal = 'd F Y';
        } elseif (preg_match('/^\d{4}-\d{2}$/', $tanggalStr)) {
            // Format YYYY-MM → Bulanan
            $formatTanggal = 'F Y';
            // Tambah "-01" biar bisa diparse oleh Carbon
            $tanggalStr .= '-01';
        } elseif (preg_match('/^\d{4}$/', $tanggalStr)) {
            // Format YYYY → Tahunan
            $formatTanggal = 'Y';
            // Tambah "-01-01" biar valid untuk Carbon
            $tanggalStr .= '-01-01';
        } else {
            $formatTanggal = 'd F Y'; // default
        }
    ?>
    <div class="bg-white card-header">
        <h4><i class="fa fa-database"></i> Detail <?php echo e(\Carbon\Carbon::parse($tanggalStr)->translatedFormat($formatTanggal)); ?></h4>
    </div>
    
    <div class="card-body">
 
        <?php $__sessionArgs = ["success"];
if (session()->has($__sessionArgs[0])) :
if (isset($value)) { $__sessionPrevious[] = $value; }
$value = session()->get($__sessionArgs[0]); ?>
        <div class="alert alert-success"><?php echo e($value); ?></div>
        <?php unset($value);
if (isset($__sessionPrevious) && !empty($__sessionPrevious)) { $value = array_pop($__sessionPrevious); }
if (isset($__sessionPrevious) && empty($__sessionPrevious)) { unset($__sessionPrevious); }
endif;
unset($__sessionArgs); ?>
       

        <?php if($roleuserlogin == "Super Admin" ): ?>
        <form method="GET" action="/SuperAdmin/Pemasukan/Search" class="mb-2 row">
        <?php elseif($roleuserlogin == "Admin" ): ?>
        <form method="GET" action="/Admin/Pemasukan/Search" class="mb-2 row">
        <?php else: ?>
        <form method="GET" action="/Pemasukan/Search" class="mb-2 row">
        <?php endif; ?>
        
            <div class="input-group row" style="margin-right:5px;">
                <div class="form-outline col-md-10 col-9" data-mdb-input-init>
                    <input class="border border-2 form-control" name="search" placeholder="Pencarian Data..." value="<?php echo e(request()->input('search') ? request()->input('search') : ''); ?>">
                </div>
                <button type="submit" class="rounded btn btn-primary col-md-2 col-3">Cari</button>
            </div>
        </form>
        <a href="/SuperAdmin/Rekapitulasi/pdf/<?php echo e($tanggal); ?>" class="btn btn-success btn-sm mb-2">
            <i class="fa fa-file-excel"></i> Rekap ke PDF
        </a>
        <a href="/SuperAdmin/Rekapitulasi/export/<?php echo e($tanggal); ?>" class="btn btn-success btn-sm mb-2">
            <i class="fa fa-file-excel"></i> Rekap ke Excel
        </a>
        <p class="textsize16" style="margin-top: 10px">Total </p>
        <table class="table table-striped table-bordered"  style="width:100%">
            <thead class="text-white bg-success textsize9">
                <tr>
                    <th scope="col">Pemasukan</th>
                    <th scope="col">Pengeluaran</th>
                    <th scope="col">Laba</th>
                </tr>
            </thead>
            <tbody>
                <tr class=" fw-bold ">
                    <td class=""><?php echo e(number_format($totalKeseluruhan->total_pemasukan, 0, ',', '.')); ?></td>
                    <td class=""><?php echo e(number_format($totalKeseluruhan->total_pengeluaran, 0, ',', '.')); ?></td>
                    <td class=""><?php echo e(number_format($totalKeseluruhan->total_laba, 0, ',', '.')); ?></td>
                </tr>
            </tbody>
        </table>
        <p class="textsize16" style="margin-top: 10px">Tabel Pemasukan</p>
       
        <div class="table-responsive">
            <table class="table table-striped table-bordered"  style="width:100%">
                <thead class="text-white bg-success textsize9">
                    <tr>
                        <th scope="col" width="50px">No</th>
                        <th scope="col">Pelanggan</th>
                        <th scope="col">Produk</th>
                        <th scope="col">Total Harga</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $pemasukanku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pemasukan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="textsize9"><?php echo e($pemasukanku->firstItem() + $loop->index); ?></td>
                        
                            <td class=" textsize9"><?php echo e($pemasukan->nama_pelanggan); ?></td>
                            <td class=" textsize9"><?php echo e($pemasukan->nama_produk); ?></td>
                            <td class="textsize9">
                                Rp <?php echo e(number_format($pemasukan->total_harga, 0, ',', '.')); ?>

                            </td>
                            <td class=" textsize9"><?php echo e(\Carbon\Carbon::parse($pemasukan->tanggal)->translatedFormat('d F Y')); ?></td>
                            <td style="
                                color: <?php echo e($pemasukan->status === 'Dropsit' ? '#c97204' : '#0ea314'); ?>;
                            ">
                                <?php echo e($pemasukan->status); ?>

                            </td>
                            
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted textsize9">
                                TIDAK ADA DATA PEMASUKAN
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex custom-pagination justify-content-end">
            <?php echo e($pemasukanku->links('pagination::bootstrap-5')); ?>

        </div>
        <p class="textsize16" style="margin-top: 10px">Tabel Pengeluaran</p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered"  style="width:100%">
                <thead class="text-white bg-success textsize9">
                    <tr>
                        <th scope="col" width="50px">No</th>
                        <th scope="col">Pengeluaran</th>
                        <th scope="col">Nominal</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $pengeluaranku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pengeluaran): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="textsize9"><?php echo e($pengeluaranku->firstItem() + $loop->index); ?></td>
                            <td class="textsize9"><?php echo e($pengeluaran->nama_pengeluaran); ?></td>
                            <td class="textsize9">
                                Rp <?php echo e(number_format($pengeluaran->nominal, 0, ',', '.')); ?>

                            </td>
                            <td class="textsize9">
                                <?php echo e(\Carbon\Carbon::parse($pengeluaran->tanggal)->translatedFormat('d F Y')); ?>

                            </td>
                            <td style="
                                color: <?php echo e($pengeluaran->validasi === 'Valid' ? '#c97204' : '#0ea314'); ?>;
                            ">
                                <?php echo e($pengeluaran->validasi); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted textsize9">
                                TIDAK ADA DATA PENGELUARAN
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex custom-pagination justify-content-end">
            <?php echo e($pemasukanku->links('pagination::bootstrap-5')); ?>

        </div>
        
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECT\LARAVEL\padepokan_store\resources\views/folder_rekapitulasi/page_detail.blade.php ENDPATH**/ ?>