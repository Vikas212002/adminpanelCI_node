<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Campaigns</h2>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12 my-4">
            <h1 class="text-center"></h1>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Users Data
                        <a href="#" data-bs-toggle="modal" data-bs-target="#filterModal" class="btn btn-primary float-end">Filter Data</a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addUserModal" class="btn btn-primary float-end me-3">Add Data</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="usersTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Campaign name</th>
                                <th>Description</th>
                                
                                <th>created_at</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($campaigns as $camp): ?>
                                <tr>
                                    <td><?= esc($camp['id']) ?></td>
                                    <td><?= esc($camp['campaign_name']) ?></td>
                                    <td><?= esc($camp['description']) ?></td>
                                    
                                    <td><?= esc($camp['created_at']) ?></td>
                                    <td>
                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editCampaignModal" 
                                            data-id="<?= esc($camp['id']) ?>" 
                                            data-campaign_name="<?= esc($camp['campaign_name']) ?>" 
                                            data-description="<?= esc($camp['description']) ?>" 
                                            >Edit</button>
                                        <a href="/campaign/delete/<?= esc($camp['id']) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        
                    </table>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?= $pager->links() ?>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Add User Modal -->
             <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserModalLabel">Add Campaign</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                                <form action="/campaign/store" method="post">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <label>Campaign Name :</label>
                                    <input type="text" class="form-control" name="campaign_name" autocomplete="name" placeholder="Enter Campaign name" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Description :</label>
                                    <input type="text" class="form-control" name="description" placeholder="Enter description" required>
                                </div>
                                
                                <br>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit User Modal -->
             <div class="modal fade" id="editCampaignModal" tabindex="-1" aria-labelledby="editCampaignModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCampaignModalLabel">Edit Campaign</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/campaign/update" method="post">
                                <div class="form-group">
                                    <label>Campaign Name :</label>
                                    <input type="text" class="form-control" name="campaign_name" id="editCampName" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Description :</label>
                                    <input type="text" class="form-control" name="description" id="editDesc" required>
                                </div>
                                
                                <input type="hidden" name="id" id="editCampId">
                                <br>
                                <button type="submit" class="btn btn-primary">Update Campaign</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<!-- Filter Modal Form -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <form action="/campaign/filter" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="id" class="form-label">ID</label>
                        <input type="text" class="form-control" id="id" name="id" value="<?= session()->get('filterParams')['id'] ?? '' ?>" placeholder="Enter ID">
                    </div>
                    <div class="mb-3">
                        <label for="campaignname" class="form-label">Campaign Name :</label>
                        <input type="text" class="form-control" name="campaign_name" id="campaign_name" value="<?= session()->get('filterParams')['campaign_name'] ?? '' ?>" placeholder="Enter Campaign name">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description :</label>
                        <input type="text" class="form-control" name="description" id="description" value="<?= session()->get('filterParams')['description'] ?? '' ?>" placeholder="Description">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Apply Filter</button>
                </form>

            </div>
        </div>
    </div>
</div>

 <script>
    // Populate the modal with user data for editing
    $('#editCampaignModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id');
        var campaign_name = button.data('campaign_name');
        var description = button.data('description');
        

        // Update the modal's content
        var modal = $(this);
        modal.find('#editCampId').val(id);
        modal.find('#editCampName').val(campaign_name);
        modal.find('#editDesc').val(description);
        
    });
</script> 


<?= $this->endSection() ?>