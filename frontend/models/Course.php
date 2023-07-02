<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "course".
 *
 * @property integer $id
 * @property string $name
 * @property string $avatar
 * @property integer $coach_id
 * @property string $create_date
 * @property integer $category_id
 * @property string $category_name
 * @property string $description
 * @property integer $total_learn
 * @property integer $total_hours_learn
 * @property integer $total_lessons
 * @property string $level
 * @property double $price
 * @property double $promotional_price
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'total_hours_learn', 'total_lessons','description'], 'required', 'message' => '{attribute} không được trống'],
            [['coach_id', 'category_id', 'total_learn', 'total_hours_learn', 'total_lessons'], 'integer'],
            [['create_date','price','promotional_price','avatar'], 'safe'],
            [['description'], 'string'],
            [['status'], 'number'],
            [['name', 'category_name'], 'string', 'max' => 255],
            [['avatar'], 'string', 'max' => 300],
            [['level'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Mã khoá học',
            'name' => 'Tên khoá học',
            'avatar' => 'Avatar',
            'coach_id' => 'Huấn luyện viên',
            'create_date' => 'Ngày tạo',
            'category_id' => 'Chuyên mục',
            'category_name' => 'Chuyên mục',
            'description' => 'Mô tả khoá học',
            'total_learn' => 'Số người đã học',
            'total_hours_learn' => 'Số tiếng học theo yêu cầu',
            'total_lessons' => 'Số bài học',
            'level' => 'Trình độ',
            'price' => 'Giá',
            'promotional_price' => 'Giá khuyến mại',
            'status' => 'Trạng thái'
        ];
    }
}
