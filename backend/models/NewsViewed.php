<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

class NewsViewed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_viewed';
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

    public static function saveNewsViewed($id, $date){
        $model = NewsViewed::findOne(['news_id' => $id, 'date' => $date]);
        if( !$model ){
            $model = new NewsViewed;
            $model->news_id     = $id;
            $model->date        = $date;
            $model->total_view  = 1;
        }else{
            $model->total_view  = $model->total_view + 1;
        }
       
        $model->save(false);
    }
}
