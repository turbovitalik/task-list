<?php include APP_ROOT . 'views/header.php'; ?>
<p><strong>Username:</strong> <?php echo $task->getUsername(); ?></p>
<p><strong>Email:</strong> <?php echo $task->getEmail(); ?></p>
<form method="post" action="/task/store">
    <input type="hidden" name="id" value="<?php echo $task->getId(); ?>" />
    <div class="form-group">
        <label for="text"><strong>Task description:</strong></label>
        <textarea name="text" class="form-control" id="text" rows="3"><?php echo $task->getText(); ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php include APP_ROOT . 'views/footer.php'; ?>