<?php include __DIR__.'/../customer/header.php'; ?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<style>
/* Ensure input looks clickable */
input[type="date"] {
    cursor: pointer;
}

input[type="time"] {
    cursor: pointer;
}
</style>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-6">
                <div class="col-12 col-md-12">
                    <div class="card author-box">
                        <div class="card-body" style="background-color:skyblue;">
                            <!-- Product Selection -->
                            <form action="orderbook" method="post" id="order_form" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="productDropdown">Product</label>

                                            <select class="form-control" id="productDropdown" name="productDropdown"
                                                onchange="updateProductDetails()">
                                                <option value="" disabled selected>Select a product</option>
                                                <?php foreach ($product as $item): ?>
                                                <option value="<?php echo $item->id ?>"
                                                    data-price="<?php echo $item->price ?>"
                                                    data-unit="<?php echo $item->unit ?>"
                                                    data-size="<?php echo $item->Size ?>"
                                                    <?php if(!empty($sproduct)){ echo ($item->id == $sproduct->id) ? 'selected' : '';} ?>>
                                                    <?php echo $item->productname ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Price for One Unit Display -->
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="pricePerUnit">Price Per Unit</label>
                                            <input type="number" class="form-control" id="pricePerUnit"
                                                name="pricePerUnit" min="1">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="unitOutput">Measure Unit</label>
                                            <input type="text" name="unit" class="form-control" id="unitOutput"
                                                readonly>
                                        </div>
                                    </div>
                                    <!-- Quantity Input -->
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="quantityInput">Quantity</label>
                                            <input type="number" class="form-control" id="quantityInput"
                                                name="quantityInput" placeholder="Quantity" min="1">
                                        </div>
                                    </div>
                                    <!-- Price Calculation -->
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="priceOutput">Price</label>
                                            <input type="text" name="price" class="form-control" id="priceOutput"
                                                readonly>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <!-- Unit Display -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="deliveryDate">Delivery Date</label>
                                            <input type="date" class="form-control" id="deliveryDate"
                                                name="deliveryDate" min="2024-01-01">
                                        </div>
                                    </div>
                                    <!-- Delivery Time Input -->
                                    <!-- <div class="col-lg-6">
                                        <div class="form-group">
                                        <label for="deliveryTime">Delivery Time</label>
                                        <input type="time" class="form-control" id="deliveryTime" name="deliveryTime">
                                        </div>
                                    </div> -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="deliveryTime">Delivery Time</label>
                                            <select class="form-control" id="deliveryTime" name="deliveryTime">
                                                <option value="">Select Time</option>
                                                <!-- Morning Option -->
                                                <option value="09:00-14:00">Morning (9 AM - 2 PM)</option>
                                                <!-- Evening Option -->
                                                <option value="16:00-18:00">Evening (4 PM - 6 PM)</option>
                                            </select>
                                            <label for="paymentMode"><b>(If You Orders after 2pm: Delivered next morning.)</b></label>
                                        </div>
                                    </div>

                                </div>
                                <!-- Payment Details -->
                                <label for="paymentMode"><b>Payment Details</b></label>

                                <div class="row mt-2">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="paymentMode">Payment Mode</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="paymentMode"
                                                    id="upiRadio" value="upi">
                                                <label class="form-check-label" for="upiRadio">
                                                    UPI
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="paymentMode"
                                                    id="cashRadio" value="cash">
                                                <label class="form-check-label" for="cashRadio">
                                                    Cash On Delivery
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group" style="width: 116px; height: 112px;"
                                            id="qrCodeContainer">
                                            <img alt="QR Code"
                                                src="<?=base_url(); ?>public/assets/img/users/QRcodeMrunalMam.jpg"
                                                class="img-fluid mt-2" style="display: none;">
                                        </div>
                                    </div>
                                    <!-- UPI Transaction ID Input -->
                                    <div class="col-lg-4">
                                        <div class="form-group" id="upiTransaction" style="display: none;">
                                            <label for="transactionIdInput">Transaction ID</label>
                                            <input type="text" class="form-control" id="transactionIdInput"
                                                placeholder="Transaction ID" name="transactionIdInput">
                                        </div>
                                    </div>
                                    <!-- Screenshot Attachment -->
                                    <div class="col-lg-4">
                                        <div class="form-group" id="screenshotAttachment" style="display: none;">
                                            <label for="screenshotInput">Upload Screenshot</label>
                                            <input type="file" class="form-control-file" id="screenshotInput"
                                                name="screenshotInput" style="border-radius: 5px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="upiDetailsRow" style="display: none;">
                                    <div class="col-lg-4">
                                        <div class="input-group mt-3">
                                            <input type="text" class="form-control" id="upiIdInput"
                                                value="upi_id@example.com" readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary btn-sm" type="button"
                                                    id="copyButton"
                                                    style="font-weight: bold; color: black; height: 2.6rem; border-color: gray;">Copy</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Submit Button -->
                                <div class="row mt-4">
                                    <div class="col-lg-12 text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include __DIR__.'/../customer/footer.php'; ?>

<style>
.row label {
    color: black;
    font-size: 15px;
    padding-left: 4px;
}

.row input {
    background: linear-gradient(to right, #dfe9f1, white, white);
}

.row select {
    background: linear-gradient(to right, #dfe9f1, white, white);
}

.form-check-input[type="radio"] {
    width: 22px;
    height: 22px;
}

.form-group input[type="file"]::-webkit-file-upload-button {
    background-color: gray;
    color: white;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    height: 2.6rem;
}

.form-group input[type="file"]::-webkit-file-upload-button:hover {
    background-color: blue;
}

.btn-primary {
    width: 150px;
    height: 40px;
    font-size: 20px;
}
</style>

<script>
// JavaScript to toggle visibility of UPI fields and QR code
document.addEventListener('DOMContentLoaded', function() {
    var upiRadio = document.getElementById('upiRadio');
    var cashRadio = document.getElementById('cashRadio');
    var upiTransaction = document.getElementById('upiTransaction');
    var screenshotAttachment = document.getElementById('screenshotAttachment');
    var qrCodeContainer = document.getElementById('qrCodeContainer');
    var qrCodeImg = qrCodeContainer.querySelector('img');
    var transactionIdInput = document.getElementById('transactionIdInput');
    var upiDetailsRow = document.getElementById('upiDetailsRow');
    var copyButton = document.getElementById('copyButton');
    var upiIdInput = document.getElementById('upiIdInput');

    var productDropdown = document.getElementById('productDropdown');
    var pricePerUnit = document.getElementById('pricePerUnit');
    var quantityInput = document.getElementById('quantityInput');
    var priceOutput = document.getElementById('priceOutput');
    var unitOutput = document.getElementById('unitOutput');

    function updatePriceAndUnit() {
        var selectedOption = productDropdown.options[productDropdown.selectedIndex];
        if (selectedOption) {
            var price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
            var unit = selectedOption.getAttribute('data-unit') || '0';
            var size = selectedOption.getAttribute('data-size') || '0';
            var quantity = parseInt(quantityInput.value) || 0;
            pricePerUnit.value = price.toFixed(2);
            priceOutput.value = (price * quantity).toFixed(2);
            unitOutput.value = size + ' (' + unit + ')';
        } else {
            // If no product is selected, set price and unit to 0
            pricePerUnit.value = '0.00';
            priceOutput.value = '0.00';
            unitOutput.value = '0';
        }
    }

    // Ensure UPI radio button is initially checked
    upiRadio.checked = true;
    qrCodeImg.style.display = 'block'; // Show QR code image
    upiTransaction.style.display = 'block';
    screenshotAttachment.style.display = 'block';
    upiDetailsRow.style.display = 'flex'; // Show UPI details row

    upiRadio.addEventListener('change', function() {
        if (upiRadio.checked) {
            qrCodeImg.style.display = 'block'; // Show QR code image
            upiTransaction.style.display = 'block';
            screenshotAttachment.style.display = 'block';
            upiDetailsRow.style.display = 'flex'; // Show UPI details row
        }
    });

    cashRadio.addEventListener('change', function() {
        if (cashRadio.checked) {
            qrCodeImg.style.display = 'none'; // Hide QR code image
            upiTransaction.style.display = 'none';
            screenshotAttachment.style.display = 'none';
            upiDetailsRow.style.display = 'none'; // Hide UPI details row
            transactionIdInput.value = ''; // Clear transaction ID input if cash is selected
        }
    });

    copyButton.addEventListener('click', function() {
        upiIdInput.select();
        document.execCommand('copy');
        alert('UPI ID copied to clipboard');
    });

    productDropdown.addEventListener('change', updatePriceAndUnit);
    quantityInput.addEventListener('input', updatePriceAndUnit);

    // Initial price and unit calculation
    updatePriceAndUnit();
});
</script>

<script>
$(document).ready(function() {
    $('#order_form').validate({
        rules: {
            productDropdown: {
                required: true,
            },
            quantityInput: {
                required: true,
                min: 1,
            },
            deliveryDate: {
                required: true,
            },
            deliveryTime: {
                required: true,
            },
            paymentMode: {
                required: true,
            },
            transactionIdInput: {
                required: function(element) {
                    return $('#upiRadio').is(':checked') && $('#screenshotInput').val() === '';
                }
            },
            screenshotInput: {
                required: function(element) {
                    return $('#upiRadio').is(':checked') && $('#transactionIdInput').val() === '';
                }
            }
        },
        messages: {
            productDropdown: {
                required: 'Please select a product.',
            },
            quantityInput: {
                required: 'Please enter the quantity.',
                min: 'Quantity must be at least 1.'
            },
            deliveryDate: {
                required: 'Please enter the delivery date.',
            },
            deliveryTime: {
                required: 'Please enter the delivery time.',
            },
            paymentMode: {
                required: 'Please select a payment mode.',
            },
            transactionIdInput: {
                required: 'Please enter the transaction ID or upload a screenshot.',
            },
            screenshotInput: {
                required: 'Please upload a screenshot or enter the transaction ID.',
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "screenshotInput") {
                error.appendTo("#screenshotAttachment");
            } else if (element.attr("name") == "transactionIdInput") {
                error.appendTo("#upiTransaction");
            } else {
                error.insertAfter(element);
            }
        }
    });
});
</script>
<script>
// Set the min attribute to today's date in the format YYYY-MM-DD
var today = new Date().toISOString().split('T')[0];
document.getElementById('deliveryDate').setAttribute('min', today);
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const dateInput = document.getElementById('deliveryDate');

    // Ensure the date picker opens on focus
    dateInput.addEventListener('focus', function() {
        dateInput.showPicker(); // Using showPicker() for modern browsers
    });

    // Click event to ensure the date picker opens
    dateInput.addEventListener('click', function() {
        dateInput.showPicker(); // This method is supported in some modern browsers
    });
});
</script>

<!-- <script>
document.addEventListener("DOMContentLoaded", function() {
    const timeInput = document.getElementById('deliveryTime');

    // Ensure the time picker opens on focus
    timeInput.addEventListener('focus', function() {
        if (typeof timeInput.showPicker === "function") {
            timeInput.showPicker(); // Using showPicker() for modern browsers
        } else {
            timeInput.click(); // Fallback for browsers without showPicker()
        }
    });

    // Click event to ensure the time picker opens
    timeInput.addEventListener('click', function() {
        if (typeof timeInput.showPicker === "function") {
            timeInput.showPicker(); // This method is supported in some modern browsers
        } else {
            timeInput.focus(); // Fallback for older browsers
        }
    });
});
</script> -->