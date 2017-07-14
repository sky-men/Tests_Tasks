<div>
    <form action="/profile/update/" method="post" enctype="application/x-www-form-urlencoded" class="form-horizontal">
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <?php
                if (!empty($_SESSION['success_mess'])) {
                    echo "<p class='bg-primary'>{$_SESSION['success_mess']}</p>";
                    unset($_SESSION['success_mess']);
                }

                if (!empty($_SESSION['error_mess'])) {
                    echo "<p class='bg-danger'>{$_SESSION['error_mess']}</p>";
                    unset($_SESSION['error_mess']);
                }
                ?>
            </div>
        </div>


        <div class="form-group">
            <label class="col-sm-2 control-label">Email:</label>

            <div class="col-sm-10">
                <?php
                echo $this->user['email'];
                if (!empty($this->user['confirm_hash']))
                    echo ' (не подтвержден) ';
                ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">ФИО:</label>

            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" maxlength="100"
                       value="<?php echo $this->user['name'] ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Адрес:</label>

            <div class="col-sm-10">
                <input type="text" name="address" class="form-control" maxlength="100"
                       value="<?php echo $this->user['address'] ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Тел:</label>

            <div class="col-sm-10">
                <input type="tel" name="tel" class="form-control" maxlength="12"
                       value="<?php echo $this->user['tel'] ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <?php
                if($this->owner) {
                    echo '<button type="submit" class="btn btn-primary">Обновить</button> ';
                    echo '<a class="btn btn-primary" href="/auth/logout/" role="button">Выход</a>';
                }
                ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="text-primary history_link"><a href="#" id="auth_history_link">Открыть историю авторизаций (последние 5):</a></div>
                <div id="auth_history">
                    <?php
                    if(!empty($this->logs)) {
                        foreach ($this->logs as $value)
                            echo "<div>$value[date] / $value[ip] / $value[browser]</div>";
                    }
                    else
                        echo "<div>Еще не авторизировался</div>";
                    ?>
                </div>
            </div>
        </div>

    </form>
</div>