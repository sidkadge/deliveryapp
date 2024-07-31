<?php include __DIR__.'/../customer/header.php'; ?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>
<style>
/* Ensure input looks clickable */
input[type="date"], input[type="time"] {
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
                                            <select class="form-control" id="productDropdown" name="productDropdown">
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
                                    <div class="col-lg-2" id="pricePerUnitDiv">
                                        <div class="form-group">
                                            <label for="pricePerUnit">Price Per Unit</label>
                                            <input type="number" class="form-control" id="pricePerUnit"
                                                name="pricePerUnit" min="1" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-2" id="unitOutputDiv">
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
                                    <!-- Delivery Date -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="deliveryDate">Delivery Date</label>
                                            <input type="date" class="form-control" id="deliveryDate"
                                                name="deliveryDate" min="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                    <!-- Delivery Time -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="deliveryTime">Delivery Time</label>
                                            <select class="form-control" id="deliveryTime" name="deliveryTime">
                                                <option value="">Select Time</option>
                                                <option value="09:00-14:00">Morning (9 AM - 2 PM)</option>
                                                <option value="16:00-18:00">Evening (4 PM - 6 PM)</option>
                                            </select>
                                            <label for="paymentMode"><b>(Orders placed after 2 PM will be delivered the next morning.)</b></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Payment Details -->
                                <label for="paymentMode"><b>Payment Details</b></label>
                                <div class="row mt-2">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>Payment Mode</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="paymentMode" id="upiRadio" value="upi">
                                                <label class="form-check-label" for="upiRadio">
                                                    UPI
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="paymentMode" id="cashRadio" value="cash">
                                                <label class="form-check-label" for="cashRadio">
                                                    Cash On Delivery
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              
                                <div class="row mt-4">
                                    <div class="col-lg-12 text-center">
                                        <button type="button" class="btn btn-primary" id="submitButton">Submit</button>
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
.row span {
    color: red;
    font-size: 15px;
    padding-left: 4px;
}

.row input, .row select {
    background: linear-gradient(to right, #dfe9f1, white, white);
}

.form-check-input[type="radio"] {
    width: 22px;
    height: 22px;
}

.btn-primary {
    width: 150px;
    height: 40px;
    font-size: 20px;
}
</style>

<script>
// JavaScript to handle form and payment logic
document.addEventListener('DOMContentLoaded', function() {
    var upiRadio = document.getElementById('upiRadio');
    var cashRadio = document.getElementById('cashRadio');
    var productDropdown = document.getElementById('productDropdown');
    var pricePerUnit = document.getElementById('pricePerUnit');
    var quantityInput = document.getElementById('quantityInput');
    var priceOutput = document.getElementById('priceOutput');
    var unitOutput = document.getElementById('unitOutput');
    var pricePerUnitDiv = document.getElementById('pricePerUnitDiv');
    var unitOutputDiv = document.getElementById('unitOutputDiv');
    var transaction_id = document.createElement('input');
    transaction_id.type = 'hidden';
    transaction_id.name = 'transaction_id';
    transaction_id.id = 'transaction_id';
    document.getElementById('order_form').appendChild(transaction_id);

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
            pricePerUnit.value = '0.00';
            priceOutput.value = '0.00';
            unitOutput.value = '0';
        }
    }

    function toggleFields() {
        if (productDropdown.value) {
            pricePerUnitDiv.style.display = 'block';
            unitOutputDiv.style.display = 'block';
        } else {
            pricePerUnitDiv.style.display = 'none';
            unitOutputDiv.style.display = 'none';
        }
    }

    function handleFormSubmission(event) {
        event.preventDefault(); // Prevent form submission
        if (upiRadio.checked) {
            loadRazorpayScript(function() {
                var options = {
                    "key": "rzp_test_QdPDZO6x3F9kBz", // Replace with your Razorpay Key ID
                    "amount": (parseFloat(priceOutput.value) * 100), // Amount in paise
                    "currency": "INR",
                    "name": "Your Company",
                    "description": "Order Payment",
                    "handler": function (response) {
                        alert('Payment successful: ' + response.razorpay_payment_id);
                        transaction_id.value = response.razorpay_payment_id;
                        document.getElementById('order_form').submit(); // Submit form on successful payment
                    },
                    "prefill": {
                        "name": "Customer Name",
                        "email": "customer@example.com",
                        "contact": "9876543210"
                    }
                };
                var rzp = new Razorpay(options);
                rzp.open();
            });
        } else {
            // If Cash On Delivery, submit the form directly
            document.getElementById('order_form').submit();
        }
    }

    productDropdown.addEventListener('change', function() {
        updatePriceAndUnit();
        toggleFields();
    });

    quantityInput.addEventListener('input', updatePriceAndUnit);

    document.getElementById('submitButton').addEventListener('click', function(event) {
        if ($('#order_form').valid()) {
            handleFormSubmission(event);
        }
    });

    function loadRazorpayScript(callback) {
        var script = document.createElement('script');
        script.src = 'https://checkout.razorpay.com/v1/checkout.js';
        script.onload = callback;
        document.head.appendChild(script);
    }

    // Call updatePriceAndUnit() on page load to handle pre-selected product
    updatePriceAndUnit();

    // Initialize form validation
    $('#order_form').validate({
        rules: {
            productDropdown: {
                required: true
            },
            quantityInput: {
                required: true,
                digits: true,
                min: 1
            },
            deliveryDate: {
                required: true,
                dateISO: true
            },
            deliveryTime: {
                required: true
            },
            paymentMode: {
                required: true
            }
        },
        messages: {
            productDropdown: {
                required: "Please select a product."
            },
            quantityInput: {
                required: "Please enter a quantity.",
                digits: "Please enter a valid number.",
                min: "Quantity must be at least 1."
            },
            deliveryDate: {
                required: "Please select a delivery date.",
                dateISO: "Please enter a valid date."
            },
            deliveryTime: {
                required: "Please select a delivery time."
            },
            paymentMode: {
                required: "Please select a payment mode."
            }
        }
    });
});
</script>
