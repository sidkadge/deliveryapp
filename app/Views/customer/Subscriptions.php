<?php include __DIR__.'/../customer/header.php'; ?>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-6">
                <div class="col-12 col-md-12">
                    <div class="card author-box">
                        <div class="card-body" style="background-color: skyblue;">
                            <!-- Start and End Date Selection -->
                            <form action="Subscriptionsbook" method="post" id="order_form"
                                enctype="multipart/form-data">

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="startDate">Start Date</label>
                                            <input type="date" class="form-control" id="startDate" name="startDate"
                                                min="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="endDate">End Date</label>
                                            <input type="date" class="form-control" id="endDate" name="endDate">
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="deliveryTime">Delivery Time</label>
                                            <input type="time" class="form-control" id="deliveryTime"
                                                name="deliveryTime">
                                        </div>
                                    </div> -->
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="deliveryTime">Delivery Time</label>
                                            <select class="form-control" id="deliveryTime" name="deliveryTime">
                                                <option value="">Select Time</option>
                                                <option value="09:00-14:00">Morning (9 AM - 2 PM)</option>
                                                <option value="16:00-18:00">Evening (4 PM - 6 PM)</option>
                                            </select>
                                            <!-- <label for="paymentMode"><b>(If You Order after 2pm: Delivered next morning.)</b></label> -->
                                        </div>
                                    </div>
                                </div>

                                <!-- Day Checkboxes -->
                                <div class="row" id="dayCheckboxes" style="display: none;">
                                    <div class="col-lg-12">
                                        <label>Select Days:</label>
                                        <div id="checkboxContainer" class="form-check-inline">
                                            <?php
                                            $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                                            foreach ($days as $day) {
                                                echo "<div class='form-check'>
                                                        <input class='form-check-input day-checkbox' type='checkbox' value='$day' id='{$day}Checkbox'>
                                                        <label class='form-check-label' for='{$day}Checkbox'>$day</label>
                                                      </div>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Selection Form -->
                                <input type="hidden" id="selectedDates" name="selectedDates">

                                <div class="row mt-3">
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
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="unitOutput">Unit</label>
                                            <input type="text" name="unit" class="form-control" id="unitOutput"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="pricePerUnit">Price Per Unit</label>
                                            <input type="number" class="form-control" id="pricePerUnit"
                                                name="pricePerUnit" readonly>
                                        </div>
                                    </div>

                                    <!-- Quantity Input -->
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="quantityInput">Quantity(Per Day)</label>
                                            <input type="number" class="form-control" id="quantityInput"
                                                name="quantityInput" placeholder="Quantity" min="1">
                                        </div>
                                    </div>
                                    <!-- Price Calculation -->
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="PricePerDay">Price Per Day</label>
                                            <input type="text" class="form-control" id="PricePerDay" name="PricePerDay"
                                                readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="priceOutput">Total Price</label>
                                            <input type="text" name="price" class="form-control" id="priceOutput"
                                                readonly>
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
                                                <label class="form-check-label" for="upiRadio">UPI</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="paymentMode"
                                                    id="cashRadio" value="cash">
                                                <label class="form-check-label" for="cashRadio">Cash On Delivery</label>
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
.input label {
    color: red;
}

.row input {
    background: linear-gradient(to right, #dfe9f1, white, white);
}

.row select {
    background: linear-gradient(to right, #dfe9f1, white, white);
}

.form-check-input[type="radio"] {
    width: 20px;
    height: 20px;
}

.btn-primary {
    width: 150px;
    height: 40px;
    font-size: 20px;
}
</style>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var startDateInput = document.getElementById('startDate');
    var endDateInput = document.getElementById('endDate');
    var dayCheckboxes = document.getElementById('dayCheckboxes');
    var checkboxContainer = document.getElementById('checkboxContainer');
    var productDropdown = document.getElementById('productDropdown');
    var pricePerUnit = document.getElementById('pricePerUnit');
    var unitOutput = document.getElementById('unitOutput');
    var quantityInput = document.getElementById('quantityInput');
    var priceOutput = document.getElementById('priceOutput');
    var pricePerDay = document.getElementById('PricePerDay');
    var selectedDatesInput = document.getElementById('selectedDates');
    var upiRadio = document.getElementById('upiRadio');
    var cashRadio = document.getElementById('cashRadio');
    var orderForm = document.getElementById('order_form');

    // Initialize jQuery Validate
    $(orderForm).validate({
        rules: {
            startDate: {
                required: true,
                dateISO: true
            },
            endDate: {
                required: true,
                dateISO: true,
                greaterThan: "#startDate"
            },
            productDropdown: {
                required: true
            },
            quantityInput: {
                required: true,
                digits: true,
                min: 1
            },
            paymentMode: {
                required: true
            }
        },
        messages: {
            startDate: {
                required: "Please select a start date.",
                dateISO: "Please enter a valid date."
            },
            endDate: {
                required: "Please select an end date.",
                dateISO: "Please enter a valid date.",
                greaterThan: "End date must be greater than start date."
            },
            productDropdown: {
                required: "Please select a product."
            },
            quantityInput: {
                required: "Please enter a quantity.",
                digits: "Please enter a valid number.",
                min: "Quantity must be at least 1."
            },
            paymentMode: {
                required: "Please select a payment mode."
            }
        },
        errorPlacement: function(error, element) {
            if (element.is(":radio") || element.is(":checkbox")) {
                error.appendTo(element.closest('.form-group'));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            if ($('#upiRadio').is(':checked')) {
                var options = {
                    "key": "rzp_test_QdPDZO6x3F9kBz", // Replace with your Razorpay key
                    "amount": parseFloat(priceOutput.value) * 100, // Amount is in paise
                    "currency": "INR",
                    "name": "Your Company Name",
                    "description": "Purchase Description",
                    "handler": function(response) {
                        var paymentId = response.razorpay_payment_id;
                        var paymentMode = document.querySelector(
                            'input[name="paymentMode"]:checked').value;
                        var formData = new FormData(orderForm);
                        formData.append('paymentId', paymentId);
                        formData.append('paymentMode', paymentMode);
                        fetch('Subscriptionsbook', {
                                method: 'POST',
                                body: formData
                            }).then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Payment successful and order placed!');
                                    window.location.href =
                                    '/DeliveryApp/ordehistory'; // Ensure correct path
                                } else {
                                    alert('Payment successful but order placement failed!');
                                }
                            }).catch(error => {
                                console.error('Error:', error);
                            });
                    },
                    "prefill": {
                        "name": "Your Name",
                        "email": "your.email@example.com",
                        "contact": "9999999999"
                    },
                    "notes": {
                        "address": "Your Address"
                    },
                    "theme": {
                        "color": "#3399cc"
                    }
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
            } else {
                form.submit();
            }
        }
    });

    // Custom validation method to check if end date is greater than start date
    $.validator.addMethod("greaterThan", function(value, element, param) {
        var startDate = $(param).val();
        return this.optional(element) || new Date(value) > new Date(startDate);
    }, "End date must be greater than start date.");

    // Function to get selected dates
    function getDatesForSelectedDays(startDate, endDate, selectedDays) {
        var dates = [];
        var currentDate = new Date(startDate);
        while (currentDate <= new Date(endDate)) {
            var dayName = currentDate.toLocaleDateString('en-US', {
                weekday: 'long'
            });
            if (selectedDays.includes(dayName)) {
                dates.push(currentDate.toISOString().split('T')[0]);
            }
            currentDate.setDate(currentDate.getDate() + 1);
        }
        return dates;
    }

    // Function to update total price
    function updateTotalPrice() {
        var selectedDays = Array.from(document.querySelectorAll('.day-checkbox:checked'))
            .map(checkbox => checkbox.value);
        var dates = getDatesForSelectedDays(startDateInput.value, endDateInput.value, selectedDays);
        selectedDatesInput.value = dates.join(',');
        var unitPrice = parseFloat(pricePerUnit.value) || 0;
        var quantity = parseInt(quantityInput.value) || 0;
        priceOutput.value = (unitPrice * quantity * dates.length).toFixed(2);
        var totalPrice = parseFloat(priceOutput.value) || 0;
        var totalDays = dates.length || 1;
        pricePerDay.value = (totalPrice / totalDays).toFixed(2);
    }

    // Function to show day checkboxes if date range is valid
    function updateDayCheckboxes() {
        if (startDateInput.value && endDateInput.value) {
            var startDate = new Date(startDateInput.value);
            var endDate = new Date(endDateInput.value);
            if (startDate <= endDate) {
                dayCheckboxes.style.display = 'block';
            } else {
                dayCheckboxes.style.display = 'none';
            }
        }
    }

    // Event listeners for other elements
    startDateInput.addEventListener('change', function() {
        updateDayCheckboxes();
        updateTotalPrice();
    });

    endDateInput.addEventListener('change', function() {
        updateDayCheckboxes();
        updateTotalPrice();
    });

    document.querySelectorAll('.day-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', updateTotalPrice);
    });

    quantityInput.addEventListener('input', updateTotalPrice);

    productDropdown.addEventListener('change', function() {
        var selectedOption = productDropdown.options[productDropdown.selectedIndex];
        if (selectedOption) {
            pricePerUnit.value = selectedOption.dataset.price;
            unitOutput.value = selectedOption.dataset.size + ' ' + selectedOption.dataset.unit;
            updateTotalPrice();
        }
    });

    // Initial function call to handle price and unit on page load
    function initializeForm() {
        var selectedOption = productDropdown.options[productDropdown.selectedIndex];
        if (selectedOption) {
            pricePerUnit.value = selectedOption.dataset.price;
            unitOutput.value = selectedOption.dataset.size + ' ' + selectedOption.dataset.unit;
            updateTotalPrice();
        }
    }

    initializeForm();
});

</script>