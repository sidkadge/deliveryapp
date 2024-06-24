<?php include __DIR__.'/../Admin/header.php'; ?>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary" style="background-color: #afeae2">
                        <div class="card-header">
                            <h3 class="card-title">Access Level <small></small></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="<?php echo base_url(); ?>set_menu" method="post" id="add_menu_form">
                            <div class="row card-body">
                                <input type="hidden" name="id" class="form-control" id="id" value="<?php if(!empty($single_data)){ echo $single_data->id;} ?>">

                                <div class="col-lg-12 col-md-3 col-12 form-group">
                                    <label for="menu_name">Enter Menu Name</label>
                                    <input type="text" name="menu_name" class="form-control" id="menu_name" placeholder="Enter menu name" value="<?php if(!empty($single_data)){ echo $single_data->menu_name; } ?>">
                                </div>
                                <div class="col-lg-12 col-md-3 col-12 form-group">
                                    <label for="url_location">URL Location</label>
                                    <input type="text" name="url_location" class="form-control" id="url_location" placeholder="Enter URL location" value="<?php if(!empty($single_data)){ echo $single_data->url_location; } ?>">
                                    <span id="menu_nameError" style="color: red;"></span>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-right">
                                <button type="submit" name="submit" id="submit" class="btn btn-primary submitButton"><?php if(!empty($single_data)){ echo 'Update'; }else{ echo 'Submit';} ?></button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>

<?php include __DIR__.'/../Admin/footer.php'; ?>
