<?php

namespace backend\models;

use yii\db\Query;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
 
/**
 * This is the model class for table "category_tags".
 *
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property string $create_date
 * @property string $slug
 * @property string $except
 * @property string $title_seo
 * @property integer $user_create
 * @property integer $is_delete
 */
class CategoryTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_tags';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'message' => '{attribute} không được trống'],
            [['id', 'user_create', 'is_delete'], 'integer'],
            [['create_date','is_parent'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['slug', 'title_seo'], 'string', 'max' => 255],
            [['except'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Loại'),
            'name' => Yii::t('app', 'Tên chuyên mục'),
            'create_date' => Yii::t('app', 'Ngày tạo'),
            'slug' => Yii::t('app', 'Link url'),
            'except' => Yii::t('app', 'Mô tả'),
            'title_seo' => Yii::t('app', 'Tiêu đề SEO'),
            'user_create' => Yii::t('app', 'Người tạo'),
            'is_delete' => Yii::t('app', 'Xóa Mềm'),
            'status' => Yii::t('app', 'Trạng thái'),
        ];
    }

    public static function _getEmployee($id)
    {
        $query = new Query;
        $query->select(['fullname'])->from('employee')->where(['id' => $id]);
        $command = $query->createCommand();
        $data = $command->queryOne();
        if(!empty($data['fullname'])){
            return $data['fullname'];
        }
        return "";
    }


}