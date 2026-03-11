
 
<?php $__env->startSection("content"); ?>
<div class="mt-1 mb-5 card bg-body-tertiary">
   
    <div class="bg-white card-header">
        <h4><i class="fa fa-database"></i> Daftar Pemasukan</h4>
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
            <a href="/SuperAdmin/Pemasukan/Tambah" class="mb-3 btn btn-success btn-sm"> <i class="fa fa-plus"></i> Tambah Pemasukan</a>
        
        <?php elseif($roleuserlogin == "Admin" ): ?>
            <a href="/Admin/Pemasukan/Tambah" class="mb-3 btn btn-success btn-sm"> <i class="fa fa-plus"></i> Tambah Pemasukan</a>
        <?php endif; ?>

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
        <div class="table-responsive">
            <table class="table table-striped table-bordered"  style="width:100%">
                <thead class="text-white bg-success textsize9">
                    <tr>
                        <th scope="col" width="50px">No</th>
                        <th scope="col">Pelanggan</th>
                        <th scope="col">Produk</th>
                        <th scope="col">Total Order</th>
                        <th scope="col">Total Qty</th>
                        <th scope="col">Total Harga</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $pemasukanku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pemasukan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="textsize9"><?php echo e($pemasukanku->firstItem() + $loop->index); ?></td>
                       
                        <td class=" textsize9"><?php echo e($pemasukan->nama_pelanggan); ?></td>
                        <td class=" textsize9"><?php echo e($pemasukan->nama_produk); ?></td>
                        <td class=" textsize9"><?php echo e($pemasukan->total_order); ?></td>
                        <td class=" textsize9"><?php echo e($pemasukan->total_qty); ?></td>
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

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex custom-pagination justify-content-end">
            <?php echo e($pemasukanku->links('pagination::bootstrap-5')); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECT\LARAVEL\padepokan_store\resources\views/folder_pemasukan/page_pemasukan.blade.php ENDPATH**/ ?>