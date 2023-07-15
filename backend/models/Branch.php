<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "branch".
 *
 * @property integer $id
 * @property string $name
 * @property string $avatar
 * @property string $description
 */
class Branch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'branch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['loc_x','loc_y','content','size'],'required','message'=>'Nhập {attribute}'],
            [['image'], 'required', 'message' => '{attribute} không được trống'],
            [['status','loc_x','loc_y','content','size'], 'safe']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Icon tọa độ',
            'status'=> 'Trạng thái',
            'loc_x'=> 'Tọa độ X (0 -> 572)',
            'loc_y'=> 'Tọa độ Y (0 -> 537)',
            'size' => 'Kích thước Icon tọa độ (chiều rộng - mặc định là 31)'
        ];
    }

}
