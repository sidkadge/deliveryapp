<?php include __DIR__.'/../Admin/header.php'; ?>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="background-color: #afeae2">
                        <div class="card-header">
                            <h3 class="card-title">Add Customer</h3>
                        </div>
                        <div class="card-body">
                            <form id="addCoustmersbyadmin" method="post" action="<?=base_url(); ?>addCoustmersbyadmin">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="first_name">User Name</label>
                                        <input id="first_name" type="text" class="form-control" name="full_name"
                                            autofocus>
                                    </div>
                                    <!-- <div class="form-group col-6">
                                            <label for="last_name">Last Name</label>
                                            <input id="last_name" type="text" class="form-control" name="last_name">
                                        </div> -->
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" name="email">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="phonenumber">Phone Number</label>
                                        <input id="phonenumber" type="tel" class="form-control" name="mobile_no">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <label for="Alternate_name">Contact Person Details</label>
                                <div class="row">

                                    <div class="form-group col-6">
                                        <label for="Alternate_name">Alternate Name</label>
                                        <input id="Alternate_name" type="text" class="form-control"
                                            name="Alternate_name">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="Alternatenumber">Alternate Phone Number</label>
                                        <input id="Alternatenumber" type="tel" class="form-control"
                                            name="Alternatenumber">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-2">
                                        <label for="Flat">Flat No</label>
                                        <input id="Flat" type="text" class="form-control" name="Flat">
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="Floor">Floor No</label>
                                        <input id="Floor" type="text" class="form-control" name="Floor">
                                    </div>
                                    <div class="form-group col-8">
                                        <label for="Address">Address(Add Building Name*)</label>
                                        <input id="Address" type="text" class="form-control" name="Address">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="password" class="d-block">Password</label>
                                        <input id="password" type="password" class="form-control pwstrength"
                                            data-indicator="pwindicator" name="password">
                                        <div id="pwindicator" class="pwindicator">
                                            <div class="bar"></div>
                                            <div class="label"></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="password2" class="d-block">Password Confirmation</label>
                                        <input id="password2" type="password" class="form-control" name="confirm_pass">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include __DIR__.'/../Admin/footer.php'; ?>
<script>
$(document).ready(function() {
    $.validator.addMethod("lettersOnly", function(value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "Please enter letters only.");

    $.validator.addMethod("mobile", function(value, element) {
        return this.optional(element) || /^\d{10}$/.test(value);
    }, "Please enter a 10 digit mobile number.");

    $.validator.addMethod('customPassword', function(value, element) {
            // Password must contain at least one uppercase letter, one lowercase letter, one number, and one symbol. It should be at least 8 characters long.
            return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[a-zA-Z\d!@#$%^&*]{8,}$/.test(value);
        },
        'Password must contain at least one uppercase letter, one lowercase letter, one number, and one symbol (!@#$%^&*) and be at least 8 characters long'
    );

    $('#addCoustmersbyadmin').validate({
        rules: {
            full_name: {
                required: true,
                lettersOnly: true
            },
            last_name: {
                required: true,
                lettersOnly: true
            },
            email: {
                required: true,
                email: true
            },
            mobile_no: {
                required: true,
                mobile: true
            },
            Flat: {
                required: true
            },
            Floor: {
                required: true
            },
            Address: {
                required: true
            },
            password: {
                required: true,
                customPassword: true
            },
            confirm_pass: {
                required: true,
                equalTo: '#password'
            }
        },
        messages: {
            full_name: {
                required: 'Please enter your name.',
                lettersOnly: 'Please enter letters only.'
            },
            last_name: {
                required: 'Please enter your last name.',
                lettersOnly: 'Please enter letters only.'
            },
            email: {
                required: 'Please enter your email address.',
                email: 'Please enter a valid email address.'
            },
            mobile_no: {
                required: 'Please enter your mobile number.',
                mobile: 'Please enter a 10 digit mobile number.'
            },
            Flat: {
                required: 'Please enter your flat number.'
            },
            Floor: {
                required: 'Please enter your floor number.'
            },
            Address: {
                required: 'Please enter your address.'
            },
            password: {
                required: "Password is required.",
                customPassword: "Password must contain at least one uppercase letter, one lowercase letter, one number, and be at least 8 characters long."
            },
            confirm_pass: {
                required: 'Please confirm your password.',
                equalTo: 'Passwords do not match.'
            }
        },

        // Check and hide error message dynamically
        success: function(label, element) {
            $(element).siblings('label.error').hide();
        }
    });

    // Hide error messages for password match and complexity if valid


    // Enable/disable the register button based on the terms and conditions checkbox

});
</script>