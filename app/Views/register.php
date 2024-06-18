<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Delivery App</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="public/assets/css/app.min.css">
    <link rel="stylesheet" href="public/assets/bundles/jquery-selectric/selectric.css">
    <!-- Template CSS -->
    <link rel="stylesheet" href="public/assets/css/style.css">
    <link rel="stylesheet" href="public/assets/css/components.css">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="public/assets/css/custom.css">
    <link rel='shortcut icon' type='image/x-icon' href='public/assets/img/favicon.ico' />
    <style>
        /* Style for required field labels */
        label.error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Customer Register</h4>
                            </div>
                            <div class="card-body">
                                <form id="adminForm" method="POST" action="<?php base_url()?>register">
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label for="first_name">User Name *</label>
                                            <input id="first_name" type="text" class="form-control" name="full_name" autofocus>
                                        </div>
                                       
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="email">Email *</label>
                                            <input id="email" type="email" class="form-control" name="email">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="phonenumber">Phone Number *</label>
                                            <input id="phonenumber" type="tel" class="form-control" name="mobile_no">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <!-- <label for="Alternate_name">Contact Person Details</label> -->
                                    <div class="row">
                                   
                                        <div class="form-group col-6">
                                            <label for="Alternate_name">Alternate Contact person Name</label>
                                            <input id="Alternate_name" type="text" class="form-control" name="Alternate_name">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="Alternatenumber">Alternate Contact Number</label>
                                            <input id="Alternatenumber" type="tel" class="form-control" name="Alternatenumber">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-2">
                                            <label for="Flat">Flat No *</label>
                                            <input id="Flat" type="text" class="form-control" name="Flat">
                                        </div>
                                        <div class="form-group col-2">
                                            <label for="Floor">Floor No *</label>
                                            <input id="Floor" type="text" class="form-control" name="Floor">
                                        </div>
                                        <div class="form-group col-8">
                                            <label for="Address">Address(Add Building Name*)</label>
                                            <input id="Address" type="text" class="form-control" name="Address">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="password" class="d-block">Password *</label>
                                            <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password">
                                            <label for="password" class="d-block">(8 characters -1 uppercase,1 numeric,1 special character)</label>
                                            <div id="pwindicator" class="pwindicator">
                                                <div class="bar"></div>
                                                <div class="label"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="password2" class="d-block">Confirm Password *</label>
                                            <input id="password2" type="password" class="form-control" name="confirm_pass">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="agree" class="custom-control-input" id="agree">
                                            <label class="custom-control-label" for="agree">I agree with the terms and conditions</label>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-primary btn-lg " id="registerButton" disabled>Register</button>
                                    </div>
                                </form>
                            </div>
                            <div class="mb-4 text-muted text-center">
                                Already Registered? <a href="<?php base_url()?>login">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- General JS Scripts -->
    <script src="public/assets/js/app.min.js"></script>
    <!-- JS Libraries -->
    <script src="public/assets/bundles/jquery-pwstrength/jquery.pwstrength.min.js"></script>
    <script src="public/assets/bundles/jquery-selectric/jquery.selectric.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <!-- Page Specific JS File -->
    <script src="public/assets/js/page/auth-register.js"></script>
    <!-- Template JS File -->
    <script src="public/assets/js/scripts.js"></script>
    <!-- Custom JS File -->
    <script src="public/assets/js/custom.js"></script>

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

            $('#adminForm').validate({
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
            $('#agree').on('change', function() {
                $('#registerButton').prop('disabled', !this.checked);
            });
        });
    </script>
</body>

</html>

                   
