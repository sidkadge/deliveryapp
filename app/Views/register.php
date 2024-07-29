<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Delivery App</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?=base_url(); ?>public/assets/css/app.min.css">
    <link rel="stylesheet" href="<?=base_url(); ?>public/assets/bundles/jquery-selectric/selectric.css">
    <!-- Template CSS -->
    <link rel="stylesheet" href="<?=base_url(); ?>public/assets/css/style.css">
    <link rel="stylesheet" href="<?=base_url(); ?>public/assets/css/components.css">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="<?=base_url(); ?>public/assets/css/custom.css">
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
                        <div class="card card-primary" style="background-image: linear-gradient(184deg, #2b7bc4 0%, #d0dce49e 100%);">
                            <div class="card-header">
                                <h4>Customer Register</h4>
                            </div>
                            <div class="card-body">
                                <form id="adminForm" method="POST" action="<?=base_url(); ?>register">
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
                                    <div class="row">
                                        <div class="form-group col-4">
                                            <label for="Alternate_name">Alternate Contact person Name</label>
                                            <input id="Alternate_name" type="text" class="form-control" name="Alternate_name">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="Alternatenumber">Alternate Contact Number</label>
                                            <input id="Alternatenumber" type="tel" class="form-control" name="Alternatenumber">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="location">Location (Google Map Link)</label>
                                            <input id="location" type="url" class="form-control" name="location">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-4">
                                            <label for="Zone">Zone (Area)*</label>
                                            <select id="Zone" class="form-control" name="Zone">
                                                <option value="">Select Zone</option>
                                                <?php foreach ($zones as $zone) : ?>
                                                <option value="<?= $zone->id; ?>"><?= $zone->zone; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="Societyname">Society Name</label>
                                            <select id="Societyname" class="form-control" name="Societyname">
                                                <option value="">Select Society</option>
                                                <!-- Societies will be loaded here based on selected Zone -->
                                                <option value="Other">Other</option>
                                            </select>
                                            <input type="text" id="OtherSocietyname" class="form-control" name="OtherSocietyname" style="display:none;" placeholder="Enter Society Name">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="Buildingname">Building Name</label>
                                            <select id="Buildingname" class="form-control" name="Buildingname">
                                                <option value="">Select Building</option>
                                                <!-- Buildings will be loaded here based on selected Society -->
                                                <option value="Other">Other</option>
                                            </select>
                                            <input type="text" id="OtherBuildingname" class="form-control" name="OtherBuildingname" style="display:none;" placeholder="Enter Building Name">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-2">
                                            <label for="Floor">Floor No *</label>
                                            <input id="Floor" type="text" class="form-control" name="Floor">
                                        </div>
                                        <div class="form-group col-2">
                                            <label for="Flat">Flat No *</label>
                                            <input id="Flat" type="text" class="form-control" name="Flat">
                                        </div>
                                        <div class="form-group col-8">
                                            <label for="Address">Address</label>
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
                                        <button type="submit" class="btn btn-primary btn-lg" id="registerButton" disabled>Register</button>
                                    </div>
                                </form>
                            </div>
                            <div class="mb-4 text-muted text-center">
                                Already Registered? <a href="<?=base_url(); ?>login">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- General JS Scripts -->
    <script src="<?=base_url(); ?>public/assets/js/app.min.js"></script>
    <!-- JS Libraries -->
    <script src="<?=base_url(); ?>public/assets/bundles/jquery-pwstrength/jquery.pwstrength.min.js"></script>
    <script src="<?=base_url(); ?>public/assets/bundles/jquery-selectric/jquery.selectric.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <!-- Page Specific JS File -->
    <script src="<?=base_url(); ?>public/assets/js/page/auth-register.js"></script>
    <!-- Template JS File -->
    <script src="<?=base_url(); ?>public/assets/js/scripts.js"></script>
    <!-- Custom JS File -->
    <script src="<?=base_url(); ?>public/assets/js/custom.js"></script>

    <script>
    $(document).ready(function() {
        $('#Zone').change(function() {
            var zoneId = $(this).val();
            if (zoneId) {
                $.ajax({
                    url: '<?= base_url(); ?>getSocietiesByZone',
                    type: 'POST',
                    data: { zone_id: zoneId },
                    dataType: 'json',
                    success: function(data) {
                        $('#Societyname').html('<option value="">Select Society</option>');
                        $.each(data, function(key, value) {
                            $('#Societyname').append('<option value="' + value.id + '">' + value.Societyname + '</option>');
                        });
                        $('#Societyname').append('<option value="Other">Other</option>'); // Always add "Other" option
                    }
                });
            } else {
                $('#Societyname').html('<option value="">Select Society</option>');
                $('#Societyname').append('<option value="Other">Other</option>'); // Always add "Other" option
            }
        });

        $('#Societyname').change(function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'Other') {
                $(this).hide();
                $('#OtherSocietyname').show().attr('required', true);
            } else {
                $('#OtherSocietyname').hide().removeAttr('required');
            }

            var societyId = $(this).val();
            var zoneId = $('#Zone').val();
            if (societyId && zoneId) {
                $.ajax({
                    url: '<?= base_url(); ?>getBuildingsBySociety',
                    type: 'POST',
                    data: { zone_id: zoneId, society_id: societyId },
                    dataType: 'json',
                    success: function(data) {
                        $('#Buildingname').html('<option value="">Select Building</option>');
                        $.each(data, function(key, value) {
                            $('#Buildingname').append('<option value="' + value.id + '">' + value.Buildingname + '</option>');
                        });
                        $('#Buildingname').append('<option value="Other">Other</option>'); // Always add "Other" option
                    }
                });
            } else {
                $('#Buildingname').html('<option value="">Select Building</option>');
                $('#Buildingname').append('<option value="Other">Other</option>'); // Always add "Other" option
            }
        });

        $('#Buildingname').change(function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'Other') {
                $(this).hide();
                $('#OtherBuildingname').show().attr('required', true);
            } else {
                $('#OtherBuildingname').hide().removeAttr('required');
            }
        });

        // Validation
        $('#adminForm').validate({
            rules: {
                full_name: {
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
                password: {
                    required: true,
                    customPassword: true
                },
                confirm_pass: {
                    required: true,
                    equalTo: '#password'
                },
                Zone: {
                    required: true
                },
                Societyname: {
                    required: true
                },
                OtherSocietyname: {
                    required: function() {
                        return $('#Societyname').val() === 'Other';
                    }
                },
                Buildingname: {
                    required: true
                },
                OtherBuildingname: {
                    required: function() {
                        return $('#Buildingname').val() === 'Other';
                    }
                },
                Floor: {
                    required: true
                },
                Flat: {
                    required: true
                }
            },
            messages: {
                full_name: "Please enter your full name",
                email: "Please enter a valid email address",
                mobile_no: "Please enter a valid phone number",
                password: {
                    required: "Please provide a password",
                    customPassword: "Password must contain at least one uppercase letter, one lowercase letter, one number, and one symbol (!@#$%^&*) and be at least 8 characters long."
                },
                confirm_pass: {
                    required: "Please provide a password",
                    equalTo: "Please enter the same password as above"
                },
                Zone: "Please select a zone",
                Societyname: "Please select or enter a society name",
                OtherSocietyname: "Please enter your society name",
                Buildingname: "Please select or enter a building name",
                OtherBuildingname: "Please enter your building name",
                Floor: "Please enter the floor number",
                Flat: "Please enter the flat number"
            },
            errorElement: 'label',
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });

        // Enable/disable the register button based on the terms and conditions checkbox
        $('#agree').on('change', function() {
            $('#registerButton').prop('disabled', !this.checked);
        });
    });
    </script>
</body>

</html>
