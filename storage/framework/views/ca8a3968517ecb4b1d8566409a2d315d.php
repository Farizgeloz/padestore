
 
<?php $__env->startSection("content"); ?>
<div class="mt-1 mb-5 card bg-body-tertiary">
   
    <div class="bg-white card-header">
        <h4><i class="fa fa-database"></i> Daftar Stok Barang</h4>
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
            <a href="/SuperAdmin/StokBarang/Tambah" class="mb-3 btn btn-success btn-l"> <i class="fa fa-plus"></i> Tambah Stok Barang</a>
        
        <?php elseif($roleuserlogin == "Admin" ): ?>
            <a href="/Admin/StokBarang/Tambah" class="mb-3 btn btn-success btn-l"> <i class="fa fa-plus"></i> Tambah Stok Barang</a>
        <?php endif; ?>

        <?php if($roleuserlogin == "Super Admin" ): ?>
        <form method="GET" action="/SuperAdmin/StokBarang/Search" class="mb-2 row">
        <?php elseif($roleuserlogin == "Admin" ): ?>
        <form method="GET" action="/Admin/StokBarang/Search" class="mb-2 row">
        <?php else: ?>
        <form method="GET" action="/StokBarang/Search" class="mb-2 row">
        <?php endif; ?>
        
            <div class="input-group row" style="margin-right:5px;">
                <div class="form-outline col-md-10 col-9" data-mdb-input-init>
                    <input class="border border-2 form-control form-control-lg" name="search" placeholder="Pencarian Data..." value="<?php echo e(request()->input('search') ? request()->input('search') : ''); ?>">
                </div>
                <button type="submit" class="rounded btn btn-primary col-md-2 col-3">Cari</button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-striped table-bordered"  style="width:100%">
                <thead class="text-white bg-success textsize9">
                    <tr>
                        <th scope="col" width="50px">No</th>
                        <th scope="col">Kode Barang</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Stok Awal</th>
                        <th scope="col">Barang Masuk</th>
                        <th scope="col">Barang Keluar</th>
                        <th scope="col">Sisa Stok</th>
                        <th scope="col">Nilai Akhir</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Status</th>
                        <th scope="col" style="width: 20%"  class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $stokbarangku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stokbarang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="textsize9"><?php echo e($stokbarangku->firstItem() + $loop->index); ?></td>
                       
                        <td class=" textsize9"><?php echo e($stokbarang->kode_barang); ?></td>
                        <td class=" textsize9"><?php echo e($stokbarang->nama_barang); ?></td>
                        <td class=" textsize9"><?php echo e($stokbarang->stok_awal); ?></td>
                        <td><?php echo e($stokbarang->barang_masuk); ?></td>
                        <td><?php echo e($stokbarang->barang_keluar); ?></td>
                        <td><?php echo e(($stokbarang->barang_masuk + $stokbarang->barang_masuk) - $stokbarang->barang_keluar); ?></td>
                        <td><?php echo e($stokbarang->nilai_akhir); ?></td>
                         <td class=" textsize9"><?php echo e(\Carbon\Carbon::parse($stokbarang->tanggal)->translatedFormat('d F Y')); ?></td>
                        <td style="background-color: <?php echo e($stokbarang->status === 'Habis' ? '#ffb3b3' : 'transparent'); ?>">
                            <?php echo e($stokbarang->status); ?>

                        </td>
                        
                        <td class="text-center align-items-center">
                            <!-- dari middleware UserAkses-->
                                <?php if($errors->any()): ?>
                                    <p class="textsize6 text-danger mb-1"><?php echo e($errors->first()); ?></p>
                                <?php endif; ?>
                                <button type="button" class="btn btn-primary btn-l" data-bs-toggle="modal" data-bs-target="#exampleModalDetail<?php echo e($stokbarang->id_barang); ?>">
                                   <i class="fa fa-eye"></i>
                                </button>
                                <?php if($roleuserlogin == "Super Admin" ): ?>
                                    <?php if($stokbarang->status !== "Habis"): ?>
                                        <a href="/SuperAdmin/StokBarang/Edit/<?php echo e($stokbarang->id_barang); ?>"
                                            class="btn btn-l btn-warning"><i class="fa fa-pen"></i></a>
                                        <button type="button" class="btn btn-danger btn-l" data-bs-toggle="modal" data-bs-target="#exampleModalDelete<?php echo e($stokbarang->id_barang); ?>">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                <?php elseif($roleuserlogin == "Admin" ): ?>
                                    <?php if($stokbarang->status !== "Habis"): ?>
                                        <a href="/Admin/StokBarang/<?php echo e($stokbarang->id_barang); ?>/Edit"
                                            class="btn btn-l btn-warning">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-l"
                                            data-bs-toggle="modal"
                                            data-bs-target="#exampleModalDelete<?php echo e($stokbarang->id_barang); ?>">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                <?php endif; ?>
                                
                               
                                
                            </form>
                        </td>
                    </tr>

<!------------------------ Modal Detail----------------------------->
                    <div class="modal fade" id="exampleModalDetail<?php echo e($stokbarang->id_barang); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl w-100" style="">
                            <div class="p-2 modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail (<?php echo e($stokbarang->nama_barang); ?>)</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="p-2 border border-2 rounded modal-body border-success">
                                    <div class="p-2 row">
                                        
                                        <div class="col-md-6">
                                            <div class="border rounded row border-1 m-2">
                                                <div class="col-md-12">
                                                        <p>Deskripsi Riwayat :</p>
                                                </div>
                                                <div class="col-md-12">
                                                    <code class="text-secondary">
                                                        <p><?php echo $stokbarang->alamat; ?></p>
                                                    </code>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
                                </div>
                            </div>
                        </div>
                    </div>

<!------------------------ Modal Delete----------------------------->
                    <div class="modal fade" id="exampleModalDelete<?php echo e($stokbarang->id_barang); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-l">
                            <form action="<?php echo e(route('folder_stokbarang.destroy', $stokbarang->id_barang)); ?>" method="POST" class="p-2 border border-2 rounded border-success">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data (<?php echo e($stokbarang->nama_stokbarang); ?>)</h1>
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
            <?php echo e($stokbarangku->links('pagination::bootstrap-5')); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECT\LARAVEL\padepokan_store\resources\views/folder_stokbarang/page_stokbarang.blade.php ENDPATH**/ ?>