<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "coach_course".
 *
 * @property integer $id
 * @property string $name
 * @property string $avatar
 * @property string $description
 */
class Partner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','image'], 'required', 'message' => '{attribute} không được trống'],
            [['link','status', 'position'], 'safe']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Tên đối tác',
            'image' => 'Ảnh',
            'link'  => 'Đường dẫn liên kết',
            'status' => 'Trạng thái',
            'position' => 'Thứ tự hiển thị'
        ];
    }

}
