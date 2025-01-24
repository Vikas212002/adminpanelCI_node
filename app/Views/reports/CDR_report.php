<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">

  <?php $reportTitle = '';
  switch ($repnum) {
    case 1:
      $reportTitle = 'Mysql CDR';
      break;
    case 2:
      $reportTitle = 'MongoDB CDR';
      break;
    case 3:
      $reportTitle = 'Elastic CDR';
      break;
  } ?>
    <h2 class="my-4 text-center text-dark "> <?= $reportTitle ?></h2>
  <div class="text-end">
  <a href="<?= site_url('/download/CDR?flag=') . $repnum ?>" class="btn btn-primary me-2">Download CDR</a>
    <a href="<?= site_url('/summary_reports?flag=') . $repnum ?>" class="btn btn-primary  me-2">Summary Report</a>
    <a href="#" data-bs-toggle="modal" data-bs-target="#filterModal" class="btn btn-primary  me-2">Filter</a>
    </div>

  <div class="table-responsive">
    <table class="table table-striped table-hover table-responsive text-center">
      <thead>
        <tr>
          <th scope="col">date_time</th>
          <th scope="col">type</th>
          <th scope="col">dispose_type</th>
          <th scope="col">dispose_name</th>
          <th scope="col">duration</th>
          <th scope="col">agent_name</th>
          <th scope="col">campaign_name</th>
          <th scope="col">process_name</th>
          <th scope="col">leadset</th>
          <th scope="col">reference_uuid</th>
          <th scope="col">customer_uuid</th>
          <th scope="col">hold</th>
          <th scope="col">mute</th>
          <th scope="col">ringing</th>
          <th scope="col">transfer</th>
          <th scope="col">conference</th>
          <th scope="col">callkey</th>
          <th scope="col">dispose_time</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($reports as $report): ?>
          <tr>
            <td><?= $report['date_time'] ?></td>
            <td><?= $report['type'] ?></td>
            <td><?= $report['dispose_type'] ?></td>
            <td><?= $report['dispose_name'] ?></td>
            <td><?= $report['duration'] ?></td>
            <td><?= $report['agent_name'] ?></td>
            <td><?= $report['campaign_name'] ?></td>
            <td><?= $report['process_name'] ?></td>
            <td><?= $report['leadset'] ?></td>
            <td><?= $report['reference_uuid'] ?></td>
            <td><?= $report['customer_uuid'] ?></td>
            <td><?= $report['hold'] ?></td>
            <td><?= $report['mute'] ?></td>
            <td><?= $report['ringing'] ?></td>
            <td><?= $report['transfer'] ?></td>
            <td><?= $report['conference'] ?></td>
            <td><?= $report['callkey'] ?></td>
            <td><?= $report['dispose_time'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>


<!-- Filter Modal Form -->
<!-- <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="filterModalLabel">Filter Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/reports/filter" method="post">
          <?= csrf_field() ?>
          <div class="mb-3">
            <label for="database" class="form-label">Select Database</label>
            <select class="form-select" id="database" name="database" required>
              <option value="">Select an option</option>
              <option value="Mysql">Mysql</option>
              <option value="MongoDB">MongoDB</option>
              <option value="ElasticSearch">ElasticSearch</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="agent_name" class="form-label">Agent Name</label>
            <input type="text" class="form-control" id="agent_name" name="agent_name" value="" placeholder="Enter Agent Name">
          </div>
          <div class="mb-3">
            <label for="process_name" class="form-label">Process Name</label>
            <input type="text" class="form-control" name="process_name" id="process_name" value="" placeholder="Enter Process Name">
          </div>
          <div class="mb-3">
            <label for="campaign_name" class="form-label">Campaign Name</label>
            <input type="text" class="form-control" name="campaign_name" id="campaign_name" value="" placeholder="Enter Campaign Name">
          </div>
          <div class="mb-3">
            <label for="filter_date" class="form-label">Filter by date</label>
            <input type="date" class="form-control" name="filter_date" id="filter_date">
          </div>
          <input type="hidden" name="flag" id="flag" value="">
          <button type="submit" class="btn btn-primary" id="applyFilter">Apply Filter</button>
        </form>

      </div>
    </div>
  </div>
</div> -->

<!-- Filter Modal Form -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="filterModalLabel">Filter Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/reports/filter" method="getVar">
          <?= csrf_field() ?>
          <div class="mb-3">
            <label for="database" class="form-label">Select Database</label>
            <select class="form-select" id="database" name="database" required>
              <option value="">Select an option</option>
              <option value="Mysql"  data-flag="1">Mysql</option>
              <option value="MongoDB"  data-flag="2">MongoDB</option>
              <option value="ElasticSearch"  data-flag="3">ElasticSearch</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="agent_name" class="form-label">Agent Name</label>
            <input type="text" class="form-control" id="agent_name" name="agent_name"  placeholder="Enter Agent Name">
          </div>
          <div class="mb-3">
            <label for="process_name" class="form-label">Process Name</label>
            <input type="text" class="form-control" name="process_name" id="process_name"  placeholder="Enter Process Name">
          </div>
          <div class="mb-3">
            <label for="campaign_name" class="form-label">Campaign Name</label>
            <input type="text" class="form-control" name="campaign_name" id="campaign_name"  placeholder="Enter Campaign Name">
          </div>
          <div class="mb-3">
            <label for="filter_date" class="form-label">Filter by date</label>
            <input type="date" class="form-control" name="filter_date" id="filter_date">
          </div>
          <input type="hidden" name="flag" id="flag" value="">
          <button type="submit" class="btn btn-primary" id="applyFilter">Apply Filter</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Pagination Links -->
<div class="pagination">
  <?= $pager ?>
</div>
<script>
     
  function setFlag(value) {
    document.getElementById('flag').value = value;
  }
</script>


<?= $this->endSection() ?>