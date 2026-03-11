

 
<?php $__env->startSection("content"); ?>
<div class="card mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h4>Form Edit Pengeluaran</h4>
    </div>
    <div class="card-body">
        <?php if($roleuserlogin == "Super Admin" ): ?>
        <a href="/SuperAdmin/Pengeluaran" class="btn btn-info btn-sm mb-3"><i class="fa fa-arrow-left"></i> Back</a>
        
        <form action="/SuperAdmin/Pengeluaran/Update/<?php echo e($pengeluaranku->id_pengeluaran); ?>" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success rounded p-2"
            enctype="multipart/form-data">
    
        <?php elseif($roleuserlogin == "Admin" ): ?>
        <a href="/Admin/Pengeluaran" class="btn btn-info btn-sm mb-3"><i class="fa fa-arrow-left"></i> Back</a>
        
        <form action="/Admin/Pengeluaran/Update/<?php echo e($pengeluaranku->id_pengeluaran); ?>" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success rounded p-2"
            enctype="multipart/form-data">
        <?php endif; ?>
        
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="col-md-4">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Nama Pengeluaran</label>
                        <input type="text" class="form-control m-1 <?php $__errorArgs = ['nama_pengeluaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Nama Pengeluaran"
                            name="nama_pengeluaran" value="<?php echo e(old('nama_pengeluaran', $pengeluaranku->nama_pengeluaran)); ?>" id="">
                        <!-- tampilkan pesan error -->
                        <?php $__errorArgs = ['nama_pengeluaran'];
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
            <div class="col-md-3">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Nominal</label>
                        <div class="position-relative m-1">
                            <span style="position:absolute; left:10px; top:50%; transform:translateY(-50%); color:gray;">Rp</span>
                            <input 
                                type="text" 
                                inputmode="numeric"
                                class="form-control ps-5 <?php $__errorArgs = ['nominal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  
                                placeholder="Nominal"
                                name="nominal" 
                                id="nominal"
                                value="<?php echo e(old('nominal', number_format($pengeluaranku->nominal ?? 0, 0, ',', '.'))); ?>">
                        </div>
                        <!-- tampilkan pesan error -->
                        <?php $__errorArgs = ['nominal'];
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
            
            <div class="col-md-2">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Validasi</label>
                        <select class="form-select form-select-l m-1 <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" aria-label="Small select example"  name="validasi" id="">
                            <option  value="<?php echo e(old('validasi', $pengeluaranku->validasi)); ?>"><?php echo e(old('validasi', $pengeluaranku->validasi)); ?></option>
                            
                                <option value="Belum Valid">Belum Valid</option>
                                <option value="Valid">Valid</option>
                           
                           
                        </select>
                        <!-- tampilkan pesan error -->
                        <?php $__errorArgs = ['validasi'];
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
            <div class="col-md-3">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Tanggal</label>
                        <input type="date" class="form-control m-1 <?php $__errorArgs = ['tanggal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Tanggal"
                            name="tanggal" value="<?php echo e(old('tanggal', $pengeluaranku->tanggal)); ?>" id="">
                        <!-- tampilkan pesan error -->
                        <?php $__errorArgs = ['tanggal'];
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
                <button type="submit" class="btn btn-md btn-success me-3">Update</button>
                <button type="reset" class="btn btn-md btn-secondary me-3">Reset</button>
             </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const nominalInput = document.getElementById('nominal');

    nominalInput.addEventListener('input', function (e) {
        // Hilangkan semua karakter non-digit
        let value = this.value.replace(/\D/g, '');

        // Format pakai titik ribuan (locale Indonesia)
        value = new Intl.NumberFormat('id-ID').format(value);

        // Set ulang ke input
        this.value = value;
    });

    // Sebelum form disubmit, hapus titik supaya dikirim sebagai angka murni
    const form = nominalInput.closest('form');
    if (form) {
        form.addEventListener('submit', function() {
            nominalInput.value = nominalInput.value.replace(/\D/g, '');
        });
    }
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECT\LARAVEL\padepokan_store\resources\views/folder_pengeluaran/edit.blade.php ENDPATH**/ ?>