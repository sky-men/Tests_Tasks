<div class="admin_auth">

    <?php
    if (isset($_SESSION['error_mess'])) {
        echo '<div class="alert alert-danger message" role="alert">';

        echo $_SESSION['error_mess'];
        unset($_SESSION['error_mess']);

        echo ' </div>';
    }
    ?>

    <form class="form-inline" action="/admin/auth" method="post">
        <div class="form-group">
            <label for="user">User</label>
            <input type="text" class="form-control" id="user" name="user" placeholder="User">
        </div>
        <div class="form-group">
            <label for="password">Email</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="password">
        </div>
        <button type="submit" class="btn btn-default">OK</button>
    </form>

</div>