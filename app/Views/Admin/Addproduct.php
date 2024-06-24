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
                            <h3 class="card-title">Add Product<small></small></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="<?php echo base_url(); ?>add_product" id="add_product" method="post">
                            <div class="row card-body">
                                <input type="hidden" name="id" class="form-control" id="id" value="<?php if(!empty($single_data)){ echo $single_data->id;} ?>">
                                <div class="col-lg-3 col-md-6 col-12 form-group">
                                    <label for="productname">Product Name</label>
                                    <input type="text" name="productname" class="form-control" id="productname" placeholder="Enter Product name" value="<?php if(!empty($single_data)){ echo $single_data->productname; } ?>">
                                </div>
                               
                                <div class="col-lg-2 col-md-6 col-12 form-group">
                                    <label for="Size">Unit</label>
                                    <input type="text" name="Size" class="form-control" id="Size" placeholder="Size" value="<?php if(!empty($single_data)){ echo $single_data->price; } ?>">
                                </div>
                                <div class="col-lg-2 col-md-6 col-12 form-group">
                                    <label for="quantity">Quantity</label>
                                    <div class="input-group">
                                    
                                        <div class="input-group-append">
                                            <select class="form-control" name="unit">
                                           
                                                <option value="ltr">ltr</option>
                                                <option value="kg">kg</option>
                                                <option value="g">gm</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6 col-12 form-group">
                                    <label for="price">Price per piece</label>
                                    <input type="text" name="price" class="form-control" id="price" placeholder="Enter Price" value="<?php if(!empty($single_data)){ echo $single_data->price; } ?>">
                                </div>
                                <div class="col-lg-3 col-md-6 col-12 form-group">
                                    <label for="brand">Brand Name</label>
                                    <input type="text" name="brand" class="form-control" id="brand" placeholder="Enter Brand Name">
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" name="submit" id="submit" class="btn btn-primary submitButton">
                                    <?php if(!empty($single_data)){ echo 'Update'; }else{ echo 'Submit';} ?>
                                </button>
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

<!-- Include jQuery library -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

<!-- Include jQuery Validate plugin -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script> -->

<script>
    $(document).ready(function() {
        $('#add_product').validate({
            rules: {
                productname: {
                    required: true,
                },
                Size: {
                    required: true,
                },
                unit: {
                    required: true,
                },
                price: {
                    required: true,
                    number: true
                },
                brand: {
                    required: true,
                }
            },
            messages: {
                productname: {
                    required: 'Please enter the product name.',
                },
                Size: {
                    required: 'Please enter the unit size.',
                },
                unit: {
                    required: 'select unit.',
                },
                price: {
                    required: 'Please enter the price.',
                    number: 'Please enter a valid number.'
                },
                brand: {
                    required: 'Please enter the brand name.',
                }
            }
        });
    });
</script>
