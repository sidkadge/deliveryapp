<?php include __DIR__.'/../customer/header.php'; ?>

<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="background-color: skyblue;">
                        <div class="card-header">
                            <h4>Order History</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php if (empty($order)): ?>
                                <p>No orders booked.</p>
                                <?php else: ?>
                                <table class="table table-striped table-hover" style="width:100%;">
                                    <thead style="background-color: #77c0e0;">
                                        <tr>
                                            <th>No.</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <!-- <th>Unit</th> -->
                                            <th>Delivery Date</th>
                                            <th>Payment Status</th>
                                            <th>Delivery Time</th>
                                            <th>Payment Mode</th>
                                            <th>Order Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                                $rowNumber = 1;
                                                // Sort orders by delivery date in descending order
                                                usort($order, function($a, $b) {
                                                    return strtotime($b->delivery_date) - strtotime($a->delivery_date);
                                                });
                                                foreach ($order as $row): 
                                            ?>
                                        <tr>
                                            <td><?php echo $rowNumber++; ?></td>
                                            <td><?php echo $row->product_name; ?></td>
                                            <td><?php echo $row->quantity; ?></td>
                                            <td><?php echo $row->price; ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($row->delivery_date)); ?></td>
                                            <td>
                                                <?php if ($row->payment_status == 'paid'): ?>
                                                <span class="badge badge-primary"
                                                    style="width: 4.4rem; margin-left: 0.8rem;"><?php echo $row->payment_status; ?></span>
                                                <?php else: ?>
                                                <span class="badge badge-danger"
                                                    style="width: 4.4rem; margin-left: 0.8rem;"><?php echo $row->payment_status; ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo $row->delivery_time; ?></td>
                                            <td><?php echo $row->payment_mode; ?></td>
                                            <td>
                                                <?php if ($row->order_status == 'D'): ?>
                                                <span class="badge badge-secondary"
                                                    style="width: 5rem; margin-left: 0.8rem;"><?php echo "Delivered" ?></span>
                                                <?php elseif ($row->order_status == 'C'): ?>
                                                <span class="badge badge-danger"
                                                    style="width: 5rem; margin-left: 0.8rem"><?php echo "Cancelled" ?></span>
                                                <?php elseif ($row->order_status == 'B'):?>
                                                <span class="badge badge-warning"
                                                    style="width: 5rem; margin-left: 0.8rem;"><?php echo "Booked" ?></span>
                                                <?php else: ?>
                                                <span class="badge badge-light"
                                                    style="width: 5rem; margin-left: 0.8rem;"><?php echo "Pending" ?></span>
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
        </div>
    </section>
</div>
<?php include __DIR__.'/../customer/footer.php'; ?>

<script>
// jQuery function to hide the success message after 5 seconds
$(document).ready(function() {
    setTimeout(function() {
        $(".toast").fadeOut(1000);
    }, 5000); // 5000 milliseconds = 5 seconds
});
</script>