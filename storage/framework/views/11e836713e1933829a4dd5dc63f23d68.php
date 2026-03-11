

 
<?php $__env->startSection("content"); ?>
<div class="card mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h4>Form Edit Pesanan</h4>
    </div>
    <div class="card-body">
        <?php if($roleuserlogin == "Super Admin" ): ?>
        <a href="/SuperAdmin/DropPesanan" class="btn btn-info btn-sm mb-3"><i class="fa fa-arrow-left"></i> Back</a>
        
        <form action="/SuperAdmin/DropPesanan/Update/<?php echo e($pesananku->id_pesanan); ?>" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success rounded p-2">
    
        <?php elseif($roleuserlogin == "Admin" ): ?>
        <a href="/Admin/Kotak" class="btn btn-info btn-sm mb-3"><i class="fa fa-arrow-left"></i> Back</a>
        
        <form action="/Admin/DropPesanan/Update/<?php echo e($pesananku->id_pesanan); ?>" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success rounded p-2">
        <?php endif; ?>
        
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="col-md-6">
                <div class="row">
                    
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Pelanggan</label>
                        <select class="form-select form-select-l m-1 <?php $__errorArgs = ['order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" aria-label="Small select example"  name="order" id="">
                            <option  value="<?php echo e(old('order', $pesananku->order_id)); ?>"><?php echo e(old('order', $pesananku->nama_pelanggan . ' - ' . $pesananku->nama_produk)); ?></option>
                            <?php $__currentLoopData = $orderku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($order->id_order); ?>"><?php echo e($order->nama_pelanggan); ?> - <?php echo e($order->nama_produk); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           
                           
                        </select>
                        <!-- tampilkan pesan error -->
                        <?php $__errorArgs = ['order'];
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
                        <label class="font-weight-bold text-success">Harga Satuan</label>
                        <input type="text" class="form-control m-1 <?php $__errorArgs = ['harga'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Harga Satuan"
                            name="harga" value="<?php echo e(old('harga', $pesananku->harga)); ?>" id="harga">
                        <!-- tampilkan pesan error -->
                        <?php $__errorArgs = ['harga'];
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
                    <div class="form-group mb-2 col-md-12">
                        <label class="font-weight-bold text-success">Harga Akumulasi</label>

                        <!-- Tampilan Rupiah -->
                        <input type="text"
                            class="form-control m-1"
                            id="harga_akumulasi_display"
                            readonly>

                        <!-- Nilai asli angka -->
                        <input type="hidden"
                            name="harga_akumulasi"
                            id="harga_akumulasi">
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Qty</label>
                        <input type="number" class="form-control m-1 <?php $__errorArgs = ['qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Qty"
                            name="qty" value="<?php echo e(old('qty', $pesananku->qty)); ?>"  id="qty" min="1">
                        <!-- tampilkan pesan error -->
                        <?php $__errorArgs = ['qty'];
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
                        <label class="font-weight-bold text-success">Sisa Pesanan</label>
                        <input type="number" class="form-control m-1 <?php $__errorArgs = ['sisa_pesanan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Sisa Pesanan"
                            name="sisa_pesanan" value="<?php echo e(old('sisa_pesanan', $pesananku->sisa_pesanan)); ?>" id="sisa_pesanan" min="0">
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
            <div class="col-md-3">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Status</label>
                        
                        <select 
                            class="form-select form-select-lg <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                            aria-label="Small select example"  
                            name="status" 
                            id="">
                            
                            <option  value="<?php echo e(old('status', $pesananku->status)); ?>"><?php echo e(old('status', $pesananku->status)); ?></option>
                            <option value="Deliver">Deliver</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                        <!-- tampilkan pesan error -->
                        <?php $__errorArgs = ['status'];
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
       <script>
            document.addEventListener("DOMContentLoaded", function () {

                let totalAwal = <?php echo e($pesananku->sisa_pesanan + $pesananku->qty); ?>;

                const hargaInput = document.getElementById("harga");
                const qtyInput = document.getElementById("qty");
                const akumulasiDisplay = document.getElementById("harga_akumulasi_display");
                const akumulasiHidden = document.getElementById("harga_akumulasi");
                const sisaInput = document.getElementById("sisa_pesanan");

                function formatRupiah(angka) {
                    return new Intl.NumberFormat("id-ID", {
                        style: "currency",
                        currency: "IDR",
                        minimumFractionDigits: 0
                    }).format(angka);
                }

                function getAngka(value) {
                    return parseInt(value.replace(/[^0-9]/g, "")) || 0;
                }

                function hitungSemua() {
                    let harga = getAngka(hargaInput.value);
                    let qty = parseInt(qtyInput.value) || 0;

                    if (qty < 0) qty = 0;
                    if (qty > totalAwal) qty = totalAwal;

                    qtyInput.value = qty;

                    let totalHarga = harga * qty;
                    let sisa = totalAwal - qty;

                    if (sisa < 0) sisa = 0;

                    // Tampilkan rupiah
                    akumulasiDisplay.value = formatRupiah(totalHarga);

                    // Simpan angka asli
                    akumulasiHidden.value = totalHarga;

                    sisaInput.value = sisa;
                }

                // Format harga saat diketik
                hargaInput.addEventListener("input", function () {
                    let angka = getAngka(this.value);
                    this.value = formatRupiah(angka);
                    hitungSemua();
                });

                qtyInput.addEventListener("input", hitungSemua);

                document.querySelector("form").addEventListener("submit", function () {
                    hargaInput.value = getAngka(hargaInput.value);
                });

                // Format saat load pertama
                let hargaAwal = getAngka(hargaInput.value);
                hargaInput.value = formatRupiah(hargaAwal);

                hitungSemua();
            });
        </script>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECT\LARAVEL\padepokan_store\resources\views/folder_pesanan/edit.blade.php ENDPATH**/ ?>