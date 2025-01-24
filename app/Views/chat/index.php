<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
include '../public/assets/html/chat.php';
?>

<link rel="stylesheet" href="<?= base_url('assets/css/chat.css'); ?>">
<script src="<?= base_url('assets/js/chat.js'); ?>"></script>

<?= $this->endSection() ?>
