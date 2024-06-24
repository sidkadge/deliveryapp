<?php include __DIR__.'/../Admin/header.php'; ?>

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Pending Orders</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <?php if (empty($order)): ?>
                                <p>No orders booked.</p>
                            <?php else: ?>
                                <table class="table table-striped">
                                    <thead>
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
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $rowId = 1; // Initialize counter variable
                                        $today = date("Y-m-d"); // Get today's date in YYYY-MM-DD format
                                        foreach ($order as $order): ?>
                                            <tr>
                                                <td><?php echo $rowId++; ?></td> <!-- Display and increment the row ID -->
                                                <td><?php echo $order->product_name; ?></td>
                                                <td><?php echo $order->user_name; ?></td> <!-- Display the customer name -->
                                                <td><?php echo $order->quantity; ?></td>
                                                <td><?php echo $order->price; ?></td>
                                                <td><?php echo $order->unit; ?></td>
                                                <td><?php echo date("d-m-Y", strtotime($order->delivery_date)); ?></td>
                                                <td><?php echo date("h:i A", strtotime($order->delivery_time)); ?></td>
                                                <td><?php echo $order->payment_status; ?></td>
                                                <td><?php echo $order->payment_mode; ?></td>
                                                <td>
                                                    <?php if (strtotime($order->delivery_date) < strtotime($today)): ?>
                                                        <div class="badge badge-info">Not Delivered</div>
                                                    <?php else: ?>
                                                        <?php if ($order->order_status == 'D'): ?>
                                                            <div class="badge badge-secondary">Delivered</div>
                                                        <?php elseif ($order->order_status == 'C'): ?>
                                                            <div class="badge badge-danger">Cancelled</div>
                                                        <?php else: ?>
                                                            <div class="badge badge-warning">Pending</div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
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
    </section>
</div>

<?php include __DIR__.'/../Admin/footer.php'; ?>
