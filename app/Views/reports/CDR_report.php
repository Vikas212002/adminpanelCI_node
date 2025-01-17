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

  <h2 class="my-4 text-center text-dark"> <?= $reportTitle ?> <a href="<?= site_url('/download/CDR?flag=') . $repnum ?>" class="btn btn-primary float-end">Download CDR</a>
  <a href="<?= site_url('/summary_reports?flag=') . $repnum ?>" class="btn btn-primary float-end me-2">Summary Report</a>
</h2>

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

<!-- Pagination Links -->
<div class="pagination">
  <?= $pager ?>
</div>
<?= $this->endSection() ?>