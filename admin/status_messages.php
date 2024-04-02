<div class="text-center mx-auto">
    <?php if (isset($_SESSION['status'])) {
        echo $_SESSION['status'];
        unset($_SESSION['status']);
    } ?>
</div>