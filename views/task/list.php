<?php include APP_ROOT . 'views/header.php'; ?>
<?php if ($isAdmin) { ?>
    <p class="text-success">Now you are admin and can EDIT!</p>
<?php } else { ?>
    <p class="text-warning">Unknown user</p>
<?php } ?>
<p></p>
<p>
    <a class="btn btn-primary" href="/task/list?sortBy=username&order=asc&page=1" role="button">Sort by username (asc)</a>
    <a class="btn btn-primary" href="/task/list?sortBy=username&order=desc&page=1" role="button">Sort by username (desc)</a>
</p>
<p>
    <a class="btn btn-primary" href="/task/list?sortBy=email&order=asc&page=1" role="button">Sort by email (asc)</a>
    <a class="btn btn-primary" href="/task/list?sortBy=email&order=desc&page=1" role="button">Sort by email (desc)</a>
</p>
<p>
    <a class="btn btn-primary" href="/task/list?sortBy=done&order=asc&page=1" role="button">Sort by status (asc)</a>
    <a class="btn btn-primary" href="/task/list?sortBy=done&order=desc&page=1" role="button">Sort by status (desc)</a>
</p>
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
                <p></p>
                <div class="btn-group">
                    <?php
                    $btnClass = $task->getDone() ? 'success' : 'warning';
                    ?>
                    <button type="button" class="btn btn-sm btn-<?php echo $btnClass; ?>"><?php echo $task->isDone(); ?></button>
                    <?php if ($isAdmin) { ?>
                        <a class="btn btn-sm btn-info" href="/task/edit?id=<?php echo $task->getId(); ?>">Edit</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<?php echo $pagination; ?>

<?php include APP_ROOT . 'views/footer.php'; ?>
