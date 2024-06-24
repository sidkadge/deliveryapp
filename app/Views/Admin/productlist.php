<?php include __DIR__.'/../Admin/header.php'; ?>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="background-color: #afeae2">
                        <div class="card-header">
                            <h3 class="card-title">Product List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($menu_data)) {
                                        $i = 1; ?>
                                    <?php foreach ($menu_data as $data) {  ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $data->productname; ?></td>
                                        <td><?= $data->price; ?></td>
                                        <td>
                                            <a href="<?= base_url(); ?>addproduct/<?= $data->id; ?>"><i
                                                    class="far fa-edit me-2"></i></a>
                                            <form id="deleteproduct<?=$data->id?>"
                                                action="<?= base_url('deleteproduct') ?>" method="post"
                                                style="display: inline;">
                                                <input type="hidden" name="id" value="<?= $data->id ?>">
                                                <input type="hidden" name="table_name" value="tbl_produact">
                                                <i class="far fa-trash-alt " title="Delete"
                                                    style="cursor: pointer;"
                                                    onclick="document.getElementById('deleteproduct<?=$data->id?>').submit();"></i>
                                            </form>

                                        </td>

                                    </tr>
                                    <?php $i++;
                                        } ?>
                                    <?php } ?>

                                </tbody>

                            </table>
                        </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include __DIR__.'/../Admin/footer.php'; ?>