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
class CommunityStory extends \yii\db\ActiveRecord
{
    const STATUS_PENDING   = 0;
    const STATUS_APPROVED  = 1;
    const STATUS_REJECT    = 2;
    const ACTIVE           = 1;
    const INACTIVE         = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'community_story';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content','image','address'], 'required', 'message' => '{attribute} không được trống'],
            [['status','address','file_path','expert_name','position'], 'safe']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Tên câu chuyện',
            'expert_name' => 'Tên chuyên gia',
            'image' => 'Ảnh câu chuyên',
            'address' => 'Địa chỉ',
            'status' => 'Trạng thái',
            'is_active' => 'Hiển thị',
            'position' => 'Thứ tự hiển thị'
        ];
    }

}
