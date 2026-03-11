
 
<?php $__env->startSection("content"); ?>
<div class="card mt-10 mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h5>Form Tambah Data Pengguna</h5>
    </div>
    <div class="card-body">
        <a href="<?php echo e(route('folder_user.page_user')); ?>" class="btn btn-info btn-sm mb-2 text-light"><i class="fa fa-arrow-left"></i> Kembali</a>
 
        <form action="/SuperAdmin/User/Create" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row justify-content-center align-items-center">
                <div class="col-md-5  border  border-2 border-success  bg-success-subtle rounded p-4">
                    <div class="row">
                        <div class="form-group mb-2  col-md-12">
                            <label class="font-weight-bold">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-lg m-1 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Nama Lengkap"
                                name="name" value="<?php echo e(old('name')); ?>">
                            <!-- tampilkan pesan error -->
                            <?php $__errorArgs = ['name'];
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
                        <div class="form-group mb-2  col-md-12">
                            <label class="font-weight-bold">Akun</label>
                            <input type="text" class="form-control form-control-lg m-1 <?php $__errorArgs = ['akun'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Akun"
                                name="akun" value="<?php echo e(old('akun')); ?>">
                            <!-- tampilkan pesan error -->
                            <?php $__errorArgs = ['akun'];
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
                        <div class="form-group mb-2  col-md-12">
                            <label class="font-weight-bold">Email</label>
                            <input type="text" class="form-control form-control-lg m-1 <?php $__errorArgs = ['emaill'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Email"
                                name="emaill" value="<?php echo e(old('emaill')); ?>" id="">
                            <!-- tampilkan pesan error -->
                            <?php $__errorArgs = ['emaill'];
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
                        <div class="form-group mb-2  col-md-12">
                            <label class="font-weight-bold">Password</label>
                            <input type="text" class="form-control form-control-lg m-1 <?php $__errorArgs = ['passwordd'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Password"
                                name="passwordd" value="<?php echo e(old('passwordd')); ?>" id="">
                            <!-- tampilkan pesan error -->
                            <?php $__errorArgs = ['passwordd'];
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
                        <div class="form-group mb-2  col-md-12">
                            <label class="font-weight-bold">Wilayah</label>
                            <input type="text" class="form-control form-control-lg m-1 <?php $__errorArgs = ['wilayah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Wilayah"
                                name="wilayah" value="<?php echo e(old('wilayah')); ?>">
                            <!-- tampilkan pesan error -->
                            <?php $__errorArgs = ['wilayah'];
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
                        
                        <div class="form-group mb-3  col-md-12">
                            <label class="font-weight-bold">Akses</label>
                            <select class="form-select form-select-lg m-1 <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" aria-label="Small select example"  name="role">
                                <option value="">Pilih Akses</option>
                                <?php if($roleuserlogin == "Super Admin" ): ?>
                                    <option value="Driver">Driver</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Super Admin">Super Admin</option>
                                <?php else: ?>
                                    <option value="Driver">Driver</option>
                                    <option value="Admin">Admin</option>
                                <?php endif; ?>
                            
                            </select>
                            <!-- tampilkan pesan error -->
                            <?php $__errorArgs = ['role'];
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
                <div class="col-md-5 d-flex">
                    <button type="reset" class="btn btn-md btn-secondary me-3 mt-2" style="height: 50px">CLEAR</button>
                    <button type="submit" class="btn btn-md btn-success me-3 mt-2" style="height: 50px">SIMPAN</button>
                </div>
            </div>
           
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECT\LARAVEL\padepokan_store\resources\views/folder_user/create.blade.php ENDPATH**/ ?>