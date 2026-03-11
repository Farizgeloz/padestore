
 
<?php $__env->startSection("content"); ?>
<div class="mt-1 mb-5 card bg-body-tertiary">
   
    <div class="bg-white card-header">
        <h4><i class="fa fa-database"></i> Daftar Order Pelanggan</h4>
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
            <a href="/SuperAdmin/Order/Tambah" class="mb-3 btn btn-success btn-l"> <i class="fa fa-plus"></i> Tambah Orderan</a>
        
        <?php elseif($roleuserlogin == "Admin" ): ?>
            <a href="/Admin/Order/Tambah" class="mb-3 btn btn-success btn-l"> <i class="fa fa-plus"></i> Tambah Orderan</a>
        <?php endif; ?>

        <?php if($roleuserlogin == "Super Admin" ): ?>
        <form method="GET" action="/SuperAdmin/Order/Search" class="mb-2 row">
        <?php elseif($roleuserlogin == "Admin" ): ?>
        <form method="GET" action="/Admin/Order/Search" class="mb-2 row">
        <?php else: ?>
        <form method="GET" action="/Order/Search" class="mb-2 row">
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
                        <th scope="col" width="50px">ID</th>
                        <th scope="col">Pelanggan</th>
                        <th scope="col">Pembayaran</th>
                        <th scope="col">Jumlah Pesanan</th>
                        <th scope="col">Sisa Pesanan</th>
                        <th scope="col">Jenis Barang</th>
                        <th scope="col">Status</th>
                        <th scope="col" style="width: 20%"  class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $orderku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="textsize9"><?php echo e($orderku->firstItem() + $loop->index); ?></td>
                       
                        <td class=" textsize9"><?php echo e($order->nama_pelanggan); ?></td>
                        <td class=" textsize9"><?php echo e($order->pembayaran); ?></td>
                        <td class=" textsize9"><?php echo e($order->jumlah_pesanan); ?></td>
                        <td class=" textsize9"><?php echo e($order->sisa_pesanan); ?></td>
                        <td class=" textsize9"><?php echo e($order->jenis_harga); ?></td>
                        <td style="background-color: <?php echo e($order->status === 'Aktif' ? '#0ea314' : '#ffb3b3'); ?>;color: <?php echo e($order->status === 'Aktif' ? '#fff' : '#000'); ?>">
                            <?php echo e($order->status); ?>

                        </td>
                        <td class="text-center align-items-center">
                            <!-- dari middleware UserAkses-->
                                <?php if($errors->any()): ?>
                                    <p class="textsize6 text-danger mb-1"><?php echo e($errors->first()); ?></p>
                                <?php endif; ?>
                                <button type="button" class="btn btn-primary btn-l" data-bs-toggle="modal" data-bs-target="#exampleModalDetail<?php echo e($order->id_order); ?>">
                                   <i class="fa fa-eye"></i>
                                </button>
                                <?php if($roleuserlogin == "Super Admin" ): ?>
                                <a href="/SuperAdmin/Order/Edit/<?php echo e($order->id_order); ?>"
                                    class="btn btn-l btn-warning"><i class="fa fa-pen"></i></a>
                                <button type="button" class="btn btn-danger btn-l" data-bs-toggle="modal" data-bs-target="#exampleModalDelete<?php echo e($order->id_order); ?>">
                                    <i class="fa fa-trash"></i>
                                </button>
                            
                                <?php elseif($roleuserlogin == "Admin" ): ?>
                                <a href="/Admin/Order/<?php echo e($order->id_order); ?>/Edit"
                                    class="btn btn-l btn-warning"><i class="fa fa-pen"></i></a>
                                <button type="button" class="btn btn-danger btn-l" data-bs-toggle="modal" data-bs-target="#exampleModalDelete<?php echo e($order->id_order); ?>">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <?php endif; ?>
                                
                               
                                
                            </form>
                        </td>
                    </tr>

<!------------------------ Modal Detail----------------------------->
                    <div class="modal fade" id="exampleModalDetail<?php echo e($order->id_order); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl w-100" style="">
                            <div class="p-2 modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail (<?php echo e($order->nomor_kotak); ?>)</h1>
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
                                                        <p><?php echo $order->deskripsi; ?></p>
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
                                                <img src="<?php echo e(asset('/storage/kotaks/' . $order->foto)); ?>" 
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
                    <div class="modal fade" id="exampleModalDelete<?php echo e($order->id_order); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-l">
                            <form action="<?php echo e(route('folder_order.destroy', $order->id_order)); ?>" method="POST" class="p-2 border border-2 rounded border-success">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data (<?php echo e($order->nama_pelanggan); ?>)</h1>
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
            <?php echo e($orderku->links('pagination::bootstrap-5')); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECT\LARAVEL\pabrik_tahu\resources\views/folder_order/page_order.blade.php ENDPATH**/ ?>