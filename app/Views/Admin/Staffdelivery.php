<?php include __DIR__.'/../Admin/header.php'; ?>

<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="background-color: #afeae2">
                        <div class="card-header">
                            <h4>Delivery  Staff List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php if (empty($userdata)): ?>
                                    <p>No orders booked.</p>
                                <?php else: ?>
                                    <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th> Name</th>
                                                <th>Email</th>
                                                <th>Contact Number</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $rowNumber = 1;
                                                // Sort orders by delivery date in descending order
                                             
                                                foreach ($userdata as $row): 
                                            ?>
                                            <tr>
                                                <td><?php echo $rowNumber++; ?></td>
                                                <td><?php echo $row->full_name; ?></td>
                                               
                                                <td><?php echo $row->email; ?></td>
                                                <td><?php echo $row->mobile_no; ?></td>
                                                
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
