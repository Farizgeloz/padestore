
 
<?php $__env->startSection("content"); ?>
<div class="mt-1 mb-5 card bg-body-tertiary">
   
    <div class="bg-white card-header">
        <h4><i class="fa fa-database"></i> Daftar Pengeluaran</h4>
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
        <?php if($roleuserlogin == "Super Admin" ): ?>
            <a href="/SuperAdmin/Pengeluaran/Tambah" class="mb-3 btn btn-success btn-sm"> <i class="fa fa-plus"></i> Tambah Pengeluaran</a>
        
        <?php elseif($roleuserlogin == "Admin" ): ?>
            <a href="/Admin/Pengeluaran/Tambah" class="mb-3 btn btn-success btn-sm"> <i class="fa fa-plus"></i> Tambah Pengeluaran</a>
        <?php endif; ?>

        <?php if($roleuserlogin == "Super Admin" ): ?>
        <form method="GET" action="/SuperAdmin/Pengeluaran/Search" class="mb-2 row">
        <?php elseif($roleuserlogin == "Admin" ): ?>
        <form method="GET" action="/Admin/Pengeluaran/Search" class="mb-2 row">
        <?php else: ?>
        <form method="GET" action="/Pengeluaran/Search" class="mb-2 row">
        <?php endif; ?>
        
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
                        <th scope="col" width="50px">No</th>
                        <th scope="col">Pengeluaran</th>
                        <th scope="col">Nominal</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Validasi</th>
                        <th scope="col" style="width: 20%"  class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $pengeluaranku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pengeluaran): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="textsize9"><?php echo e($pengeluaranku->firstItem() + $loop->index); ?></td>
                       
                        <td class=" textsize9"><?php echo e($pengeluaran->nama_pengeluaran); ?></td>
                        <td class="textsize9">
                            Rp <?php echo e(number_format($pengeluaran->nominal, 0, ',', '.')); ?>

                        </td>
                        <td class=" textsize9"><?php echo e(\Carbon\Carbon::parse($pengeluaran->tanggal)->translatedFormat('d F Y')); ?></td>
                        <td style="
                            color: <?php echo e($pengeluaran->validasi === 'Belum Valid' ? '#c97204' : '#0ea314'); ?>;
                        ">
                            <?php echo e($pengeluaran->validasi); ?>

                        </td>
                        
                        <td class="text-center align-items-center">
                            <!-- dari middleware UserAkses-->
                               
                                <?php if($roleuserlogin == "Super Admin" ): ?>
                                    <?php if($pengeluaran->status !== "Habis"): ?>
                                        <a href="/SuperAdmin/Pengeluaran/Edit/<?php echo e($pengeluaran->id_pengeluaran); ?>"
                                            class="btn btn-sm btn-warning"><i class="fa fa-pen"></i></a>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalDelete<?php echo e($pengeluaran->id_pengeluaran); ?>">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                <?php elseif($roleuserlogin == "Admin" ): ?>
                                    <?php if($pengeluaran->status !== "Habis"): ?>
                                        <a href="/Admin/Pengeluaran/<?php echo e($pengeluaran->id_pengeluaran); ?>/Edit"
                                            class="btn btn-sm btn-warning">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#exampleModalDelete<?php echo e($pengeluaran->id_pengeluaran); ?>">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                <?php endif; ?>
                                
                               
                                
                            </form>
                        </td>
                    </tr>

<!------------------------ Modal Delete----------------------------->
                    <div class="modal fade" id="exampleModalDelete<?php echo e($pengeluaran->id_pengeluaran); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-l">
                            <form action="<?php echo e(route('folder_pengeluaran.destroy', $pengeluaran->id_pengeluaran)); ?>" method="POST" class="p-2 border border-2 rounded border-success">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data (<?php echo e($pengeluaran->nama_pengeluaran); ?>)</h1>
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
            <?php echo e($pengeluaranku->links('pagination::bootstrap-5')); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECT\LARAVEL\pabrik_tahu\resources\views/folder_pengeluaran/page_pengeluaran.blade.php ENDPATH**/ ?>