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
                            <h3 class="card-title"f>Add User <small></small></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="<?php echo base_url(); ?>addstaff" method="post" id="addstaff">
                            <div class="card-body">
                                <div class="row">
                                    <input type="hidden" name="id" class="form-control" id="id"
                                        value="<?php if(!empty($single_data)){ echo $single_data->id;} ?>">

                                    <div class="col-lg-4 col-md-3 col-12 form-group">
                                        <label for="full_name">Name</label>
                                        <input type="text" name="full_name" class="form-control" id="full_name"
                                            placeholder="Name"
                                            value="<?php if(!empty($single_data)){ echo $single_data->full_name;} ?>">
                                    </div>
                                    <div class="col-lg-4 col-md-3 col-12 form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" name="email" class="form-control" id="email"
                                            placeholder="Email"
                                            value="<?php if(!empty($single_data)){ echo $single_data->email;} ?>">
                                        <span id="emailError"></span>
                                    </div>
                                    <div class="col-lg-4 col-md-3 col-12 form-group">
                                        <label for="mobile_no">Mobile number</label>
                                        <input type="tel" name="mobile_no" class="form-control" id="mobile_no"
                                            placeholder="Contact Number" maxlength="10"
                                            value="<?php if(!empty($single_data)){ echo $single_data->mobile_no;} ?>">
                                        <span id="mobile_noError"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-3 col-12 form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" class="form-control" id="password"
                                            placeholder="Password"
                                            value="<?php if(!empty($single_data)){ echo $single_data->password;} ?>">
                                    </div>
                                    <div class="col-lg-4 col-md-3 col-12 form-group">
                                        <label for="confirm_pass"> Confirm Password</label>
                                        <input type="password" class="form-control" placeholder="Confirm Password"  id="confirm_pass"
                                            name="confirm_pass" value="<?php if(!empty($single_data)){ echo $single_data->password;} ?>" required>
                                    </div>
                                    <!-- <div class="col-lg-4 col-md-3 col-12 form-group">
                                        <label for="role">Role</label>
                                        <select class="form-control" id="role" name="role" required>
                                            <option value="" disabled selected>Select Role</option>
                                            <option value="Admin">Admin</option>
                                          
                                            <option value="Deliverypartner">Delivery Partner</option>
                                        </select>
                                    </div> -->
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Access Level</label>
                                            </div>
                                            <?php if (!empty($menu_data)) { $i = 1; ?>
                                            <?php foreach ($menu_data as $data) { ?>
                                            <div class="col-md-4">
                                                <input type="checkbox" id="Upload_b_d" name="accesslevel[]"
                                                    value="<?= $data->url_location; ?>" <?php 
                                                            if (isset($single_data) && is_object($single_data) && property_exists($single_data, 'accesslevel') && in_array($data->url_location, explode(',', $single_data->accesslevel))) {
                                                                echo 'checked';
                                                            } 
                                                            ?>>
                                                <label for="Upload_b_d"> <?= $data->menu_name; ?></label>
                                            </div>
                                            <?php $i++;
                                                } ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-right" >
                                <button type="submit" value="" name="submit" id="submit"
                                    class="btn btn-primary"><?php if(!empty($single_data)){ echo 'Update'; }else{ echo 'Submit';} ?></button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">
                </div>
                <!--/.col (right) -->
            </div>
        </div>
    </section>
</div>

<?php include __DIR__.'/../Admin/footer.php'; ?>

<style>
    .form-group span{
        color: red;
        font-size: 15px;
        padding-left: 4px;
    }
</style>
<script>
$(document).ready(function() {
    $('#addstaff').validate({
        rules: {
            full_name: {
                required: true,
            },
            // email: {
            //     required: true,
            //     email: true
            // },
            mobile_no: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            // role: {
            //     required: true,


            // },
            password: {
                required: true,
                minlength: 6
            },
            confirm_pass: {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            full_name: {
                required: 'Please enter your name.',
            },
            // email: {
            //     required: 'Please enter an email address.',
            //     email: 'Please enter a valid email address.'
            // },
            mobile_no: {
                required: 'Please enter your mobile number.',
                digits: 'Please enter only digits.',
                minlength: 'Mobile number should be exactly 10 digits.',
                maxlength: 'Mobile number should be exactly 10 digits.'
            },
            password: {
                required: 'Please provide a password.',
                minlength: 'Your password must be at least 6 characters long.'
            },
            confirm_pass: {
                required: 'Please confirm your password.',
                equalTo: 'Password and confirm password do not match.'
            },
            // role: {
            //     required: 'Please select role .',
            // },
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "email") {
                error.appendTo("#emailError");
            } else if (element.attr("name") == "mobile_no") {
                error.appendTo("#mobile_noError");
            } else {
                error.insertAfter(element);
            }
        }
    });
});
</script>