<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h2>Admin Panel</h2>

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
            <h1 class="text-center">User Management</h1>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Users Data
                        <a href="#" data-bs-toggle="modal" data-bs-target="#filterModal" class="btn btn-primary float-end">FILTER</a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addUserModal" class="btn btn-primary float-end me-2">Add Data</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="usersTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>DOB</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= esc($user['id']) ?></td>
                                    <td><?= esc($user['name']) ?></td>
                                    <td><?= esc($user['phone']) ?></td>
                                    <td><?= esc($user['dob']) ?></td>
                                    <td><?= esc($user['role']) ?></td>
                                    <td><?= esc($user['created_at']) ?></td>
                                    <td>
                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal"
                                            data-id="<?= esc($user['id']) ?>"
                                            data-name="<?= esc($user['name']) ?>"
                                            data-phone="<?= esc($user['phone']) ?>"
                                            data-dob="<?= esc($user['dob']) ?>"
                                            data-role="<?= esc($user['role']) ?>">Edit</button>
                                        <a href="/admin/delete/<?= esc($user['id']) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
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
                            <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/admin/store" method="post">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <label>Name :</label>
                                    <input type="text" class="form-control" name="name" autocomplete="name" placeholder="Enter name" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Phone :</label>
                                    <input type="text" class="form-control" name="phone" placeholder="Enter phone number" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label>DOB :</label>
                                    <input type="date" class="form-control" name="dob" id="dob" placeholder="DD/MM/YYYY">
                                </div>
                                <div class="form-group">
                                    <label for="role">Role :</label>
                                    <select name="role" class="form-control">
                                        <option value="admin">Admin</option>
                                        <option value="supervisor">Supervisor</option>
                                        <option value="teamleader">Teamleader</option>
                                        <option value="agent">Agent</option>
                                    </select>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Add User</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit User Modal -->
            <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/admin/update" method="post">
                                <div class="form-group">
                                    <label>Name :</label>
                                    <input type="text" class="form-control" name="name" id="editName" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Phone :</label>
                                    <input type="text" class="form-control" name="phone" id="editPhone" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label>DOB :</label>
                                    <input type="date" class="form-control" name="dob" id="editDob" value="" placeholder="DD/MM/YYYY" required>
                                </div>
                                <div class="form-group">
                                    <label for="role">Role :</label>
                                    <select name="role" class="form-control" id="editRole">
                                        <option value="admin">Admin</option>
                                        <option value="supervisor">Supervisor</option>
                                        <option value="teamleader">Teamleader</option>
                                        <option value="agent">Agent</option>
                                    </select>
                                </div>
                                <input type="hidden" name="id" id="editUserId">
                                <br>
                                <button type="submit" class="btn btn-primary">Update User</button>
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
                <form action="/admin/filter" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= session()->get('filterParams')['name'] ?? '' ?>" placeholder="Enter name">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone :</label>
                        <input type="text" class="form-control" name="phone" id="phone" value="<?= session()->get('filterParams')['phone'] ?? '' ?>" placeholder="Enter phone">
                    </div>
                    <div class="mb-3">
                        <label for="dob" class="form-label">DOB :</label>
                        <input type="date" class="form-control" name="dob" id="dob" value="<?= session()->get('filterParams')['dob'] ?? '' ?>" placeholder="DD/MM/YYYY">
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Role</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">Select an option</option>
                            <option value="Admin" <?= (session()->get('filterParams')['role'] ?? '') === 'Admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="Supervisor" <?= (session()->get('filterParams')['role'] ?? '') === 'Supervisor' ? 'selected' : '' ?>>Supervisor</option>
                            <option value="Teamleader" <?= (session()->get('filterParams')['role'] ?? '') === 'Teamleader' ? 'selected' : '' ?>>Teamleader</option>
                            <option value="Agent" <?= (session()->get('filterParams')['role'] ?? '') === 'Agent' ? 'selected' : '' ?>>Agent</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" id="applyFilter">Apply Filter</button>
                   
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Populate the modal with user data for editing
    $('#editUserModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id');
        var name = button.data('name');
        var phone = button.data('phone');
        var dob = button.data('dob');
        var role = button.data('role');

        // Update the modal's content
        var modal = $(this);
        modal.find('#editUserId').val(id);
        modal.find('#editName').val(name);
        modal.find('#editPhone').val(phone);
        modal.find('#editDob').val(dob);
        modal.find('#editRole').val(role);
    });
</script>

<?= $this->endSection() ?>
