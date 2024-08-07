<?php include __DIR__.'/../Admin/header.php'; ?>
<style>
.badge {
    width: 6rem;
}
</style>
<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card" style="background-color: #afeae2">
                    <div class="card-header">
                        <h4>Pending Orders</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <?php if (empty($order)): ?>
                            <p>No orders booked.</p>
                            <?php else: ?>

                            <table class="table table-striped">
                                <tr>
                                    <th>ID</th> <!-- New Column for Row ID -->
                                    <th>Product</th>
                                    <th>Customer Name</th> <!-- Updated column header to "Customer Name" -->
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Unit</th>
                                    <th>Delivery Date</th>
                                    <th>Delivery Time</th>
                                    <th>Payment Status</th>
                                    <th>Payment Mode</th>
                                    <th>Order Status</th>
                                </tr>
                                <?php 
                                $rowId = 1; // Initialize counter variable
                                $today = date("Y-m-d"); // Get today's date
                                foreach ($order as $order): ?>
                                <tr style="text-align: center;">
                                    <td><?php echo $rowId++; ?></td> <!-- Display and increment the row ID -->
                                    <td><?php echo $order->product_name; ?></td>
                                    <td><?php echo $order->user_name; ?></td> <!-- Display the customer name -->
                                    <td><?php echo $order->quantity; ?></td>
                                    <td><?php echo $order->price; ?></td>
                                    <td><?php echo $order->unit; ?></td>
                                    <td><?php echo date("d-m-Y", strtotime($order->delivery_date)); ?></td>
                                    <td><?php echo date("h:i A", strtotime($order->delivery_time)); ?></td>
                                    <td>
                                        <?php 
                                  if ($order->payment_status == 'paid'): ?>
                                        <div class="badge badge-success">Paid</div>
                                        <?php elseif ($order->payment_status == 'unpaid'): ?>
                                        <div class="badge badge-danger">Unpaid</div>
                                        <?php else: ?>
                                        <div class="badge badge-warning">Unknown Status</div>
                                        <?php endif; ?>
                                    </td>

                                    <td><?php echo $order->payment_mode; ?></td>
                                    <td>
                                        <?php 
                                        // Check if the delivery date is greater than today's date
                                        if ($order->delivery_date < $today): ?>
                                        <div class="badge badge-danger">Undelivered
                                        </div>
                                        <?php elseif ($order->order_status == 'D'): ?>
                                        <div class="badge badge-secondary">Delivered
                                        </div>
                                        <?php elseif ($order->order_status == 'C'): ?>
                                        <div class="badge badge-danger">Cancelled</div>
                                        <?php else: ?>
                                        <div class="badge badge-warning">Pending
                                        </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </table>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include __DIR__.'/../Admin/footer.php';?>