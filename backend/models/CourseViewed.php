<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

class CourseViewed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_viewed';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID'
        ];
    }

    public static function saveCourseViewed($id, $date){
        $model = self::findOne(['course_id' => $id, 'date' => $date]);
        if( !$model ){
            $model              = new CourseViewed;
            $model->course_id   = $id;
            $model->date        = $date;
            $model->total_view  = 1;
        }else{
            $model->total_view  = $model->total_view + 1;
        }
       
        $model->save(false);
    }
}
