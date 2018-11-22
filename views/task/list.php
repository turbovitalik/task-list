<?php include APP_ROOT . 'views/header.php'; ?>
<div class="row">
    <?php foreach ($tasks as $task) { ?>
    <div class="col-md-4">
        <div class="card mb-4 shadow-sm">
            <img class="card-img-top" src="<?php echo $task->getImage(); ?>" alt="Card image cap">
            <div class="card-body">
                <p class="card-text"><?php echo $task->getText(); ?></p>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted"><?php echo $task->getUsername(); ?></small>
                    <small class="text-muted"><?php echo $task->getEmail(); ?></small>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<?php echo $pagination; ?>

<?php include APP_ROOT . 'views/footer.php'; ?>
