<?php include __DIR__.'/../Admin/header.php'; ?>

<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="background-color: #afeae2">
                        <div class="card-header">
                            <h4>Allot Partner</h4>
                        </div>
                        <div class="card-body" >
                            <div class="table-responsive">
                                <?php if (empty($order)): ?>
                                    <p>No orders booked.</p>
                                <?php else: ?>
                                    <table class="table table-striped table-hover"style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Customer Name</th>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Delivery Date</th>
                                                <th>Delivery Time</th>
                                                <th>Payment Mode</th>
                                                <!-- <th>Allot Partner</th> -->
                                                <th>Change Partner</th>
                                                <th>Action</th>
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
                                                <td><?php echo date('d-m-Y', strtotime($row->delivery_date)); ?></td>
                                                <!-- <td>
                                                    <?php if ($row->payment_status == 'paid'): ?>
                                                        <span class="badge badge-success"><?php echo $row->payment_status; ?></span>
                                                    <?php else: ?>
                                                        <span class="badge badge-danger"><?php echo $row->payment_status; ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($row->order_status == 'D'): ?>
                                                        <span class="badge badge-secondary"><?php echo "Delivered"; ?></span>
                                                    <?php elseif ($row->order_status == 'C'): ?>
                                                        <span class="badge badge-danger"><?php echo "Cancelled"; ?></span>
                                                    <?php elseif ($row->order_status == 'B'): ?>
                                                        <span class="badge badge-warning"><?php echo "Booked"; ?></span>
                                                    <?php else: ?>
                                                        <span class="badge badge-warning"><?php echo "Pending"; ?></span>
                                                    <?php endif; ?>
                                                </td> -->
                                                <td><?php echo date('h:i A', strtotime($row->delivery_time)); ?></td>
                                                <td><?php echo $row->payment_mode; ?></td>
                                                <!-- <td>
                                                    <?php if (isset($row->allot_partner) && $row->allot_partner): ?>
                                                        <?php foreach ($userdata as $user): ?>
                                                            <?php if ($row->allot_partner == $user->id): ?>
                                                                <?php echo $user->full_name; ?>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <form method="post" action="<?php echo base_url('allotpartners'); ?>">
                                                            <select name="allot_partner" style="width: 149px;" class="form-control">
                                                                <option value="">Select Partner</option>
                                                                <?php foreach ($userdata as $user): ?>
                                                                    <option value="<?php echo $user->id; ?>">
                                                                        <?php echo $user->full_name; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <input type="hidden" name="order_id" value="<?php echo $row->id; ?>">
                                                    <?php endif; ?>
                                                </td> -->
                                                <td>
                                                    <?php if (isset($row->allot_partner) && $row->allot_partner): ?>
                                                        <form method="post" action="<?php echo base_url('allotpartners'); ?>">
                                                            <select name="allot_partner" style="width: 149px;" class="form-control">
                                                                <?php foreach ($userdata as $user): ?>
                                                                    <option value="<?php echo $user->id; ?>" <?php echo ($row->allot_partner == $user->id) ? 'selected' : ''; ?>>
                                                                        <?php echo $user->full_name; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <input type="hidden" name="order_id" value="<?php echo $row->id; ?>">
                                                           
                                                   
                                                            
                                                        
                                                    <?php endif; ?>
                                                </td>
                                                <td> <button type="submit" class="btn btn-primary mt-2">Change Partner</button>
                                                </form></td>
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
