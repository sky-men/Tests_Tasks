<?php

require_once 'libraries/Actions.php';

if (isset($_POST['email']))
    $result_add = Actions::add_email();
elseif (isset($_POST['email_domain']))
    $emails = Actions::searchByDomain();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Блоки</title>
</head>
<body>

<div style="text-align: center; color: blue; font-size: 16px">
    <? if (isset($result_add)) echo 'Success' ?>
</div>

<div>
    <form method="post">
        <input type="text" name="email" value="test@gmail.com">
        <input type="submit" value="Add">
    </form>
</div>

<div style="margin-top: 30px">
    <form method="post">
        <input type="text" name="email_domain" value="gmail.com">
        <input type="submit" value="Search">
    </form>
</div>

<div style="margin-top: 20px">
    <?php
    if (!empty($emails)) {
        echo '<div>Searched:</div>';
        foreach ($emails as $email) {
            $email['email'] = explode('@', $email['email']);
            $email['email'] = Crypt::decryptText($email['email'][1]).'@'.$email['email'][0];

            echo "<div style='margin-top: 10px;'>uid: $email[uid], email: $email[email]</div>";
        }
    }
    ?>
</div>

</body>
</html>
