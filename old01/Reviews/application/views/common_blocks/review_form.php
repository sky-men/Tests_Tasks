<div class="form">
    <form enctype="multipart/form-data" method="post" action="/reviews/send">

        <?php
        $route = Route::getRoute();

        if($route['action'] == 'update' and isset($_SESSION['admin']))
            echo "<input type='hidden' name='update' value='$review[id]' >"
        ?>

        <div class="form-group user_info_inputs">
            <label for="name">Имя</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Имя" required maxlength="30" value="<?php echo @$review['name'] ?>">
        </div>

        <div class="form-group user_info_inputs">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required
                   maxlength="30" value="<?php echo @$review['email'] ?>">
        </div>

        <div class="form-group">
            <label for="review">Отзыв</label>
                <textarea id="review" name="review" class="form-control" rows="5" placeholder="Отзыв" required
                          maxlength="1000"><?php echo @$review['review'] ?></textarea>
        </div>

        <div class="form-group">
            <label for="image">Рисунок</label>
            <input type="file" id="image" name="image">
        </div>

        <?php
        if($route['action'] !== 'update')
            echo '<button id="preview" class="btn btn-default" type="button">Предварительный просмотр</button>';
        ?>

        <button type="submit" class="btn btn-default">Отправить</button>
    </form>
</div>
