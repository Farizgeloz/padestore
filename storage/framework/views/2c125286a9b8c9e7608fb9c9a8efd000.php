

 
<?php $__env->startSection("content"); ?>
<div class="card mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h4>Form Edit Pesanan Pengiriman</h4>
    </div>
    <div class="card-body">
        <?php if($roleuserlogin == "Super Admin" ): ?>
        <a href="/SuperAdmin/Pesanan/Deliver" class="btn btn-info btn-l mb-3 text-white"><i class="fa fa-arrow-left"></i> Kembali</a>
        
        <form action="/SuperAdmin/Pesanan/Deliver/Update/<?php echo e($pesananku->id_pesanan); ?>" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2"
            enctype="multipart/form-data">
    
        <?php elseif($roleuserlogin == "Admin" ): ?>
        <a href="/Admin/Kotak" class="btn btn-info btn-l mb-3 text-white"><i class="fa fa-arrow-left"></i> Kembali</a>
        
        <form action="/Admin/Pesanan/Deliver/Update/<?php echo e($pesananku->id_pesanan); ?>" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2"
            enctype="multipart/form-data">
        <?php endif; ?>
        
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="col-md-3">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Pelanggan</label>
                        <input type="hidden" class="form-control form-control-lg m-1 <?php $__errorArgs = ['pelanggan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Nama Pelanggan"
                            name="pelangganold" value="<?php echo e(old('pelanggan', $pesananku->pelanggan)); ?>" id="">
                        
                        <select 
                            class="form-select form-select-lg <?php $__errorArgs = ['pelanggan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                            aria-label="Small select example"  
                            name="pelanggan" 
                            id=""
                        >
                            <option  value="<?php echo e(old('pelanggan', $pesananku->pelanggan)); ?>"><?php echo e(old('pelanggan', $pesananku->nama_pelanggan)); ?></option>
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
            <div class="col-md-3">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Jenis</label>
                        <select 
                            class="form-select form-select-lg <?php $__errorArgs = ['jenis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                            name="jenis" 
                            id="jenis"
                        >
                            
                            <option value="<?php echo e(old('jenis', $pesananku->jenis)); ?>" selected hidden>
                                <?php echo e(old('jenis', $pesananku->jenis) ?? 'Pilih jenis tahu...'); ?>

                            </option>

                            
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
            <div class="col-md-3">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Status</label>
                        <input type="hidden" class="form-control form-control-lg m-1 <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="Status"
                            name="statusold" value="<?php echo e(old('status', $pesananku->status)); ?>" id="">
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
                            <option value="Dropsit">Dropsit</option>
                            <option value="Deliver">Deliver</option>
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
            <div class="col-md-10">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Nomor Kotak</label>
                        <input type="hidden" class="form-control form-control-lg m-1 <?php $__errorArgs = ['kotak'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="kotak"
                            name="kotakold" value="<?php echo e(old('kotak', $pesananku->kotak)); ?>" id="">
                        <div class="m-1">
                            <div class="d-flex flex-wrap gap-3">
                                <?php $__currentLoopData = $kotakku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kotak): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $isSelected = old('kotak', $pesananku->kotak) == $kotak->id_kotak;
                                        $isKeluar = $kotak->status === 'Keluar';
                                    ?>

                                    <div class="form-check form-check-inline m-2 align-items-center  border  border-2 <?php echo e($isKeluar ? 'border-danger' : 'border-success'); ?> rounded">
                                        <input 
                                            class="form-check-input me-1 <?php echo e($isKeluar ? 'border-danger bg-danger' : 'border-success bg-success'); ?>"
                                            type="radio" 
                                            name="kotak" 
                                            id="kotak_<?php echo e($kotak->id_kotak); ?>" 
                                            value="<?php echo e($kotak->id_kotak); ?>"
                                            <?php echo e($isSelected ? 'checked' : ''); ?>

                                            style="width: 22px; height: 22px; cursor: pointer; margin-top: 2px;"
                                            
                                            <?php echo e($isKeluar && !$isSelected ? 'disabled' : ''); ?>

                                        >

                                        <label 
                                            class="form-check-label px-1 fw-semibold <?php echo e($isKeluar ? 'text-danger' : 'text-dark'); ?>" 
                                            for="kotak_<?php echo e($kotak->id_kotak); ?>"
                                            style="font-size: 1.1rem; cursor: pointer;"
                                            <?php if($isKeluar && !$isSelected): ?>
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

                            <?php $__errorArgs = ['kotak'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block mt-1">
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>


                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="col-md-12 d-flex flex-row-reverse">
                <button type="submit" class="btn btn-l btn-success me-3 mt-3">UPDATE</button>
                <button type="reset" class="btn btn-l btn-secondary me-3 mt-3">CLEAR</button>
             </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECT\LARAVEL\pabrik_tahu\resources\views/folder_pesanandeliver/edit.blade.php ENDPATH**/ ?>