<?php

$this->pageTitle = 'Система управления контентом';

echo "<div class='cms_title'>{$this->pageTitle}</div>";

if (!empty(Yii::app()->user->errors) and !empty(Yii::app()->user->errors['user_file'])) {
    echo "<div class='cms_errorMessage'>" . Yii::app()->user->errors['user_file'][0] . "</div>";
    unset(Yii::app()->user->errors);

}if (!empty(Yii::app()->user->message)) {
    echo "<div class='cms_message'>" . Yii::app()->user->message . "</div>";
    unset(Yii::app()->user->message);
}

?>
<div class="cms_content">
    <?php
    $form = $this->beginWidget(
        'CActiveForm',
        array(
            'action' => $this->createUrl('/cms/default/upload'),
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        )
    );

    echo $form->fileField($model, 'user_file');

    echo CHtml::submitButton('Submit');

    $this->endWidget();

    if(!empty($file_content))
        echo "<div class='cms_file_content'> $file_content </div>";

    ?>
    <ul>
        <?php
        foreach ($files as $file) {

            if ($file == '.' or $file == '..')
                continue;

            echo "<li class='cms_list_files'>
                <a href='{$this->createUrl('/cms/default/read', array('file'=>$file))}'>$file</a>
                <a class='delete' href='{$this->createUrl('/cms/default/delete', array('file'=>$file))}'>Удалить</a>
              </li>";
        }
        ?>
    </ul>
</div>