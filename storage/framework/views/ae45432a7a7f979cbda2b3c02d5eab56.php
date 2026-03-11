

 
<?php $__env->startSection("content"); ?>
<div class="card mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h4>Form Edit Data Pengguna</h4>
    </div>
    <div class="card-body">
        <?php if($roleuserlogin == "Super Admin"): ?>
        <a href="/SuperAdmin/User" class="btn btn-info btn-sm mb-3"><i class="fa fa-arrow-left"></i> Kembali</a>
        <form action="/SuperAdmin/User/<?php echo e($userku->id); ?>/Update" method="POST"  enctype="multipart/form-data" class=""
            enctype="multipart/form-data">
        <?php elseif($roleuserlogin == "Admin" ): ?>
        <a href="/Admin/User" class="btn btn-info btn-sm mb-3"><i class="fa fa-arrow-left"></i> Kembali</a>
        <form action="/Admin/User/<?php echo e($userku->id); ?>/Update" method="POST"  enctype="multipart/form-data" class=""
            enctype="multipart/form-data">
                
        <?php endif; ?>
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="row justify-content-center align-items-center">
                <div class="col-md-5 border  border-2 border-success rounded p-4">
                    <div class="row">
                        <div class="form-group mb-2  col-md-12">
                            <label class="font-weight-bold text-success">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-lg m-1 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Nama Lengkap"
                                name="name" value="<?php echo e(old('name', $userku->name)); ?>" id="">
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
                            <label class="font-weight-bold text-success">Akun</label>
                            <input type="text" class="form-control form-control-lg m-1 <?php $__errorArgs = ['akun'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Akun"
                                name="akun" value="<?php echo e(old('akun', $userku->akun)); ?>" id="">
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
                            <label class="font-weight-bold text-success">Email</label>
                            <input type="email" class="form-control form-control-lg m-1 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Email"
                                name="email" value="<?php echo e(old('email', $userku->email)); ?>" id="">
                            <!-- tampilkan pesan error -->
                            <?php $__errorArgs = ['email'];
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
                            <label class="font-weight-bold text-success">Password</label>
                            <input type="password" class="form-control form-control-lg m-1 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Password"
                                name="password" value="<?php echo e(old('password', $userku->password)); ?>" id="">
                            <!-- tampilkan pesan error -->
                            <?php $__errorArgs = ['password'];
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
                            <label class="font-weight-bold text-success">Wilayah</label>
                            <input type="text" class="form-control form-control-lg m-1 <?php $__errorArgs = ['wilayah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Wilayah"
                                name="wilayah" value="<?php echo e(old('wilayah', $userku->wilayah)); ?>">
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
                        <div class="form-group mb-2  col-md-12">
                            <label class="font-weight-bold text-success">Akses</label>
                            <select class="form-select form-select-lg m-1 <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" aria-label="Small select example"  name="role" id="">
                                <option  value="<?php echo e(old('role', $userku->role)); ?>"><?php echo e(old('role', $userku->role)); ?></option>
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
                    <button type="reset" class="btn btn-md btn-secondary me-3 mt-2" style="height: 50px">Reset</button>
                    <button type="submit" class="btn btn-md btn-success me-3 mt-2" style="height: 50px">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECT\LARAVEL\padepokan_store\resources\views/folder_user/edit.blade.php ENDPATH**/ ?>