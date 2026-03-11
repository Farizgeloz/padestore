
 
<?php $__env->startSection("content"); ?>
<div class="mt-1 mb-5 card bg-body-tertiary">
   
    <div class="bg-white card-header">
        <h4><i class="fa fa-database"></i> Daftar Akun / Pengguna</h4>
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

        <?php if($roleuserlogin == "Super Admin"): ?>
        <a href="/SuperAdmin/User/Create" class="mb-3 btn btn-success btn-l"> <i class="fa fa-plus"></i> Tambah Pengguna</a>
        <form method="GET" action="/SuperAdmin/User/Search" class="mb-2 row">
        <?php elseif($roleuserlogin == "Admin" ): ?>
        <a href="/Admin/User/Create" class="mb-3 btn btn-success btn-l"> <i class="fa fa-plus"></i> Tambah Pengguna</a>
        <form method="GET" action="/Admin/User/Search" class="mb-2 row">        
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
                        <th scope="col-1" width="50px">No</th>
                        <th scope="col-2">Nama</th>
                        <th scope="col-2">Email</th>
                        <th scope="col-1">Role</th>
                        <th scope="col-2">Wilayah</th>
                        <th scope="col-1" style=""  class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $userku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $myuser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td scope="col-1" class="textsize9"><?php echo e($userku->firstItem() + $loop->index); ?></td>
                        <td scope="col-2" class=" textsize9"><?php echo e($myuser->name); ?></td>
                        <td scope="col-2"><?php echo e($myuser->email); ?></td>
                        <td scope="col-1"><?php echo e($myuser->role); ?></td>
                        <td scope="col-1"><?php echo e($myuser->wilayah); ?></td>
                        <td scope="col-1" class="text-center align-items-center">
                            <!-- dari middleware UserAkses-->
                                <?php if($errors->any()): ?>
                                    <p class="textsize6 text-danger mb-1"><?php echo e($errors->first()); ?></p>
                                <?php endif; ?>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalDetail<?php echo e($myuser->id); ?>">
                                   <i class="fa fa-eye"></i>
                                </button>
                                <?php if($roleuserlogin == "Super Admin"): ?>
                                <a href="/SuperAdmin/User/<?php echo e($myuser->id); ?>/Edit"
                                    class="btn btn-sm btn-warning"><i class="fa fa-pen"></i></a>
                                <?php elseif($roleuserlogin == "Admin" ): ?>
                                <a href="/Admin/User/<?php echo e($myuser->id); ?>/Edit"
                                    class="btn btn-sm btn-warning"><i class="fa fa-pen"></i></a>
                                        
                                <?php endif; ?>
                               
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalDelete<?php echo e($myuser->id); ?>">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

<!------------------------ Modal Detail----------------------------->
                    <div class="modal fade" id="exampleModalDetail<?php echo e($myuser->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl w-100" style="">
                            <div class="p-2 modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail (<?php echo e($myuser->name); ?>)</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="p-2 border border-2 rounded modal-body border-success">
                                    <div class="p-2 row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Name</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p>: <strong><?php echo e($myuser->name); ?></strong></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Email</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p>: <strong><?php echo e($myuser->email); ?></strong></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Password</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p>: <strong><?php echo e($myuser->password); ?></strong></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Tingkat</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p>: <strong><?php echo e($myuser->tingkat); ?></strong></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Kecamatan</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p>: <strong><?php echo e($myuser->kecamatan); ?></strong></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Desa</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p>: <strong><?php echo e($myuser->desa); ?></strong></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Dusun</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p>: <strong><?php echo e($myuser->dusun); ?></strong></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Role</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p>: <strong><?php echo e($myuser->role); ?></strong></p>
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
                    <div class="modal fade" id="exampleModalDelete<?php echo e($myuser->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-l">
                            <form action="<?php echo e(route('folder_user.destroy', $myuser->id)); ?>" method="POST" class="p-2 border border-2 rounded border-success">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data (<?php echo e($myuser->name); ?>)</h1>
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
            <?php echo e($userku->links('pagination::bootstrap-5')); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROJECT\LARAVEL\padepokan_store\resources\views/folder_user/page_user.blade.php ENDPATH**/ ?>