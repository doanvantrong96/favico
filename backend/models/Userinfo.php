<?php 

namespace backend\models;
use Yii;
use yii\helpers\Html;
class Userinfo extends \yii\db\ActiveRecord{
	public $userRole;
	public static function tableName()
    {
        return 'employee';
    }
	public static function getDb(){
		return Yii::$app->db;
	}
	

	public static function findIdentity($id){
		return static::findOne(['id' => $id]);
	}
}