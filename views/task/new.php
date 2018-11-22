<?php include APP_ROOT . 'views/header.php'; ?>
<form method="post" action="/task/store">
    <div class="form-group">
        <label for="username">Username</label>
        <input name="username" type="text" class="form-control" id="username" placeholder="Name">
    </div>
    <div class="form-group">
        <label for="email">Email address</label>
        <input name="email" type="email" class="form-control" id="email" placeholder="name@example.com">
    </div>
    <div class="form-group">
        <label for="text">Task description</label>
        <textarea name="text" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php include APP_ROOT . 'views/footer.php'; ?>