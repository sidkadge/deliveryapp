<?php include __DIR__.'/../Admin/header.php'; ?>

<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="background-color: #afeae2;">
                        <div class="card-header">
                            <h4>Received Orders</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php if (empty($order)): ?>
                                <p>No orders.</p>
                                <?php else: ?>
                                <div class="row">
                                    <?php 
                                        // Sort orders by delivery date in descending order
                                        usort($order, function($a, $b) {
                                            return strtotime($a->delivery_date) - strtotime($b->delivery_date);
                                        });

                                        $today = date('Y-m-d'); // Get today's date in YYYY-MM-DD format

                                        foreach ($order as $row): 
                                            $deliveryDate = date('Y-m-d', strtotime($row->delivery_date));
                                    ?>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <!-- <h5 class="card-title">Order #<?php echo $row->id; ?></h5> -->
                                                <p class="card-text"><strong>Customer Name:</strong> <?php echo $row->user_name; ?></p>
                                                <p class="card-text"><strong>Product:</strong> <?php echo $row->product_name; ?></p>
                                                <p class="card-text"><strong>Quantity:</strong> <?php echo $row->quantity; ?></p>
                                                <p class="card-text"><strong>Price:</strong> <?php echo $row->price; ?></p>
                                                <p class="card-text"><strong>Delivery Date:</strong> <?php echo date('d-m-Y', strtotime($row->delivery_date)); ?></p>
                                                <p class="card-text"><strong>Delivery Time:</strong> <?php echo date('h:i A', strtotime($row->delivery_time)); ?></p>
                                                <p class="card-text"><strong>Address:</strong> <?php echo htmlspecialchars($row->address); ?></p>

                                                <!-- Payment Status -->
                                                <p class="card-text">
                                                    <strong>Payment Status:</strong>
                                                    <?php if ($row->payment_status == 'paid'): ?>
                                                        <span class="badge badge-success">Paid</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-danger">Unpaid</span>
                                                    <?php endif; ?>
                                                </p>

                                                <!-- Payment and Delivery Actions -->
                                                <?php if ($row->payment_status == 'unpaid' && empty($row->deliveypartnerypaymet)): ?>
                                                    <form method="post" action="<?php echo base_url('deliverypaymentcollect'); ?>">
                                                        <input type="hidden" name="order_id" value="<?php echo $row->id; ?>">
                                                        <input type="hidden" name="allot_partner" value="<?php echo $row->allot_partner; ?>">
                                                        
                                                        <button type="submit" style="width: 120px;" name="deliveypartnerypaymet" value="R" class="btn btn-success mt-2" <?php echo (strtotime($deliveryDate) > strtotime($today)) ? 'disabled' : ''; ?>>
                                                            <!-- Received -->
                                                            पैसे मिले
                                                        </button>
                                                        
                                                        <button type="submit" style="width: 120px;" name="deliveypartnerypaymet" value="NR" class="btn btn-primary mt-2" <?php echo (strtotime($deliveryDate) > strtotime($today)) ? 'disabled' : ''; ?>>
                                                            <!-- Not Collected -->
                                                            पैसे नहीं मिले
                                                        </button>
                                                    </form>
                                                <?php endif; ?>

                                                <!-- Order Delivery Actions -->
                                                <form method="post" action="<?php echo base_url('updateorderstatus'); ?>">
                                                    <input type="hidden" name="order_id" value="<?php echo $row->id; ?>">
                                                    <input type="hidden" name="allot_partner" value="<?php echo $row->allot_partner; ?>">
                                                    
                                                    <button type="submit" class="btn btn-primary mt-2" name="status" value="D" <?php echo empty($row->deliveypartnerypaymet) ? 'disabled' : ''; ?>>
                                                        <!-- Delivered -->
                                                        डिलिव्हरी दिया
                                                    </button>
                                                    
                                                    <button type="submit" class="btn btn-danger mt-2" name="status" value="P" <?php echo empty($row->deliveypartnerypaymet) ? 'disabled' : ''; ?>>
                                                        <!-- Not Delivered -->
                                                        घर पे नहीं
                                                    </button>
                                                </form>

                                                <!-- Button to show address and location in a popup -->
                                                <button type="button" class="btn btn-info mt-2" onclick="showAddressPopup('<?php echo htmlspecialchars($row->address); ?>', '<?php echo $row->location; ?>')">Show Address</button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
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
<div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel" aria-hidden="true">
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
function showAddressPopup(address, location) {
    document.getElementById('modalAddress').textContent = address;
    var locationLink = document.getElementById('modalLocation');
    locationLink.href = location;
    locationLink.style.display = location ? 'inline-block' : 'none';
    $('#addressModal').modal('show');
}
</script>
