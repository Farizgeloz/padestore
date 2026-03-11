
 
<?php $__env->startSection("content"); ?>
<div class="card mt-10 mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h5>Form Tambah Kotak</h5>
    </div>
    <div class="card-body">
        <?php if($roleuserlogin == "Super Admin" ): ?>
        <a href="/SuperAdmin/Kotak" class="btn btn-info btn-l mb-2 text-light"><i class="fa fa-arrow-left"></i> Kembali</a>
    
        <?php elseif($roleuserlogin == "Admin" ): ?>
        <a href="/Admin/Kotak" class="btn btn-info btn-l mb-2 text-light"><i class="fa fa-arrow-left"></i> Kembali</a>
        <?php endif; ?>
       
 
        <form action="<?php echo e(route('folder_kotak.store')); ?>" method="post" enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2">
            <?php echo csrf_field(); ?>
            <div class="col-md-5">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Nomor Kotak</label>
                        <input type="number" class="form-control form-control-lg  m-1 <?php $__errorArgs = ['nomor_kotak'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Nomor Kotak"
                            name="nomor_kotak" value="<?php echo e(old('nomor_kotak')); ?>" id="">
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
                    <div class="form-group mb-3 col-md-12">
                        <label class="font-weight-bold">Deskripsi</label>
                        <textarea name="deskripsi"
                            class="form-control form-control-lg  m-1 <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="3"
                            placeholder="Deskripsi"><?php echo e(old('deskripsi')); ?></textarea>
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
             <button type="submit" class="btn btn-l btn-success me-3">SIMPAN</button>
                <button type="reset" class="btn btn-l btn-secondary me-3">CLEAR</button>
            </div>
            
           
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECT\LARAVEL\pabrik_tahu\resources\views/folder_kotak/create.blade.php ENDPATH**/ ?>