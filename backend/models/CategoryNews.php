<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

class CategoryNews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_news';
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

    public static function saveData($news_id, $cateIds = []){

        Yii::$app->db->createCommand()
        ->delete(self::tableName(), ['news_id' => $news_id])
        ->execute();

        if( !empty($cateIds) ){
            $createArr = [];
            foreach ($cateIds as $cateId) {
                $createArr[] = [$news_id, $cateId];
            }
            Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['news_id', 'category_id'], $createArr)->execute();
        }
    }
}
