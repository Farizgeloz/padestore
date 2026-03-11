
 
<?php $__env->startSection("content"); ?>
<div class="card mt-10 mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h5>Form Tambah Pesanan Pengiriman</h5>
    </div>
    <div class="card-body">
        <?php if($roleuserlogin == "Super Admin" ): ?>
        <a href="/SuperAdmin/PesananDeilver" class="btn btn-info btn-sm mb-2 text-light"><i class="fa fa-arrow-left"></i> Kembali</a>
    
        <?php elseif($roleuserlogin == "Admin" ): ?>
        <a href="/Admin/PesananDeilver" class="btn btn-info btn-sm mb-2 text-light"><i class="fa fa-arrow-left"></i> Kembali</a>
        <?php endif; ?>
       
        <?php if(session('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        <form action="<?php echo e(route('folder_pesanan_deliver.store')); ?>" method="post" enctype="multipart/form-data" class="row border  border-2 border-success rounded p-2">
            <?php echo csrf_field(); ?>
            
            
            
            
            <div class="col-md-6">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Jenis</label>
                        <select class="form-select form-select-l m-1 <?php $__errorArgs = ['jenis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" aria-label="Small select example"  name="jenis" id="">
                            <option  value="">Pilih Jenis</option>
                            <option value="Tahu Besar">Tahu Besar</option>
                            <option value="Tahu Kecil">Tahu Kecil</option>
                            <option value="Tahu Timur">Tahu Timur</option>
                        </select>
                        <!-- tampilkan pesan error -->
                        <?php $__errorArgs = ['jenis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert alert-danger mt-2">
                                <?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Pengantar</label>
                        <select class="form-select form-select-l m-1 <?php $__errorArgs = ['pengantar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" aria-label="Small select example"  name="pengantar" id="">
                            <option  value="">Pilih Pengantar</option>
                            <?php $__currentLoopData = $pengantarku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pengantar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($pengantar->id); ?>"><?php echo e($pengantar->akun); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           
                           
                        </select>
                        <!-- tampilkan pesan error -->
                        <?php $__errorArgs = ['pengantar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert alert-danger mt-2">
                                <?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Nomor Kotak</label>
                        <div class="d-flex flex-wrap gap-2">
                            <?php $__currentLoopData = $kotakku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kotak): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-check form-check-inline m-2 align-items-center">
                                    <input 
                                        class="form-check-input me-1 <?php echo e($kotak->status === 'Keluar' ? 'border-danger bg-danger-subtle' : 'border-success bg-success-subtle'); ?>"
                                        type="checkbox"
                                        name="kotak[]"
                                        id="kotak_<?php echo e($kotak->id_kotak); ?>"
                                        value="<?php echo e($kotak->id_kotak); ?>"
                                        style="width: 22px; height: 22px; cursor: pointer;"
                                        <?php echo e($kotak->status === 'Keluar' ? 'disabled' : ''); ?>>

                                    <label 
                                        class="form-check-label fw-semibold <?php echo e($kotak->status === 'Keluar' ? 'text-danger' : 'text-dark'); ?>" 
                                        for="kotak_<?php echo e($kotak->id_kotak); ?>"
                                        style="font-size: 1.1rem; cursor: pointer;"
                                        <?php if($kotak->status === 'Keluar'): ?>
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Kotak ini sedang di luar (tidak tersedia)"
                                        <?php endif; ?>
                                    >
                                        <?php echo e($kotak->nomor_kotak); ?>

                                    </label>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




                        </div>

                        <!-- tampilkan pesan error -->
                        <?php $__errorArgs = ['kotak'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert alert-danger mt-2">
                                <?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    
                </div>
            </div>
            
            
            
            
                   
            <div class="col-md-12 d-flex flex-row-reverse">
             <button type="submit" class="btn btn-md btn-success me-3">SIMPAN</button>
                <button type="reset" class="btn btn-md btn-secondary me-3">CLEAR</button>
            </div>
            
           
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECT\LARAVEL\pabrik_tahu\resources\views/folder_pesanan_deliver/create.blade.php ENDPATH**/ ?>