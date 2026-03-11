
 
<?php $__env->startSection("content"); ?>
<div class="mt-1 mb-5 card bg-body-tertiary">
   
    <div class="bg-white card-header">
        <h4><i class="fa fa-database"></i> Pengembalian Kotak</h4>
    </div>
    
    <div class="card-body">
 
        <?php $__sessionArgs = ["success"];
if (session()->has($__sessionArgs[0])) :
if (isset($value)) { $__sessionPrevious[] = $value; }
$value = session()->get($__sessionArgs[0]); ?>
        <div class="alert alert-success"><?php echo e($value); ?></div>
        <?php unset($value);
if (isset($__sessionPrevious) && !empty($__sessionPrevious)) { $value = array_pop($__sessionPrevious); }
if (isset($__sessionPrevious) && empty($__sessionPrevious)) { unset($__sessionPrevious); }
endif;
unset($__sessionArgs); ?>
       
        <a href="/PengambilanKotak/Tambah" class="mb-3 btn btn-success btn-sm"> <i class="fa fa-plus"></i> Update Pengembalian</a>
        
       

      
        <form method="GET" action="/Dropsit/Search" class="mb-2 row">
        
        
            <div class="input-group row" style="margin-right:5px;">
                <div class="form-outline col-md-10 col-9" data-mdb-input-init>
                    <input class="border border-2 form-control" name="search" placeholder="Pencarian Data..." value="<?php echo e(request()->input('search') ? request()->input('search') : ''); ?>">
                </div>
                <button type="submit" class="rounded btn btn-primary col-md-2 col-3">Cari</button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-striped table-bordered"  style="width:100%">
                <thead class="text-white bg-success textsize9">
                    <tr>
                        <th scope="col" width="50px">ID</th>
                        <th scope="col">Pelanggan</th>
                        <th scope="col">Jenis</th>
                        <th scope="col">No Kotak</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Akumulatif</th>
                        <th scope="col">Pengantar</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col" style="width: 20%"  class="text-center">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $pesananku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pesanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="textsize9"><?php echo e($pesananku->firstItem() + $loop->index); ?></td>
                       
                        <td class=" textsize9"><?php echo e($pesanan->nama_pelanggan); ?></td>
                        <td class=" textsize9"><?php echo e($pesanan->jenis); ?></td>
                        <td class=" textsize9"><?php echo e($pesanan->nomor_kotak); ?></td>
                        <td class="textsize9">
                            Rp <?php echo e(number_format($pesanan->harga_satuan, 0, ',', '.')); ?>

                        </td>
                        <td class="textsize9">
                            Rp <?php echo e(number_format($pesanan->harga_akumulasi, 0, ',', '.')); ?>

                        </td>
                        <td class=" textsize9"><?php echo e($pesanan->akun); ?></td>
                        <td style="
                            background-color: <?php echo e($pesanan->status === 'Deliver' ? '#ffc107' : 
                                ($pesanan->status === 'Dropsit' ? '#0ea314' : 'transparent')); ?>;
                            color: <?php echo e($pesanan->status === 'Deliver' ? '#fff' : 
                                ($pesanan->status === 'Dropsit' ? '#fff' : '#999')); ?>;
                        ">
                            <?php echo e($pesanan->status); ?>

                        </td>
                        <td class=" textsize9"><?php echo e(\Carbon\Carbon::parse($pesanan->tanggal)->translatedFormat('d F Y')); ?></td>
                        
                        <td class=" textsize8 font_colsilver" ><?php echo e($pesanan->catatan); ?></td>
                    </tr>


<!------------------------ Modal Delete----------------------------->
                    <div class="modal fade" id="exampleModalDelete<?php echo e($pesanan->id_pesanan); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-l">
                            <form action="<?php echo e(route('folder_pesanan.destroy', $pesanan->id_pesanan)); ?>" method="POST" class="p-2 border border-2 rounded border-success">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data (<?php echo e($pesanan->nama_pelanggan); ?>)</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                            <div class="row">
                                                <p>Anda Yakin Akan Menghapus Data Ini?</p>
                                               
                                            </div>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                         <button type="submit" class="btn btn-md btn-danger me-3">Hapus</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex custom-pagination justify-content-end">
            <?php echo e($pesananku->links('pagination::bootstrap-5')); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECT\LARAVEL\pabrik_tahu\resources\views/folder_kotakpengembalian/page_kotakpengembalian.blade.php ENDPATH**/ ?>