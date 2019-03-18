<?php

namespace app\parsers;

use \yii\db\ActiveRecord;

class Model extends ActiveRecord
{
    public static function tableName()
    {
        return 'rutracker';
    }

    /**
     * Удаление дублей, если есть
     *
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $dub = self::find()
            ->where(['url_hash' => $this->url_hash])
            ->exists();

        if ($dub)
            self::deleteAll(['url_hash' => $this->url_hash]);

        return parent::beforeSave($insert);
    }
}