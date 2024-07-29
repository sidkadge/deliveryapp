<?php include __DIR__.'/../Admin/header.php'; ?>

<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Customer List </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php if (empty($customer)): ?>
                                    <p>No orders booked.</p>
                                <?php else: ?>
                                    <table class="table table-striped table-hover" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Customer Name</th>
                                                <th>Contact Number</th>
                                                <th>Address</th>
                                                <th>Allot Partner</th>
                                                <th>Assign</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $rowNumber = 1;
                                                // Sort orders by delivery date in descending order
                                                // usort($customer, function($a, $b) {
                                                //     return strtotime($b->delivery_date) - strtotime($a->delivery_date);
                                                // });
                                                foreach ($customer as $row): 
                                            ?>
                                            <tr>
                                                <td><?php echo $rowNumber++; ?></td>
                                                <td><?php echo $row->full_name; ?></td>
                                                <td><?php echo $row->mobile_no; ?></td>
                                                <td>
                                                <!-- Button to show address in a popup -->
                                                <button type="button" class="btn btn-info mt-2"
                                                    onclick="showAddressPopup('<?php echo htmlspecialchars($row->address); ?>')">Show
                                                    Address</button>
                                                </td>
                                                <td>
                                                  
                                                
                                                        <form method="post" action="<?php echo base_url('allotpartnerstocustomer'); ?>">
                                                            <select name="allot_partner" style="width: 149px;" class="form-control" required>
                                                                <option value="">Select Partner</option>
                                                                <?php foreach ($userdata as $user): ?>
                                                                    <option value="<?php echo $user->id; ?>">
                                                                        <?php echo $user->full_name; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <input type="hidden" name="Customer_id" value="<?php echo $row->id; ?>">
                                                   
                                                </td>
                                                <td> <button type="submit" class="btn btn-primary mt-2">Allot Partner</button></td>
                                                                </form>
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