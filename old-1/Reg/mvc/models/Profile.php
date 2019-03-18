<?php

Class ProfileModel extends Model
{
    public $table = 'users';

    //можно добавить какую-нибудь скучную валидацию
    public function isValid(){}

    public function getProfile($id)
    {
        $query = "SELECT * FROM $this->table WHERE id = '$id'";

        $result = $this->query($query);

        return $result->fetch_array(MYSQLI_ASSOC);
    }
}