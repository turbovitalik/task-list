<?php include APP_ROOT . 'views/header.php'; ?>
<form method="post" action="/login/check">
    <div class="form-group">
        <label for="username">Username</label>
        <input name="username" type="text" class="form-control" id="username" placeholder="Name">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input name="password" type="password" class="form-control" id="password" placeholder="name@example.com">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php include APP_ROOT . 'views/footer.php'; ?>