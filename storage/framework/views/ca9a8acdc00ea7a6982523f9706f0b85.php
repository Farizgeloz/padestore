
 
<?php $__env->startSection("content"); ?>
<div class="mt-1 mb-5 card bg-body-tertiary">
   
    <div class="bg-white card-header">
        <h4><i class="fa fa-database"></i> Daftar Pesanan</h4>
    </div>
    
    <div class="card-body">
 
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if($roleuserlogin == "Super Admin" ): ?>
            <a href="/SuperAdmin/DropPesanan/Tambah" class="mb-3 btn btn-success btn-sm"> <i class="fa fa-plus"></i> Tambah Pesanan</a>
        
        <?php elseif($roleuserlogin == "Admin" ): ?>
            <a href="/SuperAdmin/DropPesanan/Tambah" class="mb-3 btn btn-success btn-sm"> <i class="fa fa-plus"></i> Tambah Pesanan</a>
        <?php endif; ?>

        <?php if($roleuserlogin == "Super Admin" ): ?>
        <form method="GET" action="/SuperAdmin/DropPesanan/Search" class="mb-2 row">
        <?php elseif($roleuserlogin == "Admin" ): ?>
        <form method="GET" action="/Admin/DropPesanan/Search" class="mb-2 row">
        <?php else: ?>
        <form method="GET" action="/DropPesanan/Search" class="mb-2 row">
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
                        <th scope="col">Pelanggan</th>
                        <th scope="col">Produk</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Harga Satuan</th>
                        <th scope="col">Jumlah Bayar</th>
                        <th scope="col">Status</th>
                        <th scope="col" style="width: 20%"  class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $pesananku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pesanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="textsize9"><?php echo e($pesananku->firstItem() + $loop->index); ?></td>
                       
                        <td class=" textsize9"><?php echo e($pesanan->nama_pelanggan); ?></td>
                        <td class=" textsize9"><?php echo e($pesanan->nama_produk); ?></td>
                        <td class=" textsize9"><?php echo e($pesanan->qty); ?></td>
                        <td><?php echo e($pesanan->harga_rupiah); ?></td>
                        <td><?php echo e($pesanan->harga_akumulasi_rupiah); ?></td>
                        <td style="
                            background-color: <?php echo e($pesanan->status === 'Deliver' ? '#ffc107' : 
                                ($pesanan->status === 'Dropsit' ? '#0ea314' : 'transparent')); ?>;
                            color: <?php echo e($pesanan->status === 'Deliver' ? '#fff' : 
                                ($pesanan->status === 'Dropsit' ? '#fff' : '#999')); ?>;
                        ">
                            <?php echo e($pesanan->status); ?>

                        </td>
                        <td class="text-center align-items-center">
                            <!-- dari middleware UserAkses-->
                                <?php if($errors->any()): ?>
                                    <p class="textsize6 text-danger mb-1"><?php echo e($errors->first()); ?></p>
                                <?php endif; ?>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalDetail<?php echo e($pesanan->id_pesanan); ?>">
                                   <i class="fa fa-eye"></i>
                                </button>
                                <?php if($roleuserlogin == "Super Admin" ): ?>
                                <a href="/SuperAdmin/DropPesanan/Edit/<?php echo e($pesanan->id_pesanan); ?>"
                                    class="btn btn-sm btn-warning"><i class="fa fa-pen"></i></a>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalDelete<?php echo e($pesanan->id_pesanan); ?>">
                                    <i class="fa fa-trash"></i>
                                </button>
                            
                                <?php elseif($roleuserlogin == "Admin" ): ?>
                                <a href="/Admin/DropPesanan/<?php echo e($pesanan->id_pesanan); ?>/Edit"
                                    class="btn btn-sm btn-warning"><i class="fa fa-pen"></i></a>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalDelete<?php echo e($pesanan->id_pesanan); ?>">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <?php endif; ?>
                                
                               
                                
                            </form>
                        </td>
                    </tr>

<!------------------------ Modal Detail----------------------------->
                    <div class="modal fade" id="exampleModalDetail<?php echo e($pesanan->id_pesanan); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl w-100" style="">
                            <div class="p-2 modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail (<?php echo e($pesanan->nomor_kotak); ?>)</h1>
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
                                                        <p><?php echo $pesanan->deskripsi; ?></p>
                                                    </code>
                                                </div>
                                            </div>
                                        </div>
                                        <!--div class="col-md-12">
                                            <div class="m-2 mx-auto row border rounded">
                                                <div id="carouselExampleCaptions" class="carousel slide">
                                                    <div class="carousel-indicators">
                                                      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
                                                    </div>
                                                    <div class="carousel-inner">
                                                      <div class="carousel-item active">
                                                        <div class="carousel-caption d-block" style="bottom:93%;">
                                                            <h5>Foto Profil</h5>
                                                          </div>
                                                        <img src="{ asset('/storage/anggotalists/' . $anggotalist->image) }}" 
                                                        onerror="this.src='{ asset('/storage/assetku/no_image.png')}}';this.onerror='';"
                                                        class="rounded d-block w-100">
                                                        
                                                      </div>
                                                      <div class="carousel-item">
                                                        <img src="{ asset('/storage/anggotalists_ktp/' . $anggotalist->image_ktp) }}" 
                                                        onerror="this.src='{ asset('/storage/assetku/no_image.png')}}';this.onerror='';"
                                                        class="rounded d-block w-100">
                                                        <div class="carousel-caption d-block" style="bottom:93%;">
                                                          <h5>Foto Ktp</h5>
                                                        </div>
                                                      </div>
                                                      <div class="carousel-item">
                                                        <img src="{ asset('/storage/anggotalists_kk/' . $anggotalist->image_kk) }}" 
                                                        onerror="this.src='{ asset('/storage/assetku/no_image.png')}}';this.onerror='';"
                                                        class="rounded d-block w-100">
                                                        <div class="carousel-caption d-block" style="bottom:93%;">
                                                          <h5>Foto KK</h5>
                                                        </div>
                                                      </div>
                                                      <div class="carousel-item">
                                                        <img src="{ asset('/storage/anggotalists_sk/' . $anggotalist->image_sk) }}" 
                                                        onerror="this.src='{ asset('/storage/assetku/no_image.png')}}';this.onerror='';"
                                                        class="rounded d-block w-100">
                                                        <div class="carousel-caption d-block" style="bottom:93%;">
                                                          <h5>Foto SK</h5>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                      <span class="visually-hidden">Previous</span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                      <span class="visually-hidden">Next</span>
                                                    </button>
                                                </div>

                                            </div>
                                        </div-->

                                        <div class="col-md-6">
                                            <div class="m-2 mx-auto row border rounded">
                                                <p class="text-center">Foto Profil</p>
                                                <img src="<?php echo e(asset('/storage/kotaks/' . $pesanan->foto)); ?>" 
                                                onerror="this.src='<?php echo e(asset('/storage/assetku/no_image.png')); ?>';this.onerror='';"
                                                class="rounded image-100">

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
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECT\LARAVEL\padepokan_store\resources\views/folder_pesanan/page_pesanan.blade.php ENDPATH**/ ?>