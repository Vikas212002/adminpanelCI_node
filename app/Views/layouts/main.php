<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="<?php echo base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
</head>

<style>
    .pagination {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .pagination a {
        border: 1px solid #ddd;
        padding: 8px 16px;
        margin: 0 5px;
        text-decoration: none;
        color: #007bff;
        background-color: #f8f9fa;
    }

    .pagination a:hover {
        background-color: #ddd;
    }

    .pagination .active a {
        background-color: #007bff;
        color: white;
        border: 1px solid #007bff;
    }
</style>

<body>
    <!-- Navbar -->

    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container-fluid">
            <img src="/assets/slashrtclogo.png" class="me-2" style="height: 25px; width: 25px;" alt="">
            <div class="d-flex align-items-end justify-content-between gap-4">
                <h4>Welcome! <?= session()->get('name'); ?></h4>
                <a href="/logout" class="btn btn-info">Logout</a>
            </div>
        </div>
    </nav>



    <div class="container-fluid mt-2">
        <div class="d-flex flex-wrap justify-content-center align-items-center" style="width: 100%;">
            <div class="d-flex flex-wrap justify-content-center align-items-center w-100">
                <a href="#" class="nav-link link-dark mx-3"><img src="/assets/dashboard.png" style="height: 25px; width: 25px;" alt=""> Dashboard</a>
                <a href="#" class="nav-link link-dark mx-3"><img src="/assets/live.png" style="height: 25px; width: 25px;" alt=""> Live</a>
                <div class="dropdown mx-3">
                    <button class="btn btn-link link-dark dropdown-toggle text-decoration-none" type="button" id="operationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="/assets/operations.png" class="me-2" style="height: 25px; width: 25px;" alt=""> Reports
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="operationsDropdown">
                        <li><a class="dropdown-item" href="#" onclick="setFlag(2)">MongoDB Report</a></li>
                        <li><a class="dropdown-item" href="#" onclick="setFlag(1)">MySQL Report</a></li>
                        <li><a class="dropdown-item" href="#" onclick="setFlag(3)">Elastic Search Report</a></li>
                    </ul>
                    <div style="display: none;">
                        <form id="reportForm" method="get" action="<?= base_url('/reports') ?>">
                            <input type="hidden" id="flag" name="flag" value="">
                        </form>
                    </div>

                </div>
                <a href="#" class="nav-link link-dark mx-3"><img src="/assets/conversations.png" style="height: 25px; width: 25px;" alt=""> Conversations</a>
                <a href="#" class="nav-link link-dark mx-3"><img src="/assets/contacts.png" style="height: 25px; width: 25px;" alt=""> Contacts</a>
                <div class="dropdown mx-3">
                    <button class="btn btn-link link-dark dropdown-toggle text-decoration-none" type="button" id="operationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="/assets/operations.png" class="me-2" style="height: 25px; width: 25px;" alt=""> Operations
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="operationsDropdown">
                        <li><a class="dropdown-item" href="/admin">Users</a></li>
                        <li><a class="dropdown-item" href="#">Access Level</a></li>
                        <li><a class="dropdown-item" href="/campaigns/home">Campaigns</a></li>
                        <li><a class="dropdown-item" href="/chat/index">Chat</a></li>
                    </ul>
                </div>
                <a href="#" class="nav-link link-dark mx-2"><img src="/assets/advancedsettings.png" class="me-2" style="height: 25px; width: 25px;" alt=""> Advanced settings</a>
                <div class="d-flex justify-content-center mt-2">
                    <input type="text" class="form-control mx-2" id="date-range" placeholder="Select date range" readonly>
                    <button class="btn btn-sm btn-outline-secondary" type="button" id="date-range-button">
                        <img src="/assets/calendar.png" style="height: 20px; width: 20px;" alt="">
                    </button>
                    <button id="go-button" class="btn btn-sm btn-primary mx-2">Go</button>
                </div>
            </div>
            <!-- Date Picker and Go Button -->
        </div>
    </div>



    <!-- Include jQuery and a date range picker library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $(function() {
            $('#date-range').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'YYYY-MM-DD'
                }
            }, function(start, end, label) {
                $('#date-range').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            });
        });
    </script>

    <!-- Main Content -->
    <div class="container mt-4">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
</body>

</html>

<script>
    function setFlag(value) {
        document.getElementById('flag').value = value;
        document.forms[0].submit();
    }
</script>