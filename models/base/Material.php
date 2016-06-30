<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "material".
 *
 * @property integer $id
 * @property string $hash
 * @property string $file_name
 * @property string $thumb_url
 * @property string $created_on
 * @property string $modified_on
 */
class Material extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'material';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hash'], 'required'],
            [['created_on', 'modified_on'], 'safe'],
            [['hash'], 'string', 'max' => 32],
            [['file_name', 'thumb_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hash' => 'Hash',
            'file_name' => 'File Name',
            'thumb_url' => 'Thumb Url',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }
}
