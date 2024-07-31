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
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="endDate">End Date</label>
                                            <input type="date" class="form-control" id="endDate" name="endDate">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="deliveryTime">Delivery Time</label>
                                            <input type="time" class="form-control" id="deliveryTime"
                                                name="deliveryTime">
                                        </div>
                                    </div>
                                </div>

                                <!-- Day Checkboxes -->
                                <div class="row" id="dayCheckboxes" style="display: none;">
                                    <div class="col-lg-12">
                                        <label>Select Days:</label>
                                        <div id="checkboxContainer" class="form-check-inline">
                                            <div class="form-check">
                                                <input class="form-check-input day-checkbox" type="checkbox"
                                                    value="Monday" id="mondayCheckbox">
                                                <label class="form-check-label" for="mondayCheckbox">Monday</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input day-checkbox" type="checkbox"
                                                    value="Tuesday" id="tuesdayCheckbox">
                                                <label class="form-check-label" for="tuesdayCheckbox">Tuesday</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input day-checkbox" type="checkbox"
                                                    value="Wednesday" id="wednesdayCheckbox">
                                                <label class="form-check-label"
                                                    for="wednesdayCheckbox">Wednesday</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input day-checkbox" type="checkbox"
                                                    value="Thursday" id="thursdayCheckbox">
                                                <label class="form-check-label" for="thursdayCheckbox">Thursday</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input day-checkbox" type="checkbox"
                                                    value="Friday" id="fridayCheckbox">
                                                <label class="form-check-label" for="fridayCheckbox">Friday</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input day-checkbox" type="checkbox"
                                                    value="Saturday" id="saturdayCheckbox">
                                                <label class="form-check-label" for="saturdayCheckbox">Saturday</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input day-checkbox" type="checkbox"
                                                    value="Sunday" id="sundayCheckbox">
                                                <label class="form-check-label" for="sundayCheckbox">Sunday</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Selection Form -->
                                <input type="hidden" id="selectedDates" name="selectedDates">

                                <div class="row mt-3">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="productDropdown">Product</label>
                                            <!-- <select class="form-control" id="productDropdown" name="productDropdown">
                                                <option value="" disabled selected>Select a product</option>
                                                <?php foreach ($product as $item): ?>
                                                <option value="<?php echo $item->id ?>"
                                                    data-price="<?php echo $item->price ?>"
                                                    data-unit="<?php echo $item->unit ?>"
                                                    data-size="<?php echo $item->Size ?>">
                                                    <?php echo $item->productname ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select> -->

                                            <select class="form-control" id="productDropdown" name="productDropdown" >
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
                                            <img alt="QR Code" src="<?=base_url(); ?>public/assets/img/users/QRcodeMrunalMam.jpg"
                                                class="img-fluid mt-2" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group" id="upiTransaction" style="display: none;">
                                            <label for="transactionIdInput">Transaction ID</label>
                                            <input type="text" class="form-control" id="transactionIdInput"
                                                placeholder="Transaction ID" name="transactionIdInput">
                                        </div>
                                    </div>
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
                                                    id="copyButton" style="font-weight: bold; color: black; height: 2.6rem; border-color: #c5dbd5;">Copy</button>
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
    .input label{
        color: red;
        /* font-size: 15px;
        padding-left: 4px; */
    }
    .row input{
        background: linear-gradient(to right,#dfe9f1,white,white);
    }
    .row select{
        background: linear-gradient(to right,#dfe9f1,white,white);
    }
    .form-check-input[type="radio"]{
        width: 20px;
        height: 20px;
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

    var qrCodeContainer = document.getElementById('qrCodeContainer');
    var upiTransaction = document.getElementById('upiTransaction');
    var screenshotAttachment = document.getElementById('screenshotAttachment');
    var upiDetailsRow = document.getElementById('upiDetailsRow');
    var upiRadio = document.getElementById('upiRadio');
    var cashRadio = document.getElementById('cashRadio');

    // Function to get dates between startDate and endDate for selected days
    function getDatesForSelectedDays(startDate, endDate, selectedDays) {
        var dates = [];
        var currentDate = new Date(startDate);

        while (currentDate <= new Date(endDate)) {
            var dayName = currentDate.toLocaleDateString('en-US', { weekday: 'long' });
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

        // Calculate price per day
        var totalPrice = parseFloat(priceOutput.value) || 0;
        var totalDays = dates.length || 1; // Avoid division by zero
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

    // Function to toggle UPI payment details visibility
    function toggleUPIPaymentDetails(show) {
        qrCodeContainer.querySelector('img').style.display = show ? 'block' : 'none';
        upiTransaction.style.display = show ? 'block' : 'none';
        screenshotAttachment.style.display = show ? 'block' : 'none';
        upiDetailsRow.style.display = show ? 'block' : 'none';
    }

    // Event listeners for payment mode radio buttons
    upiRadio.addEventListener('change', function() {
        if (upiRadio.checked) {
            toggleUPIPaymentDetails(true);
        }
    });

    cashRadio.addEventListener('change', function() {
        if (cashRadio.checked) {
            toggleUPIPaymentDetails(false);
        }
    });

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
        pricePerUnit.value = selectedOption.dataset.price;
        unitOutput.value = selectedOption.dataset.size + ' ' + selectedOption.dataset.unit;
        updateTotalPrice();
    });

    // Handle form submission
    document.getElementById('order_form').addEventListener('submit', function(event) {
        var selectedDays = Array.from(document.querySelectorAll('.day-checkbox:checked'))
            .map(checkbox => checkbox.value);

        var dates = getDatesForSelectedDays(startDateInput.value, endDateInput.value, selectedDays);
        selectedDatesInput.value = dates.join(',');
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

    initializeForm(); // Call on page load
});
</script>

<script>
$(document).ready(function() {
    $('#order_form').validate({
        rules: {
            startDate: {
                required: true,
            },
            endDate: {
                required: true,
                greaterThanStartDate: "#startDate"
            },
            "day-checkbox[]": {
                required: true,
                minlength: 1
            },
            productDropdown: {
                required: true,
            },
            quantityInput: {
                required: true,
                min: 1,
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
            startDate: {
                required: "Please select a start date.",
            },
            endDate: {
                required: "Please select an end date.",
                greaterThanStartDate: "End date must be greater than start date."
            },
            "day-checkbox[]": {
                required: "Please select at least one day.",
            },
            productDropdown: {
                required: 'Please select a product.',
            },
            quantityInput: {
                required: 'Please enter the quantity.',
                min: 'Quantity must be at least 1.'
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
            } else if (element.attr("name") == "startDate" || element.attr("name") == "endDate") {
                error.appendTo(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    // Custom validation method to check if end date is greater than start date
    $.validator.addMethod("greaterThanStartDate", function(value, element, params) {
        var startDate = $(params).val();
        return Date.parse(value) > Date.parse(startDate);
    }, "End date must be greater than start date.");
});
</script>