<?php
$title = $_SERVER['APP_NAME'];
?>

<?php require COMPONENTS . '/head.php' ?>

<?php require COMPONENTS . '/navbar.php' ?>

<?php require COMPONENTS . '/error.php' ?>


<script>
removeCookie('access_token');
window.location.href = '/';
</script>

<?php require COMPONENTS . '/foot.php' ?>
