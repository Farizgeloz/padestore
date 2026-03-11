

 
<?php $__env->startSection("content"); ?>
<div class="card mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h4>Form Edit Data Kotak</h4>
    </div>
    <div class="card-body">
        <?php if($roleuserlogin == "Super Admin" ): ?>
        <a href="/SuperAdmin/Kotak" class="btn btn-info btn-l mb-3 text-white"><i class="fa fa-arrow-left"></i> Kembali</a>
        
        <form action="/SuperAdmin/Kotak/Update/<?php echo e($kotakku->id_kotak); ?>" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2"
            enctype="multipart/form-data">
    
        <?php elseif($roleuserlogin == "Admin" ): ?>
        <a href="/Admin/Kotak" class="btn btn-info btn-l mb-3 text-white"><i class="fa fa-arrow-left"></i> Kembali</a>
        
        <form action="/Admin/Kotak/Update/<?php echo e($kotakku->id_kotak); ?>" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success rounded p-2"
            enctype="multipart/form-data">
        <?php endif; ?>
        
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="col-md-5">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Nomor Kotak</label>
                        <input type="number" class="form-control form-control-lg m-1 <?php $__errorArgs = ['nomor_kotak'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Nomor Kotak"
                            name="nomor_kotak" value="<?php echo e(old('nomor_kotak', $kotakku->nomor_kotak)); ?>" id="">
                        <!-- tampilkan pesan error -->
                        <?php $__errorArgs = ['nomor_kotak'];
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
            <div class="col-md-10">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Deskripsi</label>
                        <textarea name="deskripsi"
                            class="form-control form-control-lg m-1 <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="3"
                            placeholder="masukkan deskripsi"><?php echo e(old('deskripsi', $kotakku->deskripsi)); ?></textarea>
                        <!-- tampilkan pesan error -->
                        <?php $__errorArgs = ['deskripsi'];
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
                <button type="submit" class="btn btn-l btn-success me-3">Update</button>
                <button type="reset" class="btn btn-l btn-secondary me-3">Reset</button>
             </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECT\LARAVEL\pabrik_tahu\resources\views/folder_kotak/edit.blade.php ENDPATH**/ ?>