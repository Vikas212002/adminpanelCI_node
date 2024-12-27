<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
// Include the chat.html file
include '../public/assets/html/chat.html';

// include '../public/assets/css/chat.css';
?>

<link rel="stylesheet" href="<?= base_url('assets/css/chat.css'); ?>">
<script src="<?= base_url('assets/js/chat.js'); ?>"></script>
<!-- <script src="https://cdn.socket.io/4.8.1/socket.io.min.js"></script> -->
<!-- <script>
    const socket = io('http://localhost:3000');
</script> -->

<?= $this->endSection() ?>
