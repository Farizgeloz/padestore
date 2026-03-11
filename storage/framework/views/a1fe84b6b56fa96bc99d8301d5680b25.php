

 
<?php $__env->startSection("content"); ?>
<div class="card mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h4>Form Edit Order Pelanggan</h4>
    </div>
    <div class="card-body">
        <?php if($roleuserlogin == "Super Admin" ): ?>
        <a href="/SuperAdmin/Order" class="btn btn-info btn-l mb-3 text-white"><i class="fa fa-arrow-left"></i> Kembali</a>
        
        <form action="/SuperAdmin/Order/Update/<?php echo e($orderku->id_order); ?>" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2"
            enctype="multipart/form-data">
    
        <?php elseif($roleuserlogin == "Admin" ): ?>
        <a href="/Admin/Order" class="btn btn-info btn-l mb-3 text-white"><i class="fa fa-arrow-left"></i> Kembali</a>
        
        <form action="/Admin/Order/Update/<?php echo e($orderku->id_order); ?>" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2"
            enctype="multipart/form-data">
        <?php endif; ?>
        
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="col-md-5">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Pelanggan</label>
                        <select class="form-select form-select-lg m-1 <?php $__errorArgs = ['pelanggan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" aria-label="Small select example"  name="pelanggan" id="">
                            <option  value="<?php echo e(old('pelanggan', $orderku->pelanggan)); ?>"><?php echo e(old('pelanggan', $orderku->nama_pelanggan)); ?></option>
                            <?php $__currentLoopData = $pelangganku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pelanggan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($pelanggan->id_pelanggan); ?>"><?php echo e($pelanggan->nama_pelanggan); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           
                           
                        </select>
                        <!-- tampilkan pesan error -->
                        <?php $__errorArgs = ['pelanggan'];
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
            <div class="col-md-5">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">metode_bayar</label>
                        <select class="form-select form-select-lg m-1 <?php $__errorArgs = ['metode_bayar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" aria-label="Small select example"  name="metode_bayar" id="">
                            <option  value="<?php echo e(old('metode_bayar', $orderku->metode_bayar)); ?>"><?php echo e(old('metode_bayar', $orderku->metode_bayar)); ?></option>
                           
                           <option value="Cash">Cash</option>
                           <option value="Debet">TF</option>
                           
                           
                        </select>
                        <!-- tampilkan pesan error -->
                        <?php $__errorArgs = ['metode_bayar'];
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
            <div class="col-md-5">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Produk</label>
                        <select class="form-select form-select-lg m-1 <?php $__errorArgs = ['produk_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" aria-label="Small select example"  name="produk_id" id="">
                             <option  value="<?php echo e(old('produk_id', $orderku->produk_id)); ?>"><?php echo e(old('produk_id', $orderku->nama_produk)); ?></option>
                            <?php $__currentLoopData = $produkku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($produk->id_produk); ?>"><?php echo e($produk->nama_produk); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           
                           
                        </select>
                        <!-- tampilkan pesan error -->
                        <?php $__errorArgs = ['produk_id'];
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
            <div class="col-md-5">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Jumlah Pesanan</label>
                        <input type="number" class="form-control form-control-lg m-1 <?php $__errorArgs = ['jumlah_pesanan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Jumlah Pesanan"
                            name="jumlah_pesanan" value="<?php echo e(old('jumlah_pesanan', $orderku->jumlah_pesanan)); ?>" id="jumlah_pesanan">
                        <!-- tampilkan pesan error -->
                        <?php $__errorArgs = ['jumlah_pesanan'];
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
            <div class="col-md-5">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Keluar Pesanan</label>
                        <input type="number" class="form-control form-control-lg m-1 <?php $__errorArgs = ['keluar_pesanan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Jumlah Keluar"
                            name="keluar_pesanan" value="<?php echo e(old('keluar_pesanan', $orderku->keluar_pesanan)); ?>" id="keluar_pesanan" readonly>
                        <!-- tampilkan pesan error -->
                        <?php $__errorArgs = ['keluar_pesanan'];
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
            <div class="col-md-5">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Sisa Pesanan</label>
                        <input type="number" class="form-control form-control-lg m-1 <?php $__errorArgs = ['sisa_pesanan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Sisa Pesanan"
                            name="sisa_pesanan" value="<?php echo e(old('sisa_pesanan', $orderku->sisa_pesanan)); ?>" id="sisa_pesanan" readonly>
                        <!-- tampilkan pesan error -->
                        <?php $__errorArgs = ['sisa_pesanan'];
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
        <script>
document.addEventListener("DOMContentLoaded", function () {

    const jumlahInput = document.getElementById("jumlah_pesanan");
    const keluarInput = document.getElementById("keluar_pesanan");
    const sisaInput   = document.getElementById("sisa_pesanan");

    function hitungSisa() {

        let jumlah = parseInt(jumlahInput.value) || 0;
        let keluar = parseInt(keluarInput.value) || 0;

        // Jumlah tidak boleh kurang dari keluar
        if (jumlah < keluar) {
            jumlah = keluar;
            jumlahInput.value = jumlah;
        }

        // Hitung sisa
        let sisa = jumlah - keluar;
        sisaInput.value = sisa;
    }

    // Event
    jumlahInput.addEventListener("input", hitungSisa);
    keluarInput.addEventListener("input", hitungSisa);

    // Hitung awal
    hitungSisa();

});
</script>



    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECT\LARAVEL\padepokan_store\resources\views/folder_order/edit.blade.php ENDPATH**/ ?>