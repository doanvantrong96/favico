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
class Lecturer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lecturer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'office', 'description'], 'required', 'message' => '{attribute} không được trống'],
            [['name', 'avatar','cover'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 400],
            [['trailer','level','position'], 'safe']
        ];
    }
    public function beforeSave($insert){
       
        if( $this->name ){
            $this->slug = \backend\controllers\CommonController::LocDau($this->name);
        }
        return parent::beforeSave($insert);
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Tên giảng viên',
            'avatar' => 'Ảnh đại diện',
            'description' => 'Mô tả',
            'office' => 'Chức danh',
            'level' => 'Cấp bậc',
            'status'=> 'Trạng thái',
            'position' => 'Thứ tự hiển thị'
        ];
    }

    public static function getListLecturer(){
        $result = self::find()->all();
        $data   = [];
        foreach($result as $row){
            $data[$row->id] = $row;
        }

        return $data;
    }
}
