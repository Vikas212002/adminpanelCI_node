<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<div class="container mt-4">
  <h2 class="my-4 text-center text-dark">Summarized Hourly Report <a href="/mysql/summary/download" class="btn btn-primary float-end">Download CSV</a> </h2>
  
  <div class="table-responsive">
    <table class="table table-striped table-hover table-responsive text-center">
      <thead>
        <tr>
          <th scope="col">hour</th>
          <th scope="col">totalCalls</th>
          <th scope="col">totalHoldTime</th>
          <th scope="col">totalTalkTime</th>
          <th scope="col">totalDisposeTime</th>
          <th scope="col">totalDuration</th>
          <th scope="col">totalMuteTime</th>
          <th scope="col">totalConferenceTime</th>
          <th scope="col">totalProcesses</th>
          <th scope="col">totalCampaigns</th>
          
        </tr>
      </thead>
      <tbody>
      <?php foreach ($reports as $report): ?>
          <tr>
            <td><?= $report['hour'] ?></td>
            <td><?= $report['totalCalls'] ?></td>
            <td><?= $report['totalHoldTime'] ?></td>
            <td><?= $report['totalTalkTime'] ?></td>
            <td><?= $report['totalDisposeTime'] ?></td>
            <td><?= $report['totalDuration'] ?></td>
            <td><?= $report['totalMuteTime'] ?></td>
            <td><?= $report['totalConferenceTime'] ?></td>
            <td><?= $report['totalProcesses'] ?></td>
            <td><?= $report['totalCampaigns'] ?></td>
            
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="pagination">
  <?= $pager ?>
</div>



<?= $this->endSection() ?>


