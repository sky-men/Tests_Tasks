<?php

require_once 'Crypt.php';

class Actions
{
    protected static $mysqli;

    protected static function mysqli_init()
    {
        self::$mysqli = new mysqli('localhost', 'root', '123456', 'test');

        if (mysqli_connect_errno())
            throw new Exception('Connect error. '. mysqli_connect_error());
    }

    public static function add_email()
    {
        self::mysqli_init();

        $_POST['email'] = addslashes(strip_tags($_POST['email']));

        $email = explode('@', $_POST['email']);

        if(empty($email[0]) or empty($email[1]))
            throw new Exception('Incorrect email');


        $email[0] = Crypt::encryptText($email[0]);


        $query = "INSERT INTO users SET email = '$email[1]@$email[0]'";

        $result = self::$mysqli->query($query);

        if(!$result)
            throw new Exception('MySQL error. '.self::$mysqli->error);

        return true;
    }

    public static function searchByDomain()
    {
        self::mysqli_init();

        $email_domain = addslashes($_POST['email_domain']);

        $query = "SELECT * FROM users WHERE email LIKE '$email_domain@%'";

        $result = self::$mysqli->query($query);

        if(!$result)
            throw new Exception('MySQL error. '.self::$mysqli->error);

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}