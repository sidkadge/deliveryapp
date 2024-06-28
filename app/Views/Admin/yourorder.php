<?php include __DIR__.'/../Admin/header.php'; ?>

<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12" >
                <div class="card" style="background-color: #afeae2;">
                        <div class="card-header" >
                            <h4>Received Orders</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php if (empty($order)): ?>
                                <p>No orders.</p>
                                <?php else: ?>
                                <table class="table table-striped table-hover" style="width:100%; background-color: #afeae2;">
                                    <thead style="background-color: #afeae2; text-align: center; height: 5rem;">
                                        <tr>
                                            <th>No.<br>नंबर </th>
                                            <th>Order Delivery Status<br>ऑर्डर डिलीवरी स्थिति</th>
                                            <th>Customer Name<br>ग्राहक का नाम</th>
                                            <th>Product<br>प्रोडक्ट</th>
                                            <th>Quantity<br>संख्या</th>
                                            <th>Price<br>कीमत</th>
                                            <th>Payment Status<br>Collection</th>
                                            <th>Payment<br>भुगतान</th>
                                            <th>Delivery Date<br>डिलीवरी की तारीख</th>
                                            <th>Delivery Time<br>डिलीवरी का समय</th>
                                            <th>Address<br>पता</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                                $rowNumber = 1;
                                                // Sort orders by delivery date in descending order
                                                usort($order, function($a, $b) {
                                                    return strtotime($a->delivery_date) - strtotime($b->delivery_date);
                                                });
                                                $today = date('Y-m-d'); // Get today's date in YYYY-MM-DD format

                                                foreach ($order as $row): 
                                                    $deliveryDate = date('Y-m-d', strtotime($row->delivery_date));
                                            ?>
                                        <tr>
                                            <td><?php echo $rowNumber++; ?></td>
                                            <td>
                                                <form method="post"
                                                    action="<?php echo base_url('updateorderstatus'); ?>">
                                                    <input type="hidden" name="order_id"
                                                        value="<?php echo $row->id; ?>">
                                                        <input type="hidden" name="allot_partner"
                                                        value="<?php echo $row->allot_partner; ?>">
                                                    <button type="submit" style="width: 120px;" name="status" value="D"
                                                        class="btn btn-warning mt-2"
                                                        <?php echo ($deliveryDate > $today) ? 'disabled' : ''; ?>>
                                                        <!--Delivered-->डिलिव्हरी दिया
                                                    </button>
                                                    <button type="submit" style="width: 120px;" name="status" value="P"
                                                        class="btn btn-danger mt-2"
                                                        <?php echo ($deliveryDate > $today) ? 'disabled' : ''; ?>>
                                                        <!--Not Home-->घर पे नहीं
                                                    </button>
                                                </form>
                                            </td>

                                            <td><?php echo $row->user_name; ?></td>
                                            <td><?php echo $row->product_name; ?></td>
                                            <td><?php echo $row->quantity; ?></td>
                                            <td><?php echo $row->price; ?></td>
                                            <td>
                                                <?php if ($row->payment_status == 'unpaid' && $row->deliveypartnerypaymet == ''): ?>
                                                <form method="post"
                                                    action="<?php echo base_url('deliverypaymentcollect'); ?>">
                                                    <input type="hidden" name="order_id"
                                                        value="<?php echo $row->id; ?>">
                                                    <input type="hidden" name="allot_partner"
                                                        value="<?php echo $row->allot_partner; ?>">
                                                    <button type="submit" style="width: 120px;"
                                                        name="deliveypartnerypaymet" value="R"
                                                        class="btn btn-success mt-2"
                                                        <?php echo ($deliveryDate > $today) ? 'disabled' : ''; ?>>
                                                        <!--Received-->पैसे मिले
                                                    </button>
                                                    <button type="submit" style="width: 120px;"
                                                        name="deliveypartnerypaymet" value="NR"
                                                        class="btn btn-primary mt-2"
                                                        <?php echo ($deliveryDate > $today) ? 'disabled' : ''; ?>>
                                                        <!-- Not Collect-->पैसे नहीं मिले 
                                                    </button>
                                                </form>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <?php if ($row->payment_status == 'paid'): ?>
                                                <span
                                                    class="badge badge-success" style="width: 4.4rem; background-color: #d635d4;"><?php echo $row->payment_status; ?></span>
                                                <?php else: ?>
                                                <span
                                                    class="badge badge-danger" style="width: 4.4rem;"><?php echo $row->payment_status; ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo date('d-m-Y', strtotime($row->delivery_date)); ?></td>
                                            <td><?php echo date('h:i A', strtotime($row->delivery_time)); ?></td>

                                            <td>
                                                <!-- Button to show address and location in a popup -->
                                                <button type="button" class="btn btn-info mt-2"
                                                    onclick="showAddressPopup('<?php echo htmlspecialchars($row->address); ?>', '<?php echo $row->location; ?>')">
                                                    Show Address
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Structure -->
<div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressModalLabel">Customer Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="modalAddress"></p>
                <a id="modalLocation" href="#" target="_blank" class="btn btn-primary mt-2">View Location</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__.'/../Admin/footer.php'; ?>

<script>
// Function to show address and location in a modal
function showAddressPopup(address, location) {
    document.getElementById('modalAddress').textContent = address;

    // Update the link to the location
    var locationLink = document.getElementById('modalLocation');
    locationLink.href = location;
    locationLink.style.display = location ? 'inline-block' : 'none'; // Hide the button if no location is provided

    $('#addressModal').modal('show');
}
</script>
