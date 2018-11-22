<?php include APP_ROOT . 'views/header.php'; ?>
<p><strong>Username:</strong> <?php echo $task->getUsername(); ?></p>
<p><strong>Email:</strong> <?php echo $task->getEmail(); ?></p>
<form method="post" action="/task/store">
    <input type="hidden" name="id" value="<?php echo $task->getId(); ?>" />
    <div class="form-group">
        <label for="text"><strong>Task description:</strong></label>
        <textarea name="text" class="form-control" id="text" rows="3"><?php echo $task->getText(); ?></textarea>
    </div>
    <div class="form-group form-check">
        <input type="hidden" name="done" value="0" />
        <input <?php echo $task->getDone() ? 'checked="checked"' : ''; ?> name="done" value="1" type="checkbox" class="form-check-input" id="status">
        <label class="form-check-label" for="status">Done</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php include APP_ROOT . 'views/footer.php'; ?>