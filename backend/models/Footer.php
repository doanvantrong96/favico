<?php

namespace backend\models;

use Yii;
use yii\db\Query;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class Footer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'footer';
    }

    /**
     * @inheritdoc
     */
    
    /**
     * @inheritdoc
     */
    
    public static function primaryKey()
    {
        return ["id"];
    }

    public function selectOne ($id) {
        $query = new Query;
        // compose the query
        $query->select('id')
            ->from('news')
            ->limit(10);
        // build and execute the query
        $rows = $query->all();
        // alternatively, you can create DB command and execute it
        $command = $query->createCommand();
        // $command->sql returns the actual SQL
        $rows = $command->queryAll();
        echo "<pre>";
        print_r($rows);die;
    }

   
}
