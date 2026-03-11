
 
<?php $__env->startSection("content"); ?>
<div class="mt-1 mb-5 card bg-body-tertiary">
   
    <div class="bg-white card-header">
        <h4><i class="fa fa-database"></i> Pesanan Selesai</h4>
    </div>
    
    <div class="card-body">
 
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
       
        <?php if($roleuserlogin == "Super Admin" ): ?>
        <form method="GET" action="/SuperAdmin/Pesanan/Selesai/Search" class="mb-2 row">
        <?php elseif($roleuserlogin == "Admin" ): ?>
        <form method="GET" action="/Admin/Pesanan/Selesai/Search" class="mb-2 row">
        <?php else: ?>
        <form method="GET" action="/Pesanan/Selesai/Search" class="mb-2 row">
        <?php endif; ?>
        
            <div class="input-group row" style="margin-right:5px;">
                <div class="form-outline col-md-10 col-9" data-mdb-input-init>
                    <input class="border border-2 form-control" name="search" placeholder="Pencarian Data..." value="<?php echo e(request()->input('search') ? request()->input('search') : ''); ?>">
                </div>
                <button type="submit" class="rounded btn btn-primary col-md-2 col-3">Cari</button>
            </div>
        </form>
        <div class="table-responsive">
            <form action="<?php echo e(route('folder_pesanan_selesai.update_multiple')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <table class="table table-striped table-bordered" style="width:100%">
                    <thead class="text-white bg-success textsize9">
                        <tr>
                            <th width="30px" class="text-center">
                                <input type="checkbox" id="select-all" />
                            </th>
                            <th scope="col" width="50px">ID</th>
                            <th scope="col">Pelanggan</th>
                            <th scope="col">Jenis</th>
                            <th scope="col">No Kotak</th>
                            <th scope="col">Pengantar</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $pesananku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pesanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="selected_id[]" value="<?php echo e($pesanan->id_pesanan); ?>" class="row-checkbox" />
                            </td>
                            <td class="textsize9"><?php echo e($pesananku->firstItem() + $loop->index); ?></td>
                            <td class="textsize9"><?php echo e($pesanan->nama_pelanggan); ?></td>
                            <td class="textsize9"><?php echo e($pesanan->jenis); ?></td>
                            <td class="textsize9"><?php echo e($pesanan->nomor_kotak); ?></td>
                            <td class="textsize9"><?php echo e($pesanan->akun); ?></td>
                            <td style="
                                background-color: <?php echo e($pesanan->status === 'PickedUp' ? '#a3730e' :'transparent'); ?>;
                                color: <?php echo e($pesanan->status === 'PickedUp' ? '#fff' : '#999'); ?>;
                            ">
                                <?php echo e($pesanan->status); ?>

                            </td>
                            <td class=" textsize9"><?php echo e(\Carbon\Carbon::parse($pesanan->tanggal)->translatedFormat('d F Y')); ?></td>
                            
                        </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <div class="mt-3">
                    <select name="status_update" class="form-select w-auto d-inline-block">
                        <option value="">-- Ubah Status ke --</option>
                        <option value="Dropsit">Dropsit</option>
                        <option value="PickedUp">PickedUp</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-save"></i> Update Terpilih
                    </button>
                </div>
            </form>
            
            <script>
                document.getElementById('select-all').addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.row-checkbox');
                    checkboxes.forEach(cb => cb.checked = this.checked);
                });
            </script>
        </div>
        <div class="d-flex custom-pagination justify-content-end">
            <?php echo e($pesananku->links('pagination::bootstrap-5')); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECT\LARAVEL\pabrik_tahu\resources\views/folder_pesanan_selesai/page_pesanan_selesai.blade.php ENDPATH**/ ?>