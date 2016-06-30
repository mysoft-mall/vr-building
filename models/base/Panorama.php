<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "panorama".
 *
 * @property integer $id
 * @property string $title
 * @property string $hash
 * @property string $thumb_url
 * @property string $created_on
 * @property string $modified_on
 */
class Panorama extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'panorama';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_on', 'modified_on'], 'safe'],
            [['title', 'hash', 'thumb_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'hash' => 'Hash',
            'thumb_url' => 'Thumb Url',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }
}
