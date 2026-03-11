
 
<?php $__env->startSection("content"); ?>
<div class="card mt-10 mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h5>Form Tambah Drop Pesanan</h5>
    </div>
    <div class="card-body">
        <?php if($roleuserlogin == "Super Admin" ): ?>
        <a href="/SuperAdmin/DropPesanan" class="btn btn-info btn-sm mb-2 text-light"><i class="fa fa-arrow-left"></i> Kembali</a>
    
        <?php elseif($roleuserlogin == "Admin" ): ?>
        <a href="/Admin/DropPesanan" class="btn btn-info btn-sm mb-2 text-light"><i class="fa fa-arrow-left"></i> Kembali</a>
        <?php endif; ?>
       
        <?php if(session('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        <?php if($errors->has('error')): ?>
            <div class="alert alert-danger">
                <?php echo e($errors->first('error')); ?>

            </div>
        <?php endif; ?>
        <form action="<?php echo e(route('folder_pesanan.store')); ?>" method="post" enctype="multipart/form-data" class="row border  border-2 border-success rounded p-2">
            <?php echo csrf_field(); ?>
            <div class="col-md-6">
                <div class="row">
                    
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Orderan</label>
                        <select class="form-select form-select-l m-1 <?php $__errorArgs = ['order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" aria-label="Small select example"  name="order" id="order">
                            <option  value="">Pilih Orderan</option>
                            <?php $__currentLoopData = $orderku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($order->id_order); ?>" 
                                    data-harga="<?php echo e($order->harga_retail); ?>"
                                    data-sisa="<?php echo e($order->sisa_pesanan); ?>"
                                >
                                    <?php echo e($order->nama_pelanggan); ?> - <?php echo e($order->nama_produk); ?>

                                </option>
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
                        <label class="font-weight-bold text-success">Qty</label>
                        <input type="number" class="form-control m-1 <?php $__errorArgs = ['qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Qty"
                            name="qty" value="<?php echo e(old('qty')); ?>"  id="qty" min="1">
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
                        <label class="font-weight-bold text-success">Harga Satuan</label>
                        <input type="text" class="form-control m-1 <?php $__errorArgs = ['harga'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Harga Satuan"
                            name="harga" value="<?php echo e(old('harga')); ?>" id="harga" readonly>
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
                        <label class="font-weight-bold text-success">Sisa Pesanan</label>
                        <input type="number" class="form-control m-1 <?php $__errorArgs = ['sisa_pesanan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Sisa Pesanan"
                            name="sisa_pesanan" value="<?php echo e(old('sisa_pesanan')); ?>" id="sisa_pesanan" min="0" readonly>
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
             <button type="submit" class="btn btn-md btn-success me-3">SIMPAN</button>
                <button type="reset" class="btn btn-md btn-secondary me-3">CLEAR</button>
            </div>
            
           
        </form>
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                let totalAwal = 0;

                const orderSelect = document.getElementById("order");
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

                    akumulasiDisplay.value = formatRupiah(totalHarga);
                    akumulasiHidden.value = totalHarga;
                    sisaInput.value = sisa;
                }

                // ✅ AUTO ISI HARGA & SISA SAAT ORDER DIPILIH
                orderSelect.addEventListener("change", function () {
                    let selected = this.options[this.selectedIndex];

                    let harga = selected.getAttribute("data-harga") || 0;
                    let sisa = selected.getAttribute("data-sisa") || 0;

                    totalAwal = parseInt(sisa);

                    hargaInput.value = formatRupiah(harga);
                    sisaInput.value = sisa;

                    hitungSemua();
                });

                hargaInput.addEventListener("input", function () {
                    let angka = getAngka(this.value);
                    this.value = formatRupiah(angka);
                    hitungSemua();
                });

                qtyInput.addEventListener("input", hitungSemua);

                document.querySelector("form").addEventListener("submit", function () {
                    hargaInput.value = getAngka(hargaInput.value);
                });

                hitungSemua();
            });
            </script>


    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECT\LARAVEL\padepokan_store\resources\views/folder_pesanan/create.blade.php ENDPATH**/ ?>