<?php include __DIR__.'/../Admin/header.php'; ?>

<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Customer list</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php if (empty($coustomer)): ?>
                                    <p>No orders booked.</p>
                                <?php else: ?>
                                    <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Customer Name</th>
                                                <th>Email</th>
                                                <th>Contact Number</th>
                                                <th>Address</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $rowNumber = 1;
                                                // Sort orders by delivery date in descending order
                                             
                                                foreach ($coustomer as $row): 
                                            ?>
                                            <tr>
                                                <td><?php echo $rowNumber++; ?></td>
                                                <td><?php echo $row->full_name; ?></td>
                                               
                                                <td><?php echo $row->email; ?></td>
                                                <td><?php echo $row->mobile_no; ?></td>
                                                <td><?php echo $row->address; ?></td>
                                                
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
