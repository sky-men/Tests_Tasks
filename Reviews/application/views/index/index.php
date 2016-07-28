<div class="sort_block">
    <form class="form-horizontal">
        <div class="col-sm-10 " style="text-align: right">
            <label for="sort" class="control-label">Сортировка</label>
        </div>
        <div class="col-sm-2">
            <select class="form-control" id="sort">
                <option value="date" <?php selected('date') ?> >Дата</option>
                <option value="name" <?php selected('name') ?> >Имя</option>
                <option value="email" <?php selected('email') ?> >E-mail</option>
            </select>
        </div>
    </form>
</div>

<div style="clear: both"></div>

<?php

function selected($name)
{
    if (isset($_GET['order']) and $_GET['order'] == $name)
        echo 'selected';
}

if (isset($_SESSION['error_mess'])) {
    echo '<div class="alert alert-danger message" role="alert">';

    echo $_SESSION['error_mess'];
    unset($_SESSION['error_mess']);

    echo ' </div>';
} elseif (isset($_SESSION['success_mess'])) {
    echo '<div class="alert alert-success message" role="alert">';

    echo $_SESSION['success_mess'];
    unset($_SESSION['success_mess']);

    echo ' </div>';
}
?>

<div id="reviews">
    <?php
    if (!empty($reviews)) {
        foreach ($reviews as $review) { ?>
            <div>
                <div class="user_info">
                    <span class="user"><?php echo $review['name'] ?></span>
                    <span>(<?php echo $review['email'] ?>)</span>
                    <span> <?php echo $review['date'] ?> </span>
                </div>

                <div class="review">
                    <?php echo $review['review'] ?>
                </div>

                <?php
                if (isset($_SESSION['admin'])) {
                    ?>
                    <div class="admin_review_action">
                        <span class="admin_review_action_title">Статус: </span>
                        <?php
                        if ($review['on_moderation'])
                            echo '<span class="admin_onModeration">На модерации</span>';
                        elseif ($review['accepted'])
                            echo '<span class="admin_accepted">Одобрен</span>';
                        elseif ($review['rejected'])
                            echo '<span class="admin_rejected">Отклонен</span>';

                        if($review['changed'])
                            echo ' (изменен ранее администраторм)';
                        ?>
                        <span class="admin_review_action_title">Действия:</span>
                        <a href="/admin/update/?review_id=<?php echo $review['id'] ?>">Редактировать</a>
                        <a href="/admin/accept/?review_id=<?php echo $review['id'] ?>">Одобрить</a>
                        <a href="/admin/reject/?review_id=<?php echo $review['id'] ?>">Отклонить</a>
                        <a href="/admin/onModeration/?review_id=<?php echo $review['id'] ?>">На модерацию</a>
                    </div>
                    <?php
                }

                if (!empty($review['image'])) {
                    $config = require APPLICATION_PATH . '/configs/config.php';
                    $img = $config['upload_dir'] . $review['image'];
                    ?>
                    <div class="review_img">
                        <a href="<?php echo $img ?>" target="_blank">
                            <img src="<?php echo $img ?>">
                        </a>
                    </div>
                <?php } ?>

            </div>
            <div class="line"></div>
            <?php
            unset($review);
        }
    }
    ?>
</div>

<?php

require realpath(__DIR__ . '/../common_blocks/review_form.php');