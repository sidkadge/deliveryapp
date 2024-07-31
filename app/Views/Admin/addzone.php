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
                            <h3 class="card-title">Add Zone<small></small></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="<?php echo base_url(); ?>addzone" method="post" id="add_zone">
                            <div class="row card-body">
                                <input type="hidden" name="id" class="form-control" id="id" value="<?php if(!empty($single_data)){ echo $single_data->id;} ?>">

                                <div class="col-lg-12 col-md-3 col-12 form-group">
                                    <label for="zone">Enter Zone(Location)</label>
                                    <input type="text" name="zone" class="form-control" id="zone" placeholder="Enter Zone name" value="<?php if(!empty($single_data)){ echo $single_data->zone; } ?>">
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
<script>
    $(document).ready(function() {
    $('#add_zone').validate({
        rules: {
            zone: {
                required: true,
            },
         
        },
        messages: {
            zone: {
                required: 'Please zone name.',
            },
           
        },
    
    });
});
</script>