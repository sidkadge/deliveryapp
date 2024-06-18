<?php include __DIR__.'/../customer/header.php'; ?>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-6">
                <div class="col-12 col-md-12">
                    <div class="card author-box">
                        <div class="card-body">
                            <!-- Product Selection -->
                            <form id="order_form" enctype="multipart/form-data">
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
                                                    data-size="<?php echo $item->Size ?>">
                                                    <?php echo $item->productname ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Price for One Unit Display -->
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="pricePerUnit">Price For One Unit</label>
                                            <input type="number" class="form-control" id="pricePerUnit"
                                                name="pricePerUnit" readonly>
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
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="unitOutput">Unit</label>
                                            <input type="text" name="unit" class="form-control" id="unitOutput"
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
                                                name="deliveryDate" min="">
                                        </div>
                                    </div>
                                    <!-- Delivery Time Input -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="deliveryTime">Delivery Time</label>
                                            <input type="time" class="form-control" id="deliveryTime"
                                                name="deliveryTime">
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
                                                    id="cashRadio" value="cash" checked>
                                                <label class="form-check-label" for="cashRadio">
                                                    Cash On Delivery
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Submit Button -->
                                <div class="row mt-4">
                                    <div class="col-lg-12 text-center">
                                        <button type="button" id="paymentButton" class="btn btn-primary">Submit</button>
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

<!-- Include Razorpay Checkout Script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var productDropdown = document.getElementById('productDropdown');
    var pricePerUnit = document.getElementById('pricePerUnit');
    var quantityInput = document.getElementById('quantityInput');
    var priceOutput = document.getElementById('priceOutput');
    var unitOutput = document.getElementById('unitOutput');
    var upiRadio = document.getElementById('upiRadio');
    var cashRadio = document.getElementById('cashRadio');

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

    productDropdown.addEventListener('change', updatePriceAndUnit);
    quantityInput.addEventListener('input', updatePriceAndUnit);
    updatePriceAndUnit(); // Initial price and unit calculation

    // Set the min attribute to today's date in the format YYYY-MM-DD
    var today = new Date().toISOString().split('T')[0];
    document.getElementById('deliveryDate').setAttribute('min', today);

    // Handle Razorpay Payment
    document.getElementById('paymentButton').addEventListener('click', function() {
        var price = parseFloat(document.getElementById('priceOutput').value) * 100; // Amount in paise

        if (upiRadio.checked) {
            var options = {
                "key": "rzp_test_QdPDZO6x3F9kBz", // Replace with your Razorpay API Key
                "amount": price, // Amount in paise
                "currency": "INR",
                "name": "Your Company Name",
                "description": "Purchase Description",
                "image": "https://example.com/your_logo.jpg", // Replace with your logo URL
                "handler": function(response) {
                    console.log(response);
                    alert("Payment Successful! ID: " + response.razorpay_payment_id);

                    // Post payment details to your server
                    var formData = new FormData(document.getElementById('order_form'));
                    formData.append('razorpay_payment_id', response.razorpay_payment_id);

                    fetch('Home/paymentsucess', {
                        method: 'POST',
                        body: formData
                    }).then(response => response.json())
                      .then(data => {
                          console.log(data);
                          // Handle success response
                          alert("Order placed successfully!");
                      }).catch(error => {
                          console.error(error);
                          // Handle error response
                          alert("Failed to place the order.");
                      });
                },
                "prefill": {
                    "name": "Customer Name",
                    "email": "customer@example.com",
                    "contact": "9999999999"
                },
                "notes": {
                    "address": "Customer Address"
                },
                "theme": {
                    "color": "#3399cc"
                },
                "method": {
                    "upi": true, // Enable UPI payment method
                    "card": false,
                    "netbanking": false,
                    "wallet": false
                },
                "modal": {
                    "ondismiss": function() {
                        // Optionally handle user cancel action
                        alert("Payment cancelled by user");
                    }
                }
            };

            var rzp1 = new Razorpay(options);
            rzp1.open();
        } else {
            // Submit form normally for cash payment
            document.getElementById('order_form').submit();
        }
    });
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

    // Handle Razorpay Payment
    $('#paymentButton').click(function() {
        if ($('#order_form').valid()) { // Check if form is valid
            var price = parseFloat($('#priceOutput').val()) * 100; // Amount in paise
            if ($('#upiRadio').is(':checked')) {
                // Handle UPI payment
                var options = {
                    // Your Razorpay options
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
            } else {
                // Handle other payment methods
                $('#order_form').submit(); // Submit form normally
            }
        }
    });
});
</script>