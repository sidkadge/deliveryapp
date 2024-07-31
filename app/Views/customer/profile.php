<?php include __DIR__.'/../customer/header.php'; ?>
<style>label {display:flex;}</style>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-6">
                <div class="col-12 col-md-12 col-lg-8">
                    <div class="card author-box">
                        <div class="card-body" style="background-color:skyblue;">
                            <div class="author-box-center">
                                <img alt="image" src="<?=base_url(); ?>public/assets/img/users/user1.png" class="rounded-circle author-box-picture">
                                <div class="clearfix"></div>
                                <div class="author-box-name">
                                    <a href="#"><?= htmlspecialchars($customerData->full_name) ?></a>
                                </div>
                                <div class="author-box-job"></div>
                            </div>
                            <div class="text-center">
                                <form id="customer-form" class="form-horizontal" action="Updateprofile" method="post">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="full_name">Full Name</label>
                                            <input type="text" class="form-control" id="full_name" name="full_name" value="<?= htmlspecialchars($customerData->full_name) ?>" readonly>
                                        </div>
                                       
                                    </div>
                                    <div class="row">
                                    <div class="col-md-6 mb-3">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($customerData->email) ?>" readonly>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="mobile_no">Mobile No</label>
                                            <input type="text" class="form-control" id="mobile_no" name="mobile_no" value="<?= htmlspecialchars($customerData->mobile_no) ?>" readonly>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="mobile_no">Password</label>
                                            <input type="text" class="form-control" id="password" name="password" value="<?= htmlspecialchars($customerData->password) ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="alternate_name">Alternate Name</label>
                                            <input type="text" class="form-control" id="alternate_name" name="alternate_name" value="<?= htmlspecialchars($customerData->alternate_name) ?>" readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="alternate_number">Contact Number(AL)</label>
                                            <input type="text" class="form-control" id="alternate_number" name="alternate_number" value="<?= htmlspecialchars($customerData->alternate_number) ?>" readonly>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="flat">Flat No</label>
                                            <input type="text" class="form-control" id="flat" name="flat" value="<?= htmlspecialchars($customerData->flat) ?>" readonly>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="floor">Floor No</label>
                                            <input type="text" class="form-control" id="floor" name="floor" value="<?= htmlspecialchars($customerData->floor) ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                        <div class="col-md-12 mb-3">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($customerData->address) ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                        <div class="col-md-12 mb-3">
                                            <label for="address">location (google map)</label>
                                            <input type="text" class="form-control" id="location" name="location" value="<?= htmlspecialchars($customerData->location) ?>" readonly>
                                        </div>
                                    </div>
                                    <button type="button" id="edit-button" class="btn btn-primary" onclick="toggleEdit()">Edit</button>
                                    <button type="submit" id="save-button" class="btn btn-success" style="display:none;">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<style>
    .row label{
        color: black;
        font-size: 15px;
        padding-left: 4px;
    }
    .row input{
        background: linear-gradient(to right,#dfe9f1,white,white);
    }
    .row select{
        background: linear-gradient(to right,#dfe9f1,white,white);
    }
    .btn-primary {
        width: 150px;
        height: 40px;
        font-size: 20px;
    }
</style>

<script>
function toggleEdit() {
    var form = document.getElementById('customer-form');
    var elements = form.elements;
    for (var i = 0; i < elements.length; i++) {
        elements[i].readOnly = !elements[i].readOnly;
    }
    document.getElementById('edit-button').style.display = 'none';
    document.getElementById('save-button').style.display = 'inline-block';
}

document.getElementById('customer-form').onsubmit = function(e) {
    e.preventDefault();

    var formData = new FormData(this);

    fetch('Updateprofile', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Profile updated successfully!');
            window.location.reload();
        } else {
            alert('Failed to update profile. Please try again.');
        }
    })
    .catch(error => console.error('Error:', error));
};
</script>

<?php include __DIR__.'/../customer/footer.php'; ?>
