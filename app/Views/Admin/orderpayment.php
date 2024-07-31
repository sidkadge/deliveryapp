<?php include __DIR__.'/../Admin/header.php'; ?>

<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="background-color: #afeae2">
                        <div class="card-header">
                            <h4>Payment Status</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php if (empty($order)): ?>
                                <p>No orders found.</p>
                                <?php else: ?>
                                <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Customer Name</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>transaction Id</th>
                                            <th>Delivery Date</th>
                                            <th>Payment Status</th>
                                            <th>Delivery Time</th>
                                            <th>Payment Mode</th>
                                            <th>Order Status</th>
                                            <th>Payment Of Order By Partner</th>
                                            <th>Payment Collect</th>
                                            <th>Update Payment</th>
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
                                            <td><?php echo $row->user_name; ?></td>
                                            <td><?php echo $row->product_name; ?></td>
                                            <td><?php echo $row->quantity; ?></td>
                                            <td><?php echo $row->price; ?></td>
                                            <td>
                                                <?php if (!empty($row->payment_screenshot_path)): ?>
                                                <a href="<?= $row->payment_screenshot_path; ?>" target="_blank"
                                                    class="btn btn-sm btn-primary">
                                                    View Screenshot
                                                </a>
                                                <?php else: ?>
                                                <span><?php echo $row->transaction_id; ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo date('d-m-Y', strtotime($row->delivery_date)); ?></td>
                                            <td>
                                                <?php if ($row->payment_status == 'paid'): ?>
                                                <span
                                                    class="badge badge-success"><?php echo $row->payment_status; ?></span>
                                                <?php else: ?>
                                                <span
                                                    class="badge badge-danger"><?php echo $row->payment_status; ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo date('h:i A', strtotime($row->delivery_time)); ?></td>
                                            <td><?php echo $row->payment_mode; ?></td>
                                            <td>
                                                <?php if ($row->order_status == 'D'): ?>
                                                <span class="badge badge-secondary"><?php echo "Delivered"; ?></span>
                                                <?php elseif ($row->order_status == 'C'): ?>
                                                <span class="badge badge-danger"><?php echo "Cancelled"; ?></span>
                                                <?php elseif ($row->order_status == 'B'):?>
                                                <span class="badge badge-warning"><?php echo "Booked"; ?></span>
                                                <?php else: ?>
                                                <span class="badge badge-warning"><?php echo "Pending"; ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($row->deliveypartnerypaymet == 'R'): ?>
                                                <span class="badge badge-success"><?php echo "Received" ?></span>
                                                <?php elseif ($row->deliveypartnerypaymet == 'NR'): ?>
                                                <span class="badge badge-danger"><?php echo "Not collected" ?></span>
                                                <?php elseif ($row->deliveypartnerypaymet == 'B'):?>
                                                <span class="badge badge-warning"><?php echo "Booked" ?></span>
                                                <?php else: ?>
                                                <span class="badge badge-warning"><?php echo "Pending" ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($row->payment_status == 'unpaid'): ?>
                                                <form method="post"
                                                    action="<?php echo base_url('updatepaymentstatus'); ?>">
                                                    <select name="payment_status" style="width: 149px;"
                                                        class="form-control">
                                                        <option value="paid"
                                                            <?php echo ($row->payment_status == 'paid') ? 'selected' : ''; ?>>
                                                            Paid
                                                        </option>
                                                        <option value="unpaid"
                                                            <?php echo ($row->payment_status == 'unpaid') ? 'selected' : ''; ?>>
                                                            Unpaid
                                                        </option>
                                                    </select>
                                                    <input type="hidden" name="order_id"
                                                        value="<?php echo $row->id; ?>">
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-primary mt-2">Update</button>
                                                </form>
                                                <?php else: ?>
                                                <!-- No action needed for paid orders -->
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

<?php include __DIR__.'/../Admin/footer.php'; ?>