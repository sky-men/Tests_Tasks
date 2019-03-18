<?php


class UploadForm extends CFormModel
{
    public $user_file;

    public function rules()
    {
        return array(
            array('user_file', 'file', 'types'=>'txt', 'mimeTypes'=>'text/plain', 'maxSize'=>2097000),
        );
    }
}