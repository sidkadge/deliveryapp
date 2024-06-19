<?php include __DIR__.'/../Admin/header.php'; ?>

<div class="main-content" >
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Received Orders</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php if (empty($order)): ?>
                                <p>No orders.</p>
                                <?php else: ?>
                                <table class="table table-striped table-hover" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Order Delivery Status</th>
                                            <th>Payment Status</th>
                                            <th>Payment</th>
                                            <th>Customer Name</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Delivery Date</th>

                                            <th>Delivery Time</th>
                                            <th>Actions</th>
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
                                                    <button type="submit" style="width: 95px;" name="status" value="D"
                                                        class="btn btn-primary mt-2"
                                                        <?php echo ($deliveryDate > $today) ? 'disabled' : ''; ?>>
                                                        Delivered
                                                    </button>
                                                    <button type="submit" style="width: 95px;" name="status" value="P"
                                                        class="btn btn-danger mt-2"
                                                        <?php echo ($deliveryDate > $today) ? 'disabled' : ''; ?>>
                                                        Not Home
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <?php if ($row->payment_status == 'unpaid' && $row->deliveypartnerypaymet == ''): ?>
                                                <form method="post"
                                                    action="<?php echo base_url('deliverypaymentcollect'); ?>">
                                                    <input type="hidden" name="order_id"
                                                        value="<?php echo $row->id; ?>">
                                                    <input type="hidden" name="allot_partner"
                                                        value="<?php echo $row->allot_partner; ?>">
                                                    <button type="submit" style="width: 95px;"
                                                        name="deliveypartnerypaymet" value="R"
                                                        class="btn btn-success mt-2"
                                                        <?php echo ($deliveryDate > $today) ? 'disabled' : ''; ?>>
                                                        Received
                                                    </button>
                                                    <button type="submit" style="width: 95px;"
                                                        name="deliveypartnerypaymet" value="NR"
                                                        class="btn btn-warning mt-2"
                                                        <?php echo ($deliveryDate > $today) ? 'disabled' : ''; ?>>
                                                        Not Collect
                                                    </button>
                                                </form>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <?php if ($row->payment_status == 'paid'): ?>
                                                <span
                                                    class="badge badge-success"><?php echo $row->payment_status; ?></span>
                                                <?php else: ?>
                                                <span
                                                    class="badge badge-danger"><?php echo $row->payment_status; ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo $row->user_name; ?></td>
                                            <td><?php echo $row->product_name; ?></td>
                                            <td><?php echo $row->quantity; ?></td>
                                            <td><?php echo $row->price; ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($row->delivery_date)); ?></td>
                                            <td><?php echo date('h:i A', strtotime($row->delivery_time)); ?></td>

                                            <td>
                                                <!-- Button to show address in a popup -->
                                                <button type="button" class="btn btn-info mt-2"
                                                    onclick="showAddressPopup('<?php echo htmlspecialchars($row->address); ?>')">Show
                                                    Address</button>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__.'/../Admin/footer.php'; ?>

<script>
// Function to show address in a modal
function showAddressPopup(address) {
    document.getElementById('modalAddress').textContent = address;
    $('#addressModal').modal('show');
}
</script>