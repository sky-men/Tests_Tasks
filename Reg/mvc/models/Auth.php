<?php

Class AuthModel extends Model
{
    public $table = 'users';

    public function checkLogin()
    {
        $query = "SELECT * FROM $this->table WHERE email = '$_POST[email]' and password = '$_POST[password]' LIMIT 1";

        $result = $this->query($query);

        $row = $result->fetch_array(MYSQLI_ASSOC);

        if(!$row)
            return false;

        return $row;
    }
}